<div class="trading-stats-widget">
    <div class="row g-3">
        <!-- Overall Stats -->
        <div class="col-md-6 col-lg-3">
            <div class="stat-card p-3 border rounded">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="stat-icon bg-primary text-white rounded p-2">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="text-end">
                        <h4 class="mb-0">{{ $tradeReport->total }}</h4>
                        <small class="text-muted">Total Trades</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card p-3 border rounded">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="stat-icon bg-success text-white rounded p-2">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <div class="text-end">
                        <h4 class="mb-0 text-success">{{ $tradeReport->win_rate }}%</h4>
                        <small class="text-muted">Win Rate</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card p-3 border rounded">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="stat-icon {{ $tradeReport->net_profit_loss >= 0 ? 'bg-success' : 'bg-danger' }} text-white rounded p-2">
                        <i class="bi {{ $tradeReport->net_profit_loss >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                    </div>
                    <div class="text-end">
                        <h4 class="mb-0 {{ $tradeReport->net_profit_loss >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ getCurrencySymbol() }}{{ shortAmount(abs($tradeReport->net_profit_loss)) }}
                        </h4>
                        <small class="text-muted">Net P&L</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card p-3 border rounded">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="stat-icon bg-warning text-white rounded p-2">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="text-end">
                        <h4 class="mb-0 text-warning">{{ $tradeReport->active }}</h4>
                        <small class="text-muted">Active Trades</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Breakdown -->
    <div class="mt-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="trade-breakdown p-3 bg-light rounded">
                    <h6 class="mb-3">Trade Results</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-success">Won:</span>
                        <strong class="text-success">{{ $tradeReport->won }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-danger">Lost:</span>
                        <strong class="text-danger">{{ $tradeReport->lost }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Draw:</span>
                        <strong class="text-muted">{{ $tradeReport->draw }}</strong>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="trade-breakdown p-3 bg-light rounded">
                    <h6 class="mb-3">Financial Summary</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-success">Total Profit:</span>
                        <strong class="text-success">{{ getCurrencySymbol() }}{{ shortAmount($tradeReport->total_profit) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-danger">Total Loss:</span>
                        <strong class="text-danger">{{ getCurrencySymbol() }}{{ shortAmount($tradeReport->total_loss) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-white">Total Invested:</span>
                        <strong class="text-muted">{{ getCurrencySymbol() }}{{ shortAmount($tradeReport->total_invested) }}</strong>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="trade-breakdown p-3 bg-light rounded">
                    <h6 class="mb-3">Performance Metrics</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-white">ROI:</span>
                        <strong class="{{ $tradeReport->profit_percentage >= 0 ? 'text--success' : 'text--danger' }}">
                            {{ $tradeReport->profit_percentage }}%
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Avg Trade:</span>
                        <strong>{{ getCurrencySymbol() }}{{ $tradeReport->total > 0 ? shortAmount($tradeReport->total_invested / $tradeReport->total) : '0' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Success Rate:</span>
                        <strong class="text-info">{{ $tradeReport->win_rate }}%</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Symbols (if available) -->
    @if(isset($tradesBySymbol) && count($tradesBySymbol) > 0)
        <div class="mt-4">
            <h6 class="mb-3">Top Trading Symbols</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Symbol</th>
                        <th class="text-center">Total Trades</th>
                        <th class="text-center">Won</th>
                        <th class="text-center">Lost</th>
                        <th class="text-end">Net P&L</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(array_slice($tradesBySymbol, 0, 5) as $symbolData)
                        <tr>
                            <td>
                                <strong>{{ $symbolData['symbol'] }}</strong>
                            </td>
                            <td class="text-center">{{ $symbolData['total_trades'] }}</td>
                            <td class="text-center text-success">{{ $symbolData['won_trades'] }}</td>
                            <td class="text-center text-danger">{{ $symbolData['lost_trades'] }}</td>
                            <td class="text-end {{ $symbolData['net_profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ getCurrencySymbol() }}{{ shortAmount($symbolData['net_profit']) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@push('style-push')
    <style>
        .trading-stats-widget .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #e9ecef !important;
        }

        .trading-stats-widget .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .trading-stats-widget .stat-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .trading-stats-widget .trade-breakdown {
            border: 1px solid #dee2e6;
        }

        .trading-stats-widget .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .trading-stats-widget .table td {
            font-size: 0.875rem;
        }
    </style>
@endpush
