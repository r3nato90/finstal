<?php

namespace App\Http\Controllers\Admin\Trade;

use App\Http\Controllers\Controller;
use App\Models\CryptoCurrency;
use App\Models\TradeLog;
use App\Models\TradeSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TradeSettingsController extends Controller
{
    /**
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $setTitle = 'Trade Settings';

        $search = request()->get('search');
        $status = request()->get('status');
        $payoutRange = request()->get('payout_range');
        $sortField = request()->get('sort_field', 'created_at');
        $sortDirection = request()->get('sort_direction', 'desc');

        $query = TradeSetting::with('currency')
            ->withCount([
                'trades',
                'trades as active_trades_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->withSum('trades', 'amount');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('currency', function ($currencyQuery) use ($search) {
                    $currencyQuery->where('symbol', 'like', "%{$search}%");
                });
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', (bool) $status);
        }

        if ($payoutRange) {
            switch ($payoutRange) {
                case '0-50':
                    $query->whereBetween('payout_rate', [0, 50]);
                    break;
                case '51-75':
                    $query->whereBetween('payout_rate', [51, 75]);
                    break;
                case '76-90':
                    $query->whereBetween('payout_rate', [76, 90]);
                    break;
                case '91-100':
                    $query->where('payout_rate', '>=', 91);
                    break;
            }
        }

        $allowedSortFields = ['symbol', 'is_active', 'payout_rate', 'min_amount', 'max_amount', 'created_at'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'desc' ? 'desc' : 'asc');
        }

        $perPage = (int) request()->get('per_page', 15);
        $tradeSettings = $query->paginate($perPage)->appends(request()->all());

        // Transform the settings data
        $tradeSettings->through(function ($setting) {
            $setting->trade_count = $setting->trades_count ?? 0;
            $setting->active_trades = $setting->active_trades_count ?? 0;
            $setting->total_volume = $setting->trades_sum_amount ?? 0;

            return $setting;
        });

        $statsQuery = TradeSetting::query();
        $stats = [
            'totalSymbols' => $statsQuery->count(),
            'activeSymbols' => (clone $statsQuery)->where('is_active', true)->count(),
            'totalActiveTrades' => $this->getTotalActiveTrades($statsQuery),
            'totalVolume' => $this->getTotalVolume($statsQuery),
        ];

        $filters = [
            'search' => $search,
            'status' => $status,
            'payout_range' => $payoutRange,
            'sort_field' => $sortField,
            'sort_direction' => $sortDirection,
        ];

        return view('admin.trade_settings.index', compact(
            'tradeSettings',
            'stats',
            'filters',
            'setTitle'
        ));
    }

    /**
     * @param $query
     * @return mixed
     */
    private function getTotalActiveTrades($query): mixed
    {
        return $query->withCount(['trades' => function ($q) {
            $q->where('status', 'active');
        }])->get()->sum('trades_count');
    }

    /**
     * @param $query
     * @return int
     */
    private function getTotalVolume($query): int
    {
        return $query->withSum(['trades' => function ($q) {
        }], 'amount')->get()->sum('trades_sum_amount') ?? 0;
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $setTitle = 'Create Trade Setting';
        $currencies = CryptoCurrency::orderBy('symbol')->get();

        return view('admin.trade_settings.create', compact(
            'currencies',
            'setTitle'
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'symbol' => 'required|string|max:20|unique:trade_settings',
                'is_active' => 'boolean',
                'min_amount' => 'required|numeric|min:0.01',
                'max_amount' => 'required|numeric|gt:min_amount',
                'payout_rate' => 'required|numeric|min:1|max:1000',
                'durations' => 'required|array|min:1',
                'durations.*' => 'integer|min:1',
                'trading_hours' => 'required|array',
                'trading_hours.*.enabled' => 'boolean',
                'trading_hours.*.start' => 'required|string|date_format:H:i',
                'trading_hours.*.end' => 'required|string|date_format:H:i',
            ]);

            $currency = CryptoCurrency::where('symbol', $request->symbol)->first();
            if (!$currency) {
                return back()->withErrors(['error' => 'Currency not found for the selected symbol.']);
            }

            $data = $request->all();
            $data['is_active'] = $request->boolean('is_active');
            $data['currency_id'] = $currency->id;

            TradeSetting::create($data);
            return back()->with('notify', [['success', 'Trade setting created successfully.']]);

        } catch (\Exception $exception) {
            return back()->withErrors(['error' => 'Failed to create trade setting. Please try again.']);
        }
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $setTitle = 'Edit Trade Setting';
        $tradeSetting = TradeSetting::findOrFail($id);

        $trades = TradeLog::where('symbol', $tradeSetting->symbol)->with('user')->get();
        $stats = [
            'total_trades' => $trades->count(),
            'active_trades' => $trades->where('status', 'active')->count(),
            'total_volume' => $trades->sum('amount'),
        ];

        $currencies = CryptoCurrency::orderBy('symbol')->get();

        return view('admin.trade_settings.edit', compact(
            'tradeSetting',
            'currencies',
            'stats',
            'setTitle'
        ));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $tradeSetting = TradeSetting::findOrFail($id);

        $request->validate([
            'symbol' => 'required|string|max:20|unique:trade_settings,symbol,' . $tradeSetting->id,
            'is_active' => 'boolean',
            'min_amount' => 'required|numeric|min:0.01',
            'max_amount' => 'required|numeric|gt:min_amount',
            'payout_rate' => 'required|numeric|min:1|max:1000',
            'durations' => 'required|array|min:1',
            'durations.*' => 'integer|min:1',
            'trading_hours' => 'required|array',
            'trading_hours.*.enabled' => 'boolean',
            'trading_hours.*.start' => 'required|string|date_format:H:i',
            'trading_hours.*.end' => 'required|string|date_format:H:i',
        ]);

        if ($request->symbol !== $tradeSetting->symbol) {
            $currency = CryptoCurrency::where('symbol', $request->symbol)->first();
            if (!$currency) {
                return back()->withErrors(['error' => 'Currency not found for the selected symbol.']);
            }
            $currencyId = $currency->id;
        } else {
            $currencyId = $tradeSetting->currency_id;
        }

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');
        $data['currency_id'] = $currencyId;

        $tradeSetting->update($data);
        return back()->with('notify', [['success', 'Trade setting updated successfully.']]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $tradeSetting = TradeSetting::findOrFail($request->input('id'));
        $activeTrades = TradeLog::where('symbol', $tradeSetting->symbol)
            ->where('status', 'active')
            ->exists();

        if ($activeTrades) {
            return back()->withErrors(['error' => 'Cannot delete trade setting. There are active trades using this symbol.']);
        }

        $tradeSetting->delete();
        return back()->with('notify', [['success', 'Trade setting deleted successfully.']]);
    }
}
