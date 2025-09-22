@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __($setTitle) }}</h4>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <p><strong>{{ __('Current Version') }}</strong> : {{ config('app.app_version') }}</p>
                        <p><strong>{{ __('New Version') }}</strong> : {{ config('app.migrate_version') }}</p>
                    </div>

                    @if(version_compare(config('app.migrate_version'), config('app.app_version'), '>'))
                        <div class="border p-4 mb-4">
                            <h5 class="text-center mb-4">
                                Important System Upgrade Notice - Version 5.0.1
                            </h5>

                            <div class="mt-4 text-center">
                                <button type="button" class="btn btn-primary btn-lg" id="upgradeButton">
                                    {{ __('Update System to Version 5') }}
                                </button>
                            </div>
                        </div>

                    @else
                        <div class="text-center border p-4">
                            <h5>System is up to date!</h5>
                            <p>You are running the latest version of the system.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="upgradeConfirmModal" tabindex="-1" role="dialog" aria-labelledby="upgradeConfirmModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirm System Upgrade')</h5>
                </div>
                <form action="{{ route('admin.settings.migrate') }}" method="POST" id="upgradeForm">
                    @csrf
                    <div class="modal-body">

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmUpgrade" required>
                            <label class="form-check-label" for="confirmUpgrade">
                                <strong>@lang('I agree to proceed with this upgrade')</strong>
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn--danger btn--sm" id="confirmUpgradeButton" disabled>
                            @lang('Proceed with Upgrade')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('#upgradeButton').on('click', function(event) {
                event.preventDefault();
                $('#upgradeConfirmModal').modal('show');
            });

            $('#confirmUpgrade').on('change', function() {
                $('#confirmUpgradeButton').prop('disabled', !this.checked);
            });

            $('#upgradeForm').on('submit', function(e) {
                if (!$('#confirmUpgrade').is(':checked')) {
                    e.preventDefault();
                    alert('@lang("Please confirm that you agree to proceed with the upgrade.")');
                    return false;
                }

                $('#confirmUpgradeButton').html('@lang("Upgrading System...")').prop('disabled', true);
                $('#upgradeButton').html('@lang("Upgrading System...")').prop('disabled', true);
            });

            $('#upgradeConfirmModal').on('hidden.bs.modal', function () {
                $('#confirmUpgrade').prop('checked', false);
                $('#confirmUpgradeButton').prop('disabled', true);
            });
        });
    </script>
@endpush
