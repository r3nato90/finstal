@extends('admin.layouts.main')
@section('panel')
    <div class="row">
        <!-- Groups Navigation -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>Settings Groups</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($groups as $groupKey)
                            <a href="{{ route('admin.settings.index', ['group' => $groupKey]) }}"
                               class="list-group-item {{ $group === $groupKey ? 'active' : '' }}">
                                {{ ucwords(str_replace('_', ' ', $groupKey)) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $setTitle }}</h4>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="group" value="{{ $group }}">

                        @foreach($settings as $setting)
                            <div class="mb-3">
                                <label class="form-label">{{ $setting->label }}</label>

                                @if($setting->type === 'text' || $setting->type === 'email')
                                    <input type="{{ $setting->type }}"
                                           class="form-control @error($setting->key) is-invalid @enderror"
                                           name="{{ $setting->key }}"
                                           value="{{ old($setting->key, $setting->value) }}">

                                @elseif($setting->type === 'number' || $setting->type === 'integer' || $setting->type === 'float')
                                    <input type="number"
                                           class="form-control @error($setting->key) is-invalid @enderror"
                                           name="{{ $setting->key }}"
                                           value="{{ old($setting->key, $setting->value) }}"
                                           @if($setting->type === 'float') step="0.01" @endif>

                                @elseif($setting->type === 'textarea')
                                    <textarea class="form-control @error($setting->key) is-invalid @enderror"
                                              name="{{ $setting->key }}"
                                              rows="3">{{ old($setting->key, $setting->value) }}</textarea>

                                @elseif($setting->type === 'boolean')
                                    <select class="form-select @error($setting->key) is-invalid @enderror" name="{{ $setting->key }}">
                                        <option value="1" {{ old($setting->key, $setting->value) == '1' || old($setting->key, $setting->value) === true ? 'selected' : '' }}>Enable</option>
                                        <option value="0" {{ old($setting->key, $setting->value) == '0' || old($setting->key, $setting->value) === false ? 'selected' : '' }}>Disable</option>
                                    </select>

                                @elseif($setting->type === 'select')
                                    <select class="form-select @error($setting->key) is-invalid @enderror" name="{{ $setting->key }}">
                                        <option value="1" {{ old($setting->key, $setting->value) == '1' ? 'selected' : '' }}>Enable</option>
                                        <option value="0" {{ old($setting->key, $setting->value) == '0' ? 'selected' : '' }}>Disable</option>
                                    </select>

                                @elseif($setting->type === 'color')
                                    <div class="input-group">
                                        <input type="color"
                                               class="form-control form-control-color color-picker @error($setting->key) is-invalid @enderror"
                                               id="color_{{ $setting->key }}"
                                               value="{{ old($setting->key, $setting->value ?: '#000000') }}"
                                               style="width: 60px; padding: 4px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                        <input type="text"
                                               class="form-control color-text @error($setting->key) is-invalid @enderror"
                                               name="{{ $setting->key }}"
                                               id="text_{{ $setting->key }}"
                                               value="{{ old($setting->key, $setting->value ?: '#000000') }}"
                                               placeholder="#000000"
                                               pattern="^#[0-9A-Fa-f]{6}$"
                                               style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                    </div>

                                @elseif($setting->type === 'file' || $setting->type === 'image')
                                    <div class="file-upload-wrapper">
                                        <input type="file"
                                               class="form-control @error($setting->key) is-invalid @enderror"
                                               name="{{ $setting->key }}"
                                               @if($setting->type === 'image') accept="image/*" @endif>
                                        @if($setting->value)
                                            <div class="mt-2">
                                                <small class="text-muted">Current file: {{ basename($setting->value) }}</small>
                                                @if($setting->type === 'image' && file_exists(public_path($setting->value)))
                                                    <div class="mt-1">
                                                        <img src="{{ asset($setting->value) }}" alt="Current image" style="max-width: 100px; max-height: 100px;">
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                @elseif($setting->type === 'json' && $setting->key === 'seo_keywords')
                                    @php
                                        $keywords = [];
                                        if (is_string($setting->value)) {
                                            $keywords = json_decode($setting->value, true) ?: [];
                                        } elseif (is_array($setting->value)) {
                                            $keywords = $setting->value;
                                        }
                                    @endphp
                                    <input type="text"
                                           class="form-control"
                                           id="keywords_input"
                                           placeholder="Type keyword and press Enter">
                                    <div class="mt-2" id="keywords_container">
                                        @foreach($keywords as $index => $keyword)
                                            <span class="badge bg-secondary me-1 mb-1">
                                                {{ $keyword }}
                                                <button type="button" class="btn-close btn-close-white ms-1" onclick="removeKeyword({{ $index }})"></button>
                                                <input type="hidden" name="seo_keywords[]" value="{{ $keyword }}">
                                            </span>
                                        @endforeach
                                    </div>

                                @elseif($setting->type === 'json' || $setting->type === 'array')
                                    @php
                                        $jsonValue = '';
                                        if (is_string($setting->value)) {
                                            $jsonValue = $setting->value;
                                        } elseif (is_array($setting->value)) {
                                            $jsonValue = json_encode($setting->value, JSON_PRETTY_PRINT);
                                        }
                                    @endphp
                                    <textarea class="form-control @error($setting->key) is-invalid @enderror"
                                              name="{{ $setting->key }}"
                                              rows="5"
                                              placeholder="Enter valid JSON">{{ old($setting->key, $jsonValue) }}</textarea>
                                    <small class="form-text text-muted">Enter valid JSON format</small>

                                @else
                                    <input type="text"
                                           class="form-control @error($setting->key) is-invalid @enderror"
                                           name="{{ $setting->key }}"
                                           value="{{ old($setting->key, $setting->value) }}">
                                @endif

                                @error($setting->key)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if($setting->description)
                                    <small class="form-text text-muted">{{ $setting->description }}</small>
                                @endif
                            </div>
                        @endforeach

                        <button type="submit" class="i-btn btn--primary btn--lg">{{ __('admin.button.save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-push')
    <style>
        .list-group-item.active {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
        .btn-close-white {
            filter: invert(1);
        }
        .file-upload-wrapper {
            position: relative;
        }
        .badge {
            font-size: 0.875rem;
        }
        .color-picker {
            height: 38px;
            cursor: pointer;
        }
        .color-text {
            font-family: monospace;
            text-transform: uppercase;
        }
        .input-group .color-picker {
            border-right: none;
        }
        .input-group .color-text {
            border-left: none;
        }
        .input-group .color-text:focus {
            border-left: none;
            box-shadow: none;
        }
        .input-group .color-picker:focus {
            border-right: none;
            box-shadow: none;
        }
    </style>
@endpush

@push('script-push')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Color picker sync
            document.querySelectorAll('.color-picker').forEach(function(colorInput) {
                const settingKey = colorInput.id.replace('color_', '');
                const textInput = document.getElementById('text_' + settingKey);

                if (textInput) {
                    // Sync color picker to text input
                    colorInput.addEventListener('input', function() {
                        textInput.value = this.value.toUpperCase();
                    });

                    // Sync text input to color picker
                    textInput.addEventListener('input', function() {
                        const value = this.value.trim();
                        // Validate hex color format
                        if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                            colorInput.value = value;
                            this.style.borderColor = '';
                        } else {
                            this.style.borderColor = '#dc3545';
                        }
                    });

                    // Format on blur
                    textInput.addEventListener('blur', function() {
                        let value = this.value.trim().toUpperCase();
                        if (value && !value.startsWith('#')) {
                            value = '#' + value;
                        }
                        if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                            this.value = value;
                            colorInput.value = value;
                            this.style.borderColor = '';
                        } else if (value === '') {
                            this.value = '#000000';
                            colorInput.value = '#000000';
                            this.style.borderColor = '';
                        }
                    });
                }
            });

            // Keywords input
            const keywordsInput = document.getElementById('keywords_input');
            if (keywordsInput) {
                keywordsInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addKeyword();
                    }
                });
            }
        });

        function addKeyword() {
            const input = document.getElementById('keywords_input');
            const keyword = input.value.trim();
            if (!keyword) return;

            // Check if keyword already exists
            const existingKeywords = Array.from(document.querySelectorAll('input[name="seo_keywords[]"]'))
                .map(input => input.value);

            if (existingKeywords.includes(keyword)) {
                alert('Keyword already exists!');
                return;
            }

            const container = document.getElementById('keywords_container');
            const index = Date.now(); // Use timestamp as unique index

            const badge = document.createElement('span');
            badge.className = 'badge bg-secondary me-1 mb-1';
            badge.innerHTML = `
                ${keyword}
                <button type="button" class="btn-close btn-close-white ms-1" onclick="removeKeywordElement(this)"></button>
                <input type="hidden" name="seo_keywords[]" value="${keyword}">
            `;

            container.appendChild(badge);
            input.value = '';
        }

        function removeKeyword(index) {
            const container = document.getElementById('keywords_container');
            const badges = container.querySelectorAll('.badge');
            if (badges[index]) {
                badges[index].remove();
            }
        }

        function removeKeywordElement(button) {
            button.closest('.badge').remove();
        }
    </script>
@endpush
