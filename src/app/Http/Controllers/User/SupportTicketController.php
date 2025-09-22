<?php

namespace App\Http\Controllers\User;

use App\Concerns\UploadedFile;
use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\SupportTicketAttachment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SupportTicketController extends Controller
{
    use UploadedFile;

    /**
     * Display a listing of support tickets
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = SupportTicket::where('user_id', auth()->id())
            ->with(['replies'])
            ->withCount('replies');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $sortField = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $tickets = $query->paginate(10)->withQueryString();

        return view('user.support-tickets.index', [
            'tickets' => $tickets,
            'filters' => $request->only(['search', 'status', 'sort_field', 'sort_direction']),
        ]);
    }

    /**
     * Display the specified support ticket
     *
     * @param SupportTicket $ticket
     * @return View
     */
    public function show(SupportTicket $ticket): View
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $ticket->load([
            'user',
            'assignedTo',
            'replies.user',
            'replies.attachments',
            'attachments'
        ]);

        return view('user.support-tickets.show', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Show the form for creating a new support ticket
     *
     * @return View
     */
    public function create(): View
    {
        return view('user.support-tickets.create');
    }

    /**
     * Store a newly created support ticket
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'category' => 'nullable|string|max:100',
            'priority' => 'required|in:low,medium,high,urgent',
            'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt,zip',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ticket = SupportTicket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'category' => $request->category,
            'priority' => $request->priority,
            'status' => 'open',
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $mimeType = $file->getClientMimeType();
                $fileSize = $file->getSize();

                $filename = $this->move($file);
                SupportTicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'filename' => $filename,
                    'original_name' => $originalName,
                    'file_path' => $filename,
                    'file_type' => $mimeType,
                    'file_size' => $fileSize,
                ]);
            }
        }

        return redirect()->route('user.support-tickets.show', $ticket)
            ->with('success', 'Support ticket created successfully. Our team will respond soon.');
    }

    /**
     * Add a reply to the support ticket
     *
     * @param Request $request
     * @param SupportTicket $ticket
     * @return RedirectResponse
     */
    public function reply(Request $request, SupportTicket $ticket): RedirectResponse
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:5000',
            'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt,zip',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $reply = SupportTicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'is_admin_reply' => false,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $mimeType = $file->getClientMimeType();
                $fileSize = $file->getSize();

                $filename = $this->move($file);
                SupportTicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'ticket_reply_id' => $reply->id,
                    'filename' => $filename,
                    'original_name' => $originalName,
                    'file_path' => $filename,
                    'file_type' => $mimeType,
                    'file_size' => $fileSize,
                ]);
            }
        }

        if (in_array($ticket->status, ['closed', 'resolved'])) {
            $ticket->update(['status' => 'open']);
        }

        return back()->with('success', 'Reply added successfully');
    }

    /**
     * Download support ticket attachment
     *
     * @param SupportTicketAttachment $attachment
     * @return Response|BinaryFileResponse
     */
    public function downloadAttachment(SupportTicketAttachment $attachment): Response|BinaryFileResponse
    {
        return $this->download($attachment->file_path);
    }
}
