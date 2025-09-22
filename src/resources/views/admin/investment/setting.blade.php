@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <form action="{{ route('admin.investment.setting.update') }}" method="POST">
                @csrf
                <div class="row">
                    @php
                        $investmentTypes = [
                            ['name' => 'investment_matrix', 'title' => 'Matrix Investment'],
                            ['name' => 'investment_ico_token', 'title' => 'Ico Token Investment'],
                            ['name' => 'investment_investment', 'title' => 'Investment Investment'],
                            ['name' => 'investment_trade_prediction', 'title' => 'Trade Prediction Investment'],
                            ['name' => 'investment_staking_investment', 'title' => 'Staking Investment']
                        ];
                    @endphp

                    @foreach($investmentTypes as $investmentType)
                        <div class="col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-header bg--primary">
                                    <h4 class="card-title text-white">{{ $investmentType['title'] }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <select class="form-select" name="type[{{ $investmentType['name'] }}]">
                                            @php
                                                $currentSettings = \App\Models\Setting::get('investment_setting', []);
                                                $currentValue = isset($currentSettings[$investmentType['name']]) ? $currentSettings[$investmentType['name']] : 0;
                                            @endphp
                                            <option value="1" @if($currentValue == 1) selected @endif>{{ __('ON') }}</option>
                                            <option value="0" @if($currentValue == 0) selected @endif>{{ __('OFF') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="i-btn btn--primary btn--md">{{ __('admin.button.save') }}</button>
            </form>
        </div>
    </section>
@endsection
