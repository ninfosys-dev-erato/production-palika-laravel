@php
    $dynamicFields = $this->getDynamicFormFields();
@endphp

@if (!empty($dynamicFields))
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Additional Form Fields</h5>
        </div>
        <div class="card-body">
            @foreach ($dynamicFields as $formData)
                <div class="mb-4">
                    <h6 class="text-primary">{{ $formData['form_name'] }}</h6>

                    @foreach ($formData['fields'] as $field)
                        @php
                            $fieldSlug = 'form_' . $formData['form_id'] . '_' . $field['slug'];
                            $fieldValue = $data[$fieldSlug]['value'] ?? null;
                        @endphp

                        <div class="mb-3">
                            <label class="form-label">
                                {{ $field['label'] ?? $field['slug'] }}
                                @if (($field['is_required'] ?? 'no') === 'yes')
                                    <span class="text-danger">*</span>
                                @endif
                            </label>

                            @switch($field['type'])
                                @case('text')
                                    <input type="text"
                                        class="form-control @error("data.{$fieldSlug}.value") is-invalid @enderror"
                                        wire:model="data.{{ $fieldSlug }}.value"
                                        placeholder="Enter {{ $field['label'] ?? $field['slug'] }}">
                                    @error("data.{$fieldSlug}.value")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @break

                                @case('textarea')
                                    <textarea class="form-control @error("data.{$fieldSlug}.value") is-invalid @enderror"
                                        wire:model="data.{{ $fieldSlug }}.value" rows="3"
                                        placeholder="Enter {{ $field['label'] ?? $field['slug'] }}"></textarea>
                                    @error("data.{$fieldSlug}.value")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @break

                                @case('number')
                                    <input type="number"
                                        class="form-control @error("data.{$fieldSlug}.value") is-invalid @enderror"
                                        wire:model="data.{{ $fieldSlug }}.value"
                                        placeholder="Enter {{ $field['label'] ?? $field['slug'] }}">
                                    @error("data.{$fieldSlug}.value")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @break

                                @case('select')
                                    <select class="form-control @error("data.{$fieldSlug}.value") is-invalid @enderror"
                                        wire:model="data.{{ $fieldSlug }}.value">
                                        <option value="">Select {{ $field['label'] ?? $field['slug'] }}</option>
                                        @if (isset($field['options']) && is_array($field['options']))
                                            @foreach ($field['options'] as $option)
                                                <option value="{{ $option['value'] ?? $option }}">
                                                    {{ $option['label'] ?? $option }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error("data.{$fieldSlug}.value")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @break

                                @case('checkbox')
                                    <div class="form-check">
                                        <input type="checkbox"
                                            class="form-check-input @error("data.{$fieldSlug}.value") is-invalid @enderror"
                                            wire:model="data.{{ $fieldSlug }}.value" value="1">
                                        <label class="form-check-label">
                                            {{ $field['label'] ?? $field['slug'] }}
                                        </label>
                                    </div>
                                    @error("data.{$fieldSlug}.value")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @break

                                @case('file')
                                    <input type="file"
                                        class="form-control @error("data.{$fieldSlug}.value") is-invalid @enderror"
                                        wire:model="data.{{ $fieldSlug }}.value"
                                        @if (($field['is_multiple'] ?? 'no') === 'yes') multiple @endif>
                                    @error("data.{$fieldSlug}.value")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if (isset($data[$fieldSlug]['url']) || isset($data[$fieldSlug]['urls']))
                                        <div class="mt-2">
                                            @if (isset($data[$fieldSlug]['url']))
                                                <a href="{{ $data[$fieldSlug]['url'] }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-file"></i> View File
                                                </a>
                                            @endif
                                            @if (isset($data[$fieldSlug]['urls']))
                                                @foreach ($data[$fieldSlug]['urls'] as $index => $url)
                                                    <a href="{{ $url }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary me-2">
                                                        <i class="bx bx-file"></i> File {{ $index + 1 }}
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                @break

                                @default
                                    <input type="text"
                                        class="form-control @error("data.{$fieldSlug}.value") is-invalid @enderror"
                                        wire:model="data.{{ $fieldSlug }}.value"
                                        placeholder="Enter {{ $field['label'] ?? $field['slug'] }}">
                                    @error("data.{$fieldSlug}.value")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            @endswitch
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endif
