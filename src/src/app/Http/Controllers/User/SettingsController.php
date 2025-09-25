<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\View\View;

class SettingsController extends Controller
{
    use \App\Concerns\UploadedFile;
    private const MAX_FILE_SIZE = 10240;
    private const ALLOWED_IMAGE_TYPES = ['jpeg', 'png', 'jpg'];
    private const ALLOWED_DOCUMENT_TYPES = ['passport', 'driver_license', 'national_id'];


    /**
     * Display the KYC verification page
     */
    public function kycIndex(): View | RedirectResponse
    {
        try {
            $setTitle = 'KYC Verification';
            $user = Auth::user();
            $kyc = $user->kycVerification;
            $countries = $this->getCountries();

            return view('user.settings.kyc', compact('setTitle', 'kyc', 'countries'));
        } catch (Exception $e) {
            Log::error('KYC index error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('notify', [['error', 'Unable to load KYC page. Please try again.']]);
        }
    }

    /**
     * Submit new KYC verification
     */
    public function submitKyc(Request $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            if ($user->kycVerification && !in_array($user->kycVerification->status, ['rejected'])) {
                return redirect()->back()->with('notify', [['error', 'KYC verification already submitted.']]);
            }

            $validatedData = $this->validateKycData($request, true);
            DB::beginTransaction();

            $filePaths = $this->handleKycFileUploads($request, $user->id);
            KycVerification::create([
                'user_id' => $user->id,
                'first_name' => trim($validatedData['first_name']),
                'last_name' => trim($validatedData['last_name']),
                'date_of_birth' => $validatedData['date_of_birth'],
                'phone' => $this->sanitizePhoneNumber($validatedData['phone']),
                'address' => trim($validatedData['address']),
                'city' => trim($validatedData['city']),
                'state' => trim($validatedData['state']),
                'country' => $validatedData['country'],
                'postal_code' => trim($validatedData['postal_code']),
                'document_type' => $validatedData['document_type'],
                'document_number' => strtoupper(trim($validatedData['document_number'])),
                'document_front_path' => $filePaths['document_front'],
                'document_back_path' => $filePaths['document_back'],
                'selfie_path' => $filePaths['selfie'],
                'status' => 'pending',
                'submitted_at' => now(),
            ]);

            $user->update(['kyc_status' => 'pending']);
            DB::commit();

            Log::info('KYC verification submitted', [
                'user_id' => $user->id,
                'document_type' => $validatedData['document_type']
            ]);

            return redirect()->back()->with('notify', [['success', 'KYC verification submitted successfully. We will review your documents within 2-3 business days.']]);

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollBack();

            Log::error('KYC submission error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('notify', [['error', 'Failed to submit KYC verification. Please try again.']]);
        }
    }

    /**
     * Resubmit KYC verification after rejection
     */
    public function resubmitKyc(Request $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            $kyc = $user->kycVerification;

            if (!$kyc || $kyc->status !== 'rejected') {
                return redirect()->back()->with('notify', [['error', 'Invalid KYC resubmission request.']]);
            }

            $validatedData = $this->validateKycData($request, false);
            DB::beginTransaction();

            $updateData = [
                'first_name' => trim($validatedData['first_name']),
                'last_name' => trim($validatedData['last_name']),
                'date_of_birth' => $validatedData['date_of_birth'],
                'phone' => $this->sanitizePhoneNumber($validatedData['phone']),
                'address' => trim($validatedData['address']),
                'city' => trim($validatedData['city']),
                'state' => trim($validatedData['state']),
                'country' => $validatedData['country'],
                'postal_code' => trim($validatedData['postal_code']),
                'document_type' => $validatedData['document_type'],
                'document_number' => strtoupper(trim($validatedData['document_number'])),
                'status' => 'pending',
                'rejection_reason' => null,
                'submitted_at' => now(),
                'reviewed_at' => null,
                'reviewed_by' => null,
            ];

            $this->handleKycFileResubmission($request, $kyc, $updateData);
            $kyc->update($updateData);
            $user->update(['kyc_status' => 'pending']);

            DB::commit();

            Log::info('KYC verification resubmitted', [
                'user_id' => $user->id,
                'kyc_id' => $kyc->id
            ]);

            return redirect()->back()->with('notify', [['success', 'KYC verification resubmitted successfully. We will review your updated documents within 2-3 business days.']]);

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollBack();

            Log::error('KYC resubmission error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'kyc_id' => $kyc->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('notify', [['error', 'Failed to resubmit KYC verification. Please try again.']]);
        }
    }

    // Keep all the private methods unchanged
    private function validateKycData(Request $request, bool $filesRequired = true): array
    {
        $rules = [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[a-zA-Z\s\-\'\.]+$/'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[a-zA-Z\s\-\'\.]+$/'
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:today',
                'after:1900-01-01'
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\+]?[0-9\s\-\(\)]+$/'
            ],
            'address' => 'required|string|max:500|min:10',
            'city' => 'required|string|max:255|min:2',
            'state' => 'required|string|max:255|min:2',
            'country' => 'required|string|max:255|in:' . implode(',', $this->getCountries()),
            'postal_code' => 'required|string|max:20|min:3',
            'document_type' => 'required|in:' . implode(',', self::ALLOWED_DOCUMENT_TYPES),
            'document_number' => [
                'required',
                'string',
                'max:50',
                'min:3',
                'regex:/^[A-Z0-9\-\s]+$/i'
            ],
        ];

        $fileRules = $filesRequired ? 'required|' : 'nullable|';
        $fileRules .= 'image|mimes:' . implode(',', self::ALLOWED_IMAGE_TYPES) . '|max:' . self::MAX_FILE_SIZE;

        $rules['document_front'] = $fileRules;
        $rules['document_back'] = str_replace('required|', 'nullable|', $fileRules);
        $rules['selfie'] = $fileRules;

        $messages = [
            'first_name.regex' => 'First name contains invalid characters.',
            'last_name.regex' => 'Last name contains invalid characters.',
            'date_of_birth.before' => 'Date of birth must be before today.',
            'date_of_birth.after' => 'Date of birth must be after 1900.',
            'phone.regex' => 'Please provide a valid phone number.',
            'address.min' => 'Address must be at least 10 characters long.',
            'document_number.regex' => 'Document number contains invalid characters.',
            'document_front.max' => 'Document front image must not exceed 10MB.',
            'document_back.max' => 'Document back image must not exceed 10MB.',
            'selfie.max' => 'Selfie image must not exceed 10MB.',
        ];

        return $request->validate($rules, $messages);
    }

    /**
     * @throws ValidationException
     */
    private function handleKycFileUploads(Request $request, int $userId): array
    {
        $filePaths = [];
        try {
            if ($request->hasFile('document_front')) {
                $file = $request->file('document_front');
                $this->validateFileIntegrity($file, 'document_front');
                $filePaths['document_front'] = $this->move($file);
            }

            if ($request->hasFile('selfie')) {
                $file = $request->file('selfie');
                $this->validateFileIntegrity($file, 'selfie');
                $filePaths['selfie'] = $this->move($file);
            }

            $filePaths['document_back'] = null;
            if ($request->hasFile('document_back')) {
                $file = $request->file('document_back');
                $this->validateFileIntegrity($file, 'document_back');
                $filePaths['document_back'] = $this->move($file);
            }

            return $filePaths;

        } catch (Exception $e) {
            foreach ($filePaths as $path) {
                $this->removeFile($path);
            }
            throw $e;
        }
    }

    private function handleKycFileResubmission(Request $request, KycVerification $kyc, array &$updateData): void
    {
        if ($request->hasFile('document_front')) {
            $file = $request->file('document_front');
            $this->validateFileIntegrity($file, 'document_front');
            $updateData['document_front_path'] = $this->move($file, null, $kyc->document_front_path);
        }

        if ($request->hasFile('document_back')) {
            $file = $request->file('document_back');
            $this->validateFileIntegrity($file, 'document_back');
            $updateData['document_back_path'] = $this->move($file, null, $kyc->document_back_path);
        }

        if ($request->hasFile('selfie')) {
            $file = $request->file('selfie');
            $this->validateFileIntegrity($file, 'selfie');
            $updateData['selfie_path'] = $this->move($file, null, $kyc->selfie_path);
        }
    }

    private function validateFileIntegrity(UploadedFile $file, string $fieldName): void
    {
        if (!$file->isValid()) {
            throw ValidationException::withMessages([
                $fieldName => ["The uploaded {$fieldName} file is corrupted or invalid. Please try again."]
            ]);
        }

        $detectedType = $file->getMimeType();
        $allowedMimeTypes = ['image/jpeg', 'image/png'];

        if (!in_array($detectedType, $allowedMimeTypes)) {
            throw ValidationException::withMessages([
                $fieldName => ["Invalid file type detected for {$fieldName}. Only JPEG and PNG files are allowed."]
            ]);
        }

        $extension = $file->getClientOriginalExtension();
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (!in_array(strtolower($extension), $allowedExtensions)) {
            throw ValidationException::withMessages([
                $fieldName => ["Invalid file extension for {$fieldName}. Only JPG, JPEG, and PNG files are allowed."]
            ]);
        }
    }

    private function sanitizePhoneNumber(string $phone): string
    {
        $sanitized = preg_replace('/[^0-9+]/', '', $phone);
        if (str_starts_with($sanitized, '+')) {
            $sanitized = '+' . preg_replace('/[^0-9]/', '', substr($sanitized, 1));
        } else {
            $sanitized = preg_replace('/[^0-9]/', '', $sanitized);
        }

        return $sanitized;
    }

    private function getCountries(): array
    {
        return [
            'Afghanistan', 'Albania', 'Algeria', 'Argentina', 'Australia', 'Austria',
            'Bangladesh', 'Belgium', 'Brazil', 'Bulgaria', 'Canada', 'Chile',
            'China', 'Colombia', 'Croatia', 'Czech Republic', 'Denmark', 'Egypt',
            'Finland', 'France', 'Germany', 'Ghana', 'Greece', 'Hungary',
            'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel',
            'Italy', 'Japan', 'Jordan', 'Kenya', 'Malaysia', 'Mexico',
            'Netherlands', 'New Zealand', 'Nigeria', 'Norway', 'Pakistan', 'Philippines',
            'Poland', 'Portugal', 'Romania', 'Russia', 'Saudi Arabia', 'Singapore',
            'South Africa', 'South Korea', 'Spain', 'Sweden', 'Switzerland', 'Thailand',
            'Turkey', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Vietnam'
        ];
    }
}
