<?php

namespace App\Http\Controllers\Admin\Ico;

use App\Http\Controllers\Controller;
use App\Models\IcoPurchase;
use App\Models\IcoToken;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IcoPurchaseController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = IcoPurchase::with(['user', 'icoToken:id,name,symbol']);
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('purchase_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('icoToken', function ($tokenQuery) use ($search) {
                        $tokenQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('symbol', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('token')) {
            $query->where('ico_token_id', $request->get('token'));
        }

        if ($request->filled('date_from')) {
            $dateFrom = \Carbon\Carbon::parse($request->get('date_from'))->startOfDay();
            $query->where('created_at', '>=', $dateFrom);
        }

        if ($request->filled('date_to')) {
            $dateTo = \Carbon\Carbon::parse($request->get('date_to'))->endOfDay();
            $query->where('created_at', '<=', $dateTo);
        }

        $sortField = $request->get('sort_field', 'purchased_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $allowedSortFields = ['purchase_id', 'amount_usd', 'tokens_purchased', 'status', 'purchased_at', 'created_at'];

        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'purchased_at';
        }

        if ($sortField === 'purchased_at') {
            $query->orderByRaw("COALESCE(purchased_at, created_at) {$sortDirection}");
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        $perPage = min($request->get('per_page', 20), 100);
        $purchases = $query->paginate($perPage);
        $purchases->appends($request->query());

        $tokens = IcoToken::select('id', 'name', 'symbol')
            ->whereIn('id', function ($query) {
                $query->select('ico_token_id')
                    ->from('ico_purchases')
                    ->distinct();
            })
            ->orderBy('name')
            ->get();

        $stats = [
            'total_purchases' => IcoPurchase::count(),
            'completed_purchases' => IcoPurchase::where('status', 'completed')->count(),
            'total_amount' => IcoPurchase::where('status', 'completed')->sum('amount_usd'),
            'total_tokens' => IcoPurchase::where('status', 'completed')->sum('tokens_purchased')
        ];

        $setTitle = 'Purchases';
        $filters = $request->only(['search', 'status', 'token', 'date_from', 'date_to', 'sort_field', 'sort_direction']);
        return view('admin.ico.tokens.purchase-history', compact('purchases', 'tokens', 'filters', 'stats', 'setTitle'));
    }
}
