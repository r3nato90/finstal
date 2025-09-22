<h3 class="page-title">{{__($setTitle)}}</h3>
@if($is_filter)
    <div class="filter-wrapper">
        <div class="card-filter">
            <form action="{{ $route }}" method="GET">
                <div class="filter-form">
                    @foreach($filters as $filter)
                        @if(getArrayFromValue($filter, 'type') == \App\Enums\FilterType::SELECT_OPTIONS->value)
                            <div class="filter-item">
                                <select name="{{ getArrayFromValue($filter, 'name')  }}" class="form-select" id="{{ getArrayFromValue($filter, 'name')  }}">
                                    <option value="">{{ __('admin.filter.placeholder.select') }}</option>
                                    @foreach($filter['value'] ?? [] as $key => $option)
                                        <option value="{{ $key }}" @if((int)request(getArrayFromValue($filter, 'name')) == $key) selected @endif>{{ replaceInputTitle($option) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif(getArrayFromValue($filter, 'type') == \App\Enums\FilterType::TEXT->value)
                            <div class="filter-item">
                                <input type="text" name="{{ getArrayFromValue($filter, 'name')  }}" placeholder="{{ getArrayFromValue($filter, 'placeholder') }}" class="form-control" id="{{ getArrayFromValue($filter, 'name')  }}" value="{{request(getArrayFromValue($filter, 'name'))}}">
                            </div>
                        @elseif(getArrayFromValue($filter, 'type') == \App\Enums\FilterType::DATE_RANGE->value)
                            <div class="filter-item">
                                <input type="text" id="{{ getArrayFromValue($filter, 'name') }}" class="form-control datepicker-here" name="{{ getArrayFromValue($filter, 'name') }}"
                                   value="{{request(getArrayFromValue($filter, 'name'))}}" data-range="true" data-multiple-dates-separator=" - "
                                   data-language="en" data-position="bottom right" autocomplete="off"
                                   placeholder="{{ getArrayFromValue($filter, 'placeholder') }}">
                            </div>
                        @endif
                    @endforeach
                    <button class="i-btn btn--primary btn--md" type="submit">
                        <i class="fas fa-search"></i> {{ $btn_name }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

@if($is_modal)
    <div class="filter-action">
        @foreach($urls ?? [] as $navigation)
            @if(getArrayFromValue($navigation, 'type') == 'modal')
                <button type="button" data-bs-toggle="modal" data-bs-target="#{{ getArrayFromValue($navigation, 'id') }}"
                        class="i-btn btn--dark btn--md">@php echo getArrayFromValue($navigation, 'icon')  @endphp {{ getArrayFromValue($navigation, 'name') }}
                </button>
            @else
                <a href="{{ getArrayFromValue($navigation, 'url')  }}" class="i-btn btn--primary btn--md">@php echo getArrayFromValue($navigation, 'icon')  @endphp {{ getArrayFromValue($navigation, 'name') }} </a>
            @endif
        @endforeach
    </div>
@endif
