<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class LoginAttemptController extends Controller
{
    /**
     * Display a listing of login attempts
     */
    public function index(Request $request): View | RedirectResponse
    {
        $setTitle = 'Login Attempts';

        $search = $request->get('search');
        $successful = $request->get('successful');
        $deviceType = $request->get('device_type');
        $browser = $request->get('browser');
        $platform = $request->get('platform');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $sortField = $request->get('sort_field', 'attempted_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $query = LoginAttempt::with('user');

        // Apply search filters
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($successful !== null && $successful !== '') {
            $query->where('successful', (bool) $successful);
        }

        if ($deviceType) {
            $query->where('device_type', $deviceType);
        }

        if ($browser) {
            $query->where('browser', $browser);
        }

        if ($platform) {
            $query->where('platform', $platform);
        }

        if ($dateFrom) {
            try {
                $query->where('attempted_at', '>=', Carbon::parse($dateFrom)->startOfDay());
            } catch (Exception $e) {
                return back()->with('notify', [['error', "Invalid date from {$dateFrom}"]]);
            }
        }

        if ($dateTo) {
            try {
                $query->where('attempted_at', '<=', Carbon::parse($dateTo)->endOfDay());
            } catch (Exception $e) {
                return back()->with('notify', [['error', "Invalid date to {$dateTo}"]]);
            }
        }

        $perPage = $request->get('per_page', 20);
        $loginAttempts = $query->paginate($perPage)->appends($request->all());

        $filterOptions = $this->getFilterOptions();
        $statistics = $this->getStatistics();

        return view('admin.login_attempts.index', compact(
            'setTitle',
            'loginAttempts',
            'filterOptions',
            'statistics'
        ));
    }

    /**
     * Get filter options for dropdowns
     */
    private function getFilterOptions(): array
    {
        return [
            'device_types' => LoginAttempt::select('device_type')
                ->distinct()
                ->whereNotNull('device_type')
                ->where('device_type', '!=', '')
                ->orderBy('device_type')
                ->pluck('device_type')
                ->toArray(),

            'browsers' => LoginAttempt::select('browser')
                ->distinct()
                ->whereNotNull('browser')
                ->where('browser', '!=', '')
                ->orderBy('browser')
                ->pluck('browser')
                ->toArray(),

            'platforms' => LoginAttempt::select('platform')
                ->distinct()
                ->whereNotNull('platform')
                ->where('platform', '!=', '')
                ->orderBy('platform')
                ->pluck('platform')
                ->toArray(),
        ];
    }

    /**
     * Get statistics for dashboard cards
     */
    private function getStatistics(): array
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'total_attempts' => LoginAttempt::count(),
            'successful_attempts' => LoginAttempt::where('successful', true)->count(),
            'failed_attempts' => LoginAttempt::where('successful', false)->count(),
            'today_attempts' => LoginAttempt::whereDate('attempted_at', $today)->count(),
            'week_attempts' => LoginAttempt::where('attempted_at', '>=', $thisWeek)->count(),
            'month_attempts' => LoginAttempt::where('attempted_at', '>=', $thisMonth)->count(),
            'unique_ips_today' => LoginAttempt::whereDate('attempted_at', $today)
                ->distinct('ip_address')
                ->count('ip_address'),
            'success_rate' => $this->calculateSuccessRate(),
        ];
    }

    /**
     * Calculate success rate percentage
     */
    private function calculateSuccessRate(): float
    {
        $totalAttempts = LoginAttempt::count();

        if ($totalAttempts === 0) {
            return 0;
        }

        $successfulAttempts = LoginAttempt::where('successful', true)->count();
        return round(($successfulAttempts / $totalAttempts) * 100, 2);
    }

    /**
     * Clear old login attempts
     */
    public function clearOld(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'days' => 'required|integer|min:1|max:365'
        ]);

        $cutoffDate = Carbon::now()->subDays($validated['days']);
        $deletedCount = LoginAttempt::where('attempted_at', '<', $cutoffDate)->delete();

        return back()->with('notify', [['success', "Deleted {$deletedCount} old login attempts."]]);
    }
}
