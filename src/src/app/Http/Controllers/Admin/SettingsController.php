<?php

namespace App\Http\Controllers\Admin;

use App\Concerns\UploadedFile;
use App\Enums\Email\EmailSmsTemplateName;
use App\Http\Controllers\Controller;
use App\Models\Cron;
use App\Models\CryptoCurrency;
use App\Models\EmailSmsTemplate;
use App\Models\IcoToken;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SettingsController extends Controller
{
    use UploadedFile;

    public function index(Request $request): View
    {
        $group = $request->get('group', 'general');
        $setTitle = ucwords(str_replace('_', ' ', $group)) . ' Settings';

        $skipGroups = ['investment_holidays', 'referral', 'matrix_parameters', 'investment_setting'];
        $groups = Setting::distinct('group')
            ->whereNotIn('group', $skipGroups)
            ->pluck('group')
            ->toArray();

        $settings = Setting::where('group', $group)->orderBy('key')->get();
        return view('admin.settings.index', compact('setTitle', 'settings', 'groups', 'group'));
    }


    public function update(Request $request): RedirectResponse
    {
        $group = $request->input('group', 'general');
        $settings = Setting::where('group', $group)->get();
        $rules = [];

        foreach ($settings as $setting) {
            $rules[$setting->key] = $this->getValidationRule($setting);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach ($settings as $setting) {
            $value = $request->input($setting->key);

            switch ($setting->type) {
                case 'file':
                case 'image':
                    if ($request->hasFile($setting->key)) {
                        $oldFile = $setting->value;
                        $value = $this->move($request->file($setting->key), null, $oldFile);

                        if (!$value) {
                            return back()->with('notify', [['error', __("Failed to upload {$setting->label}")]]);
                        }
                    } else {
                        continue 2;
                    }
                    break;

                case 'boolean':
                    $value = (bool) $value;
                    break;

                case 'integer':
                    $value = (int) $value;
                    break;

                case 'float':
                    $value = (float) $value;
                    break;

                case 'json':
                case 'array':
                    if ($setting->key === 'seo_keywords') {
                        $keywords = $request->input('seo_keywords', []);
                        $value = array_filter($keywords);
                    } else {
                        if (is_string($value)) {
                            $decoded = json_decode($value, true);
                            if (json_last_error() !== JSON_ERROR_NONE) {
                                return back()->with('notify', [['error', __("Invalid JSON format for {$setting->label}")]]);
                            }
                            $value = $decoded;
                        }
                    }
                    break;
            }

            Setting::set($setting->key, $value, $setting->type, $setting->label, $setting->group);
        }

        return back()->with('notify', [['success', __('Settings updated successfully!')]]);
    }

    public function create(): View
    {
        $setTitle = 'Create New Setting';
        $groups = Setting::distinct('group')->pluck('group')->toArray();

        return view('admin.settings.create', compact('setTitle', 'groups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'key' => 'required|string|unique:settings,key',
            'label' => 'required|string',
            'type' => 'required|in:text,textarea,email,number,integer,float,boolean,select,color,file,image,json,array',
            'group' => 'required|string',
            'description' => 'nullable|string',
            'value' => 'nullable'
        ]);

        $value = $request->input('value');

        if (in_array($request->type, ['file', 'image']) && $request->hasFile('value')) {
            $value = $this->move($request->file('value'));

            if (!$value) {
                return back()->with('notify', [['error', __('Failed to upload file')]]);
            }
        }

        Setting::set(
            $request->key,
            $value,
            $request->type,
            $request->label,
            $request->group
        );

        if ($request->description) {
            $setting = Setting::where('key', $request->key)->first();
            $setting->update(['description' => $request->description]);
        }

        return redirect()
            ->route('admin.settings.index', ['group' => $request->group])
            ->with('notify', [['success', __('Setting created successfully!')]]);
    }

    public function automation(): View
    {
        $setTitle = __('admin.setting.page_title.automation');
        $cron = Cron::paginate(getPaginate());

        return view('admin.settings.automation', compact('setTitle', 'cron'));
    }

    public function systemUpdate(): View
    {
        $setTitle = 'System update';
        return view('admin.settings.system_update', compact(
            'setTitle',
        ));
    }

    public function systemMigrate(Request $request): RedirectResponse
    {
        try {
            Artisan::call('migrate', [
                '--force' => true,
            ]);

            EmailSmsTemplate::create( [
                'code' => EmailSmsTemplateName::PASSWORD_RESET_CODE_API->value,
                'name' => "Password Reset for User API",
                'subject' => "Password Reset mail",
                'from_email' => "demo@gmail.com",
                'mail_template' => '<h1>Password Reset</h1><p>Hi [user_name],</p><p>We received a request to reset your password. reset your password token:</p><p><p>[token]</p></p><p>If you didn\'t request this password reset, please ignore this email.</p><p>This link will expire in a limited time for security reasons.</p><p>Best regards,<br>The [site_name] Team</p>',
                'sms_template' => "Your account recovery code is: [token]",
                'short_key' => [
                    'user_name' => "user_name",
                    'token' => "token",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ]);

            putPermanentEnv('APP_CURRENT_VERSION', config('app.migrate_version'));
            Artisan::call('optimize:clear');
            Artisan::call('config:clear');

            return back()->with('notify', [['success', __('System has been updated successfully')]]);

        } catch (\Exception $e) {
            Log::error('System migration failed: ' . $e->getMessage());

            return back()->with('notify', [['error', __('System update failed. Please check logs for details.')]]);
        }
    }

    private function getValidationRule($setting): string
    {
        return match ($setting->type) {
            'email' => 'nullable|email',
            'integer', 'number' => 'nullable|integer',
            'float' => 'nullable|numeric',
            'boolean' => 'nullable|in:0,1',
            'file' => 'nullable|file|max:10240',
            'image' => 'nullable|image|max:5120',
            'json', 'array' => 'nullable',
            default => 'nullable|string',
        };
    }
}
