<?php

namespace App\Http\Controllers\Admin\Investment;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvestmentSettingController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('Investment Setting');
        return view('admin.investment.setting', compact(
            'setTitle'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => ['sometimes', 'array'],
            'type.*' => ['required', 'in:0,1']
        ]);

        $currentInvestmentSettings = Setting::get('investment_setting', []);
        if (!is_array($currentInvestmentSettings)) {
            $currentInvestmentSettings = [];
        }

        if ($request->has('type')) {
            $newSettings = $request->input('type');
            foreach ($newSettings as $key => $value) {
                $currentInvestmentSettings[$key] = (int) $value;
            }
        }

        Setting::set('investment_setting', $currentInvestmentSettings, 'json', 'Investment Settings', 'investment_setting');
        return back()->with('notify', [['success', __('Investment setting has been updated successfully')]]);
    }
}
