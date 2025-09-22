@php
    $investmentSetting = \App\Models\Setting::get('investment_investment', 1);
@endphp
@if($investmentSetting == 1)
    @php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::PRICING_PLAN, \App\Enums\Frontend\Content::FIXED);
    @endphp

    <div class="pricing-section pt-110 pb-110">
        <div class="container">
            <div class="row justify-content-lg-start justify-content-center align-items-center g-4 mb-60">
                <div class="col-lg-5">
                    <div class="section-title text-lg-start text-center">
                        <h2>{{ getArrayFromValue($fixedContent?->meta, 'heading') }}</h2>
                        <p> {{ getArrayFromValue($fixedContent?->meta, 'sub_heading') }} </p>
                    </div>
                </div>
            </div>
            <div>
                @include('user.partials.investment.plan')
            </div>
        </div>
    </div>

    @include('user.partials.investment.plan_modal')
@endif
