@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('Cron Job Setting')</h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-8 pe-lg-5">
                            <div class="mb-3 col-lg-12">
                                <label for="cron" class="form-label">{{ __('Cron Job') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="curl -s {{ route('cron.run') }}" id="cron" aria-describedby="basic-addon-cron" readonly="">
                                    <div class="input-group-append pointer">
                                        <span class="input-group-text bg--linear-success text-light rounded-end cron-copy" id="basic-addon-cron">@lang('Copy')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-lg-12">
                                <label for="cron" class="form-label">{{ __('Queue Work') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="curl -s {{ route('queue.work') }}" id="work" aria-describedby="basic-addon-cron" readonly="">
                                    <div class="input-group-append pointer">
                                        <span class="input-group-text bg--linear-success text-light rounded-end queue-work" id="basic-addon-cron">@lang('Copy')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card-body bg--light">
                                <p class="text--light mb-2">
                                    {{ __('Set the cron job to run once every minute for optimal efficiency and precision. This frequency ensures timely execution and responsiveness to any scheduled tasks or processes. By configuring the cron to activate every minute, you guarantee that no critical actions or updates are missed, thereby maintaining system reliability and performance at its peak.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('API Base URL')</h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-8 pe-lg-5">
                            <div class="mb-3 col-lg-12">
                                <label for="apiBaseUrl" class="form-label">{{ __('API Base URL') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="apiBaseUrl" value="{{ URL::to('/').'/api' }}" aria-describedby="basic-addon-api" readonly>
                                    <div class="input-group-append pointer">
                                        <span class="input-group-text bg--linear-success text-light rounded-end api-copy based-url" id="basic-addon-api">@lang('Copy')</span>
                                    </div>
                                </div>
                                <small class="text-muted">
                                    @lang('Use this API Base URL to connect your React and Flutter applications.')
                                </small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card-body bg--light">
                                <p class="text-muted mb-2">
                                    @lang('This URL ensures seamless integration between your frontend applications and the backend.')
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            @include('admin.partials.filter', [
                 'is_filter' => false,
                 'is_modal' => false,
            ])
            @include('admin.partials.table', [
                 'columns' => [
                     'created_at' => __('admin.table.created_at'),
                     'name' => __('admin.table.name'),
                     'ideal_time' => __('Ideal Time'),
                     'last_run' => __('Last Run'),
                 ],
                 'rows' => $cron,
                 'page_identifier' => \App\Enums\PageIdentifier::CRON->value,
            ])
        </div>
    </section>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.based-url').click(function() {
                const copyText = $('#apiBaseUrl').val();
                const textArea = document.createElement('textarea');
                textArea.value = copyText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                notify('success', 'Copied to clipboard!');
            });

            $('.cron-copy').click(function() {
                const copyText = $('#cron').val();
                const textArea = document.createElement('textarea');
                textArea.value = copyText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                notify('success', 'Copied to clipboard!');
            });

            $('.queue-work').click(function() {
                const copyText = $('#work').val();
                const textArea = document.createElement('textarea');
                textArea.value = copyText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                notify('success', 'Copied to clipboard!');
            });
        });
    </script>
@endpush
