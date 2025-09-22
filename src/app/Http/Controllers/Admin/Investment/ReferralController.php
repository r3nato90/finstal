<?php

namespace App\Http\Controllers\Admin\Investment;

use App\Enums\Referral\ReferralCommissionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReferralRequest;
use App\Models\Setting;
use App\Services\Investment\ReferralService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReferralController extends Controller
{
    public function __construct(protected ReferralService $referralService)
    {

    }

    public function index(): View
    {
        $setTitle = "Manage Referrals";
        $referrals = $this->referralService->get();

        return view('admin.referral.index', compact('setTitle', 'referrals'));
    }

    public function setting(Request $request): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'array'],
        ]);

        foreach (ReferralCommissionType::getColumns() as $column) {
            if (!array_key_exists($column, $request->input('status'))) {
                abort(404);
            }
        }

        $currentReferralSettings = Setting::get('referral_setting', []);
        if (!is_array($currentReferralSettings)) {
            $currentReferralSettings = [];
        }

        $updatedSettings = array_replace_recursive($currentReferralSettings, $request->input('status'));
        Setting::set('referral_setting', $updatedSettings, 'json', 'Referral Settings', 'referral');

        return back()->with('notify', [['success', __('Referral Activation setting updated successfully')]]);
    }

    public function update(ReferralRequest $request): RedirectResponse
    {
        $this->referralService->deleteByCommissionType($request->input('commission_type'));
        $this->referralService->save($this->referralService->prepParams($request));

        return back()->with('notify', [['success', __('Referral commission setting updated successfully')]]);
    }
}
