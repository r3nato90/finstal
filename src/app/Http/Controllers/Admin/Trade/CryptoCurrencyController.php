<?php

namespace App\Http\Controllers\Admin\Trade;

use App\Http\Controllers\Controller;
use App\Models\CryptoCurrency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CryptoCurrencyController extends Controller
{
    /**
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $setTitle = 'Crypto Currencies';

        $search = request()->get('search');
        $status = request()->get('status');
        $sortField = request()->get('sort_field', 'rank');
        $sortDirection = request()->get('sort_direction', 'asc');

        $query = CryptoCurrency::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('symbol', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('status', (int) $status);
        }

        $allowedSortFields = ['symbol', 'name', 'current_price', 'market_cap', 'rank', 'change_percent', 'last_updated'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'desc' ? 'desc' : 'asc');
        }

        $perPage = (int) request()->get('per_page', 15);
        $cryptoCurrencies = $query->paginate($perPage)->appends(request()->all());

        $stats = [
            'totalCurrencies' => CryptoCurrency::count(),
            'activeCurrencies' => CryptoCurrency::where('status', 1)->count(),
            'totalMarketCap' => CryptoCurrency::sum('market_cap'),
            'totalVolume' => CryptoCurrency::sum('total_volume'),
        ];

        $filters = [
            'search' => $search,
            'status' => $status,
            'sort_field' => $sortField,
            'sort_direction' => $sortDirection,
        ];

        return view('admin.currency.index', compact(
            'cryptoCurrencies',
            'stats',
            'filters',
            'setTitle'
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $crypto = CryptoCurrency::findOrFail($request->input('id'));
        $crypto->status = $request->input('status');
        $crypto->save();

        return back()->with('notify', [['success', 'Status updated successfully.']]);
    }
}
