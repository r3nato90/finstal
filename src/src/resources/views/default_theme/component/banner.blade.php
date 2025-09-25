@php
    $current_time = now();
    $icoTokenSetting = \App\Models\Setting::get('investment_ico_token', 1);
    $activePhase = \App\Models\IcoToken::where('status', 'active')
        ->whereDate('sale_start_date', '<=', $current_time)
        ->whereDate('sale_end_date', '>=', $current_time)->first();

    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::BANNER, \App\Enums\Frontend\Content::FIXED);
@endphp

@push('style-push')
    <style>
        .count-down-wrap {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 30px !important;
            padding: 18px;
            position: relative;
        }
    </style>
@endpush
<div class="banner-section">
    <div class="banner-bg">
        <img src="{{ displayImage(getArrayFromValue($fixedContent->meta, 'background_image'), '2470x1529') }}"
             alt="{{ __('Background Image') }}">
    </div>
    <div class="linear-big"></div>
    <div class="container">
        <div class="row align-items-start gy-5">
            <div class="col-lg-7">
                <div class="banner-content">
                    <h1>{{ __(getArrayFromValue($fixedContent?->meta, 'heading')) }}</h1>
                    <p>{{ __(getArrayFromValue($fixedContent?->meta, 'sub_heading')) }}</p>
                    <div class="d-flex justify-content-between align-items-end gap-lg-4 gap-2">
                        <div
                            class="d-flex justify-content-start align-items-center flex-lg-nowrap flex-wrap-reverse gap-4">
                            <a href="{{ __(getArrayFromValue($fixedContent?->meta, 'btn_url')) }} "
                               class="i-btn banner-btn">{{ __(getArrayFromValue($fixedContent?->meta, 'btn_name')) }} <i
                                    class="bi bi-arrow-right-short"></i></a>
                            <div class="video-pluse">
                                <span></span>
                                <span></span>
                                <span></span>
                                <a data-fancybox href="{{ getArrayFromValue($fixedContent?->meta, 'video_link') }}"><i
                                        class="bi bi-play-fill"></i></a>
                            </div>
                        </div>
                        <div class="global-users">
                            <div class="shape-left">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M0.709717 22.0001H21.9998V0.710938C19.2491 11.0829 11.0818 19.2498 0.709717 22.0001Z"/>
                                </svg>
                            </div>
                            <div class="shape-right">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M0.709717 22.0001H21.9998V0.710938C19.2491 11.0829 11.0818 19.2498 0.709717 22.0001Z"/>
                                </svg>
                            </div>
                            <div class="icon">
                                <svg version="1.1" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class=""><g>
                                        <path
                                            d="M256 512c-68.38 0-132.667-26.629-181.02-74.98C26.629 388.667 0 324.38 0 256S26.629 123.333 74.98 74.98C123.333 26.629 187.62 0 256 0s132.667 26.629 181.02 74.98C485.371 123.333 512 187.62 512 256s-26.629 132.667-74.98 181.02C388.667 485.371 324.38 512 256 512zm0-490.667C126.604 21.333 21.333 126.604 21.333 256S126.604 490.666 256 490.666 490.666 385.396 490.666 256 385.396 21.333 256 21.333z"
                                            opacity="1" data-original="#000000" class=""></path>
                                        <path
                                            d="M256 512c-40.12 0-77.334-27.481-104.789-77.381-26.345-47.886-40.854-111.321-40.854-178.619s14.509-130.733 40.854-178.619C178.666 27.481 215.88 0 256 0s77.334 27.481 104.788 77.381c26.346 47.886 40.854 111.321 40.854 178.619s-14.509 130.733-40.854 178.619C333.334 484.519 296.12 512 256 512zm0-490.667c-31.987 0-62.563 23.557-86.097 66.332C145.261 132.454 131.69 192.236 131.69 256s13.571 123.546 38.212 168.335c23.534 42.774 54.11 66.331 86.097 66.331s62.563-23.557 86.097-66.331c24.642-44.789 38.212-104.571 38.212-168.335s-13.57-123.546-38.212-168.335C318.563 44.89 287.986 21.333 256 21.333z"
                                            opacity="1" data-original="#000000" class=""></path>
                                        <path
                                            d="M256 510.443c-5.891 0-10.667-4.776-10.667-10.667V12.224c0-5.891 4.775-10.667 10.667-10.667 5.891 0 10.667 4.776 10.667 10.667v487.552c0 5.891-4.776 10.667-10.667 10.667z"
                                            opacity="1" data-original="#000000" class=""></path>
                                        <path
                                            d="M499.776 266.667H12.224c-5.891 0-10.667-4.776-10.667-10.667s4.776-10.667 10.667-10.667h487.552c5.891 0 10.667 4.775 10.667 10.667 0 5.891-4.776 10.667-10.667 10.667zM464.522 139.413H47.478c-5.891 0-10.667-4.775-10.667-10.667s4.775-10.667 10.667-10.667h417.045c5.891 0 10.667 4.775 10.667 10.667s-4.777 10.667-10.668 10.667zM464.522 393.92H47.478c-5.891 0-10.667-4.776-10.667-10.667s4.775-10.667 10.667-10.667h417.045c5.891 0 10.667 4.776 10.667 10.667s-4.777 10.667-10.668 10.667z"
                                            opacity="1" data-original="#000000" class=""></path>
                                    </g></svg>
                            </div>
                            <div class="text">
                                <p>{{ __(getArrayFromValue($fixedContent?->meta, 'first_text')) }}</p>
                                <p>{{ __(getArrayFromValue($fixedContent?->meta, 'second_text')) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="banner-features mb-60">
                    <li>
                        <span>@php echo getArrayFromValue($fixedContent?->meta, 'first_icon') @endphp</span>{{ __(getArrayFromValue($fixedContent?->meta, 'first_title')) }}
                    </li>
                    <li>
                        <span>@php echo getArrayFromValue($fixedContent?->meta, 'second_icon') @endphp</span>{{ __(getArrayFromValue($fixedContent?->meta, 'second_title')) }}
                    </li>
                    <li>
                        <span>@php echo getArrayFromValue($fixedContent?->meta, 'third_icon') @endphp</span>{{ __(getArrayFromValue($fixedContent?->meta, 'third_title')) }}
                    </li>
                </ul>

                @if($icoTokenSetting != 1)
                    @if(!$activePhase)
                        <div class="providers">
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-4 row-cols-2 justify-content-lg-start justify-content-center align-items-center g-4">
                                <div class="col">
                                    <img src="{{ displayImage(getArrayFromValue($fixedContent?->meta, 'first_provider_image'), '106x22') }}" alt="{{ __('banner-coin1') }}">
                                </div>
                                <div class="col">
                                    <img src="{{ displayImage(getArrayFromValue($fixedContent?->meta, 'second_provider_image'), '106x22') }}" alt="{{ __('banner-coin2') }}">
                                </div>
                                <div class="col">
                                    <img src="{{ displayImage(getArrayFromValue($fixedContent?->meta, 'third_provider_image'), '106x22') }}" alt="{{ __('banner-coin3') }}">
                                </div>
                                <div class="col">
                                    <img src="{{ displayImage(getArrayFromValue($fixedContent?->meta, 'fourth_provider_image'), '106x22') }}" alt="{{ __('banner-coin4') }}">
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <div class="col-lg-5 ps-lg-4">
                @if($icoTokenSetting == 1)
                    @if($activePhase)
                        <div class=" count-down-wrap bg-opacity-100 rounded-3 shadow-lg p-4 max-w-md w-100">
                            <h2 class="text-center h5 mb-3 text-white">
                                ICO PRE-SALE IS LIVE
                            </h2>
                            <p class="text-center text-white mb-3">{{ __('Ends In') }}</p>
                            <div class="d-flex justify-content-center gap-xl-4 gap-2 text-center mb-3">
                                <div class="bg-white text-dark px-xl-3 px-2 py-2 rounded">
                                    <h2 class="d-block" id="days">0</h2>
                                    <small>{{ __('Days') }}</small>
                                </div>
                                <div class="bg-white text-dark px-xl-3 px-2 py-2 rounded">
                                    <h2 class="d-block" id="hours">0</h2>
                                    <small>{{ __('Hours') }}</small>
                                </div>
                                <div class="bg-white text-dark px-xl-3 px-2 py-2 rounded">
                                    <h2 class="d-block" id="minutes">0</h2>
                                    <small>{{ __('Minutes') }}</small>
                                </div>
                                <div class="bg-white text-dark px-xl-3 px-2 py-2 rounded">
                                    <h2 class="d-block" id="seconds">0</h2>
                                    <small>{{ __('Seconds') }}</small>
                                </div>
                            </div>
                            <p class="text-center text-white h4 mb-1">
                                {{ shortAmount($activePhase->tokens_sold * $activePhase->price) }} {{ getCurrencyName() }} Raised
                            </p>
                            <p class="text-center text-white mb-3">{{ __('Total Funds Raised') }}</p>

                            <div class="progress mb-5">
                                <div class="progress-bar bg-warning" style="width: {{ $activePhase->tokens_sold / ($activePhase->total_supply - $activePhase->tokens_sold) * 100 }}%"></div>
                            </div>
                            <p class="text-center text-white mb-2">
                                {{ number_format(($activePhase->tokens_sold / ($activePhase->total_supply - $activePhase->tokens_sold)) * 100, 2) }}% target raised
                            </p>
                            <p class="text-center text-white mb-4">
                                1 {{ getCurrencyName() }} = {{ number_format($activePhase->price) }} {{ $activePhase->symbol }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('user.ico.index') }}" class="i-btn btn--primary btn--md capsuled text-center">
                                   {{ __(' Buy Tokens') }}
                                </a>
                                <button class="btn btn-link text-decoration-none d-flex align-items-center text-white">
                                    <span class="me-2"> {{ __('Watch Video') }} </span>
                                    <div class="video-pluse">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <a data-fancybox href="{{ getArrayFromValue($fixedContent?->meta, 'video_link') }}"><i
                                                class="bi bi-play-fill"></i></a>
                                    </div>
                                </button>
                            </div>
                        </div>
                    @else
                        <img src="{{ displayImage(getArrayFromValue($fixedContent?->meta, 'main_image'), '593x586') }}"
                             alt="{{ __('Main Image') }}">
                    @endif
                @else
                    <img src="{{ displayImage(getArrayFromValue($fixedContent?->meta, 'main_image'), '593x586') }}"
                         alt="{{ __('Main Image') }}">
                @endif
            </div>
        </div>
    </div>
</div>

@if($activePhase)
    @push('script-push')
        <script>
            function countdown() {
                const endTime = new Date("{{ $activePhase->sale_end_date }}").getTime();
                const now = new Date().getTime();
                const timeLeft = endTime - now;

                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                document.getElementById("days").innerText = days;
                document.getElementById("hours").innerText = hours;
                document.getElementById("minutes").innerText = minutes;
                document.getElementById("seconds").innerText = seconds;
            }
            setInterval(countdown, 1000);
        </script>
    @endpush
@endif
