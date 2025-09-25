@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__($setTitle)}}</h4>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.manual.gateway.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-wrapper">
                            <div class="row mb-3 g-3">
                                <div class="mb-3 col-lg-6">
                                    <label for="name" class="form-label"> {{ __('admin.input.name')}} <sup class="text--danger">*</sup></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder=" {{ __('admin.placeholder.name')}}" required="">
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="percent_charge" class="form-label"> {{ __('admin.input.percent_charge')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="percent_charge" name="percent_charge" placeholder="{{ __('admin.placeholder.number')}}" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="currency_name" class="form-label"> {{ __('admin.input.currency_name')}} <sup class="text--danger">*</sup></label>
                                    <input type="text" name="currency" id="currency_name" class="form-control" placeholder="{{__('admin.placeholder.name')}}">
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="rate" class="form-label"> {{ __('admin.input.rate')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ getCurrencySymbol()}}1 = </span>
                                        <input type="text" name="rate" id="rate" class="form-control" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="minimum" class="form-label"> {{ __('Minimum Amount')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="minimum" name="minimum" placeholder="{{ __('Enter Number')}}" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">{{  getCurrencyName() }}</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="maximum" class="form-label"> {{ __('Maximum Amount')}} <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="maximum" name="maximum" placeholder="{{ __('Enter Number')}}" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">{{  getCurrencyName() }}</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="image" class="form-label"> {{ __('admin.input.image')}} <sup class="text--danger">*</sup></label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="status" class="form-label"> {{ __('admin.input.status')}} <sup class="text--danger">*</sup></label>
                                    <select class="form-select" name="status" id="status" required>
                                        @foreach(\App\Enums\Status::toArray() as $key =>  $status)
                                            <option value="{{ $status }}">{{ replaceInputTitle($key) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>

                        @include('admin.partials.custom-field', [
                            'parameter' => null,
                            'title' => __('admin.content.gateway'),
                            'details' => __('admin.content.gateway_details')
                        ])
                        <button type="submit" class="i-btn btn--primary btn--md text--white"> {{ __('admin.button.save')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-push')
    <script>
        'use strict'
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,
                placeholder: 'Enter Payment Details',
                dialogsInBody: true,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'link', 'video']],
                ],
                callbacks: {
                    onInit: function() {
                    }
                }
            });
        });
    </script>
@endpush
