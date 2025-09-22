<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WalletController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Wallet::with(['user']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('balance_type') && $request->filled('min_balance')) {
            $balanceType = $request->get('balance_type');
            $minBalance = $request->get('min_balance');
            $allowedBalanceTypes = ['primary_balance', 'investment_balance', 'trade_balance', 'practice_balance'];

            if (in_array($balanceType, $allowedBalanceTypes)) {
                $query->where($balanceType, '>=', $minBalance);
            }
        }

        if ($request->filled('user_status')) {
            $query->whereHas('user', function ($userQuery) use ($request) {
                $userQuery->where('status', $request->get('user_status'));
            });
        }

        if ($request->filled('date_from')) {
            $dateFrom = \Carbon\Carbon::parse($request->get('date_from'))->startOfDay();
            $query->where('created_at', '>=', $dateFrom);
        }

        if ($request->filled('date_to')) {
            $dateTo = \Carbon\Carbon::parse($request->get('date_to'))->endOfDay();
            $query->where('created_at', '<=', $dateTo);
        }

        $sortField = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $allowedSortFields = [
            'id',
            'primary_balance',
            'investment_balance',
            'trade_balance',
            'practice_balance',
            'created_at',
            'updated_at'
        ];

        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at';
        }

        $query->orderBy($sortField, $sortDirection);

        $perPage = min($request->get('per_page', 20), 100);
        $wallets = $query->paginate($perPage);
        $wallets->appends($request->query());

        $stats = [
            'total_wallets' => Wallet::count(),
            'total_primary_balance' => Wallet::sum('primary_balance'),
            'total_investment_balance' => Wallet::sum('investment_balance'),
            'total_trade_balance' => Wallet::sum('trade_balance'),
            'total_practice_balance' => Wallet::sum('practice_balance'),
            'active_wallets' => Wallet::where(function ($q) {
                $q->where('primary_balance', '>', 0)
                    ->orWhere('investment_balance', '>', 0)
                    ->orWhere('trade_balance', '>', 0)
                    ->orWhere('practice_balance', '>', 0);
            })->count()
        ];

        $filters = $request->only([
            'search',
            'balance_type',
            'min_balance',
            'user_status',
            'date_from',
            'date_to',
            'sort_field',
            'sort_direction'
        ]);

        return view('admin.wallets.index', compact('wallets', 'filters', 'stats'));
    }
}
