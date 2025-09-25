@php
    $matrixInvestmentSetting = \App\Models\Setting::get('investment_matrix', 1);
@endphp
@if($matrixInvestmentSetting == 1)
    @php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::MATRIX_PLAN, \App\Enums\Frontend\Content::FIXED);
    @endphp
    <div class="pricing-section bg-color pt-110 pb-110">
        <div class="container">
            <div class="row justify-content-center align-items-center g-4 mb-60">
                <div class="col-lg-5">
                    <div class="section-title style-two text-center">
                        <h2>{{ getArrayFromValue($fixedContent?->meta, 'heading') }}</h2>
                        <p>{{ getArrayFromValue($fixedContent?->meta, 'sub_heading') }}</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                @include('user.partials.matrix.plan')
            </div>
        </div>
    </div>

    <div class="modal fade" id="enrollMatrixModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matrixTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('user.matrix.store') }}">
                    @csrf
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p class="text-dark">{{ __("Are you sure you want to enroll in this matrix scheme?") }}</p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--sm">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif


@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.enroll-matrix-process').click(function () {
                const uid = $(this).data('uid');
                const name = $(this).data('name');

                $('input[name="uid"]').val(uid);
                const title = " Join " + name + " Matrix Scheme";
                $('#matrixTitle').text(title);
            });
        });
    </script>
@endpush
