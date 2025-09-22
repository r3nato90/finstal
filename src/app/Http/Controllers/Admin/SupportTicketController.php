<?php

namespace App\Http\Controllers\Admin;

use App\Concerns\UploadedFile;
use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\SupportTicketAttachment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SupportTicketController extends Controller
{
    use UploadedFile;

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = SupportTicket::with(['user', 'assignedTo', 'replies'])->withCount('replies');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority') && !empty($request->priority)) {
            $query->where('priority', $request->priority);
        }

        if ($request->has('assigned_to') && !empty($request->assigned_to)) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $sortField = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        $tickets = $query->paginate(20)->withQueryString();

        $stats = [
            'totalTickets' => SupportTicket::count(),
            'openTickets' => SupportTicket::where('status', 'open')->count(),
            'inProgressTickets' => SupportTicket::where('status', 'in_progress')->count(),
            'urgentTickets' => SupportTicket::where('priority', 'urgent')->count(),
        ];

        $statusColors = [
            '0' => 'primary',    // open
            '1' => 'warning',    // in_progress
            '2' => 'success',    // resolved
            '3' => 'secondary'   // closed
        ];

        $priorityColors = [
            'low' => 'info',
            'medium' => 'primary',
            'high' => 'warning',
            'urgent' => 'danger'
        ];

        return view('admin.support-tickets.index', compact(
            'tickets',
            'stats',
            'statusColors',
            'priorityColors'
        ));
    }

    /**
     * @param SupportTicket $ticket
     * @return View
     */
    public function show(SupportTicket $ticket): View
    {
        $ticket->load([
            'user',
            'assignedTo',
            'replies.user',
            'replies.attachments',
            'attachments'
        ]);

        $statusColors = [
            'open' => 'primary',
            'in_progress' => 'warning',
            'resolved' => 'success',
            'closed' => 'secondary'
        ];

        return view('admin.support-tickets.show', compact(
            'ticket',
            'statusColors',
        ));
    }

    /**
     * Admin reply to support ticket
     * @param Request $request
     * @param SupportTicket $ticket
     * @return RedirectResponse
     */
    public function reply(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:5000',
            'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt,zip',
            'change_status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // Create admin reply
        $reply = SupportTicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => 1,
            'message' => $request->message,
            'is_admin_reply' => true,
        ]);

        // Handle file attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $mimeType = $file->getClientMimeType();
                $fileSize = $file->getSize();

                $filename = $this->move($file);
                if ($filename) {
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
        }

        // Update ticket status if requested
        if ($request->change_status) {
            $newStatus = match ($ticket->status) {
                'open' => 'in_progress',
                'closed' => 'in_progress',
                default => $ticket->status
            };

            if ($newStatus !== $ticket->status) {
                $ticket->update(['status' => $newStatus]);
            }
        }

        return back()->with('success', 'Reply added successfully');
    }

    /**
     * Update ticket status
     * @param Request $request
     * @param SupportTicket $ticket
     * @return RedirectResponse
     */
    public function updateStatus(Request $request, SupportTicket $ticket): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $ticket->update([
            'status' => $request->status,
            'resolved_at' => $request->status === 'resolved' ? now() : null,
        ]);

        $statusText = match($request->status) {
            'open' => 'Open',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
        };

        return back()->with('success', "Ticket status updated to {$statusText} successfully");
    }

    /**
     * Download attachment
     * @param SupportTicketAttachment $attachment
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadAttachment(SupportTicketAttachment $attachment): \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return $this->download($attachment->file_path);
    }
}
