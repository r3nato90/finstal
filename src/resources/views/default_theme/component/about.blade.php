@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ABOUT, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ABOUT, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<div class="about-us-section pt-110 pb-110">
    <div class="linear-left"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-9 pe-lg-5">
                <div class="section-title text-start mb-40">
                    <h2>{{ getArrayFromValue($fixedContent?->meta, 'heading') }}</h2>
                    <p>{{ getArrayFromValue($fixedContent?->meta, 'sub_heading') }}</p>
                </div>
                <div class="about-content">
                    <ul class="about-list">
                        @foreach($enhancementContents as $key => $enhancementContent)
                            <li>
                                @php echo getArrayFromValue($enhancementContent->meta, 'icon') @endphp
                                <span> {{ getArrayFromValue($enhancementContent->meta, 'title') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="row counter-wrap mt-5 g-3">
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="counter-single text-center d-flex flex-column">
                            <div class="coundown d-flex flex-column">
                                <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                                    <h3 class="odometer" data-odometer-final="167"> {{ getArrayFromValue($fixedContent?->meta, 'first_item_count') }}</h3>
                                </div>
                                <p>{{ getArrayFromValue($fixedContent?->meta, 'first_item_title') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="counter-single text-center d-flex flex-column">
                            <div class="coundown d-flex flex-column">
                                <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                                    <h3 class="odometer" data-odometer-final="312">{{ getArrayFromValue($fixedContent?->meta, 'second_item_count') }}</h3>
                                </div>
                                <p>{{ getArrayFromValue($fixedContent?->meta, 'second_item_title') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="counter-single text-center d-flex flex-column">
                            <div class="coundown d-flex flex-column">
                                <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                                    <h3 class="odometer" data-odometer-final="154">{{ getArrayFromValue($fixedContent?->meta, 'third_item_count') }}</h3>
                                </div>
                                <p>{{ getArrayFromValue($fixedContent?->meta, 'third_item_title') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 pe-lg-5">
                <div class="about-image">
                    <img src="{{ displayImage(getArrayFromValue($fixedContent?->meta, 'first_image'), "650x600") }}" class="about-single" alt="{{ __('About Us Image') }}">
                </div>
            </div>
        </div>
    </div>
</div>
@push('style-push')
    <style>
        .about-image img {
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush
