<?php

namespace App\Http\Controllers\Admin;

use App\Concerns\UploadedFile;
use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ZipArchive;

class KycVerificationController extends Controller
{
    use UploadedFile;

    public function index(Request $request)
    {
        $query = KycVerification::with(['user']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $verifications = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->all());

        return view('admin.kyc_verifications.index', compact('verifications'))
            ->with('filters', [
                'search' => $request->get('search'),
                'status' => $request->get('status'),
            ]);
    }

    public function show(KycVerification $kycVerification)
    {
        $kycVerification->load(['user']);
        return view('admin.kyc_verifications.show', compact('kycVerification'));
    }

    public function updateStatus(Request $request, KycVerification $kycVerification)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'rejection_reason' => 'nullable|string|max:1000'
        ]);

        $newStatus = $request->status;
        $updateData = [
            'status' => $newStatus,
            'reviewed_at' => now(),
        ];

        if ($newStatus === 'rejected' && $request->filled('rejection_reason')) {
            $updateData['rejection_reason'] = $request->rejection_reason;
        }

        $kycVerification->update($updateData);

        $user = $kycVerification->user;
        if ($user) {
            $user->update(['kyc_status' => $newStatus]);
        }

        return back()->with('notify', [['success', __('KYC verification status updated successfully.')]]);
    }

    public function downloadAllDocuments(KycVerification $kycVerification)
    {
        try {
            $documents = [];
            if ($kycVerification->document_front_path && $this->fileExists($kycVerification->document_front_path)) {
                $documents[] = [
                    'path' => $kycVerification->document_front_path,
                    'name' => 'document_front.' . pathinfo($kycVerification->document_front_path, PATHINFO_EXTENSION)
                ];
            }

            if ($kycVerification->document_back_path && $this->fileExists($kycVerification->document_back_path)) {
                $documents[] = [
                    'path' => $kycVerification->document_back_path,
                    'name' => 'document_back.' . pathinfo($kycVerification->document_back_path, PATHINFO_EXTENSION)
                ];
            }

            if ($kycVerification->selfie_path && $this->fileExists($kycVerification->selfie_path)) {
                $documents[] = [
                    'path' => $kycVerification->selfie_path,
                    'name' => 'selfie.' . pathinfo($kycVerification->selfie_path, PATHINFO_EXTENSION)
                ];
            }

            if (empty($documents)) {
                return back()->with('notify', [['error', __('No documents found for this verification.')]]);
            }

            if (count($documents) === 1) {
                try {
                    return $this->download($documents[0]['path']);
                } catch (\Exception $e) {
                    return back()->with('notify', [['error', __('Failed to download document.')]]);
                }
            }

            $zipFileName = 'kyc_documents_' . $kycVerification->id . '_' . time() . '.zip';
            $zipPath = storage_path('app/temp/' . $zipFileName);

            if (!file_exists(dirname($zipPath))) {
                mkdir(dirname($zipPath), 0755, true);
            }

            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                foreach ($documents as $document) {
                    $fullPath = 'assets/files/' . $document['path'];

                    if (file_exists($fullPath) && is_file($fullPath)) {
                        $zip->addFile($fullPath, $document['name']);
                    }
                }
                $zip->close();

                if (file_exists($zipPath) && filesize($zipPath) > 0) {
                    return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
                }
            }

            return back()->with('notify', [['error', __('Could not create ZIP file or no valid documents found.')]]);

        } catch (\Exception $exception) {
            return back()->with('notify', [['error', __('An error occurred while downloading documents.')]]);
        }
    }
}
