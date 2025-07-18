@props(['field'])
    <div class="form-group mb-3">
        @switch($field['type'])
            @case('text')
                <x-form.text-input label="{{  __($field['label'] ?? 'Default Label') }}" :type="$field['input_type'] ?? 'text'"
                                   name="data.{{ $field['slug'] }}.value" id="{{ $field['slug'] }}"
                                   :readonly="($field['is_readonly'] ?? 'no') === 'yes'" :disabled="($field['is_disabled'] ?? 'no') === 'yes'" />
                @break

            @case('checkbox')
                <div class="row">
                    @foreach ($field['option'] ?? [] as $option)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox"
                                       id="{{ $field['slug'] }}-{{ $option['value'] }}"
                                       @if (($field['is_disabled'] ?? 'no') === 'yes') disabled @endif
                                       wire:model="data.{{ $field['slug'] }}.value"
                                       value="{{ $option['value'] }}">
                                <label class="form-label"
                                       for="{{ $field['slug'] }}-{{ $option['value'] }}"
                                       style="font-size: 0.95rem;">
                                    {{__(ucwords(str_replace('_', ' ', $option['label'])) )}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @break

            @case('select')
                <x-form.select-input label="{{ __($field['label'] ?? 'Default Label' )}}"
                                     name="data.{{ $field['slug'] }}.value" id="{{ $field['slug'] }}"
                                     :options="collect($field['option'] ?? [])
                                                ->pluck('label', 'value')
                                                ->toArray()" placeholder="{{ $field['placeholder'] ?? 'Select any one' }}"
                                     :multiple="($field['is_multiple'] ?? 'no') === 'yes'" :disabled="($field['is_disabled'] ?? 'no') === 'yes'" />
                @break

            @case('radio')
                <x-form.radio-input label="{{  __($field['label'] ?? 'Default Label') }}"
                                    name="data.{{ $field['slug'] }}.value" :options="collect($field['option'] ?? [])
                                                ->pluck('value', 'label')
                                                ->toArray()" :checked="$field['default_value'] ?? ''"
                                    :disabled="($field['is_disabled'] ?? 'no') === 'yes'" />
                @break

            @case('file')
                <x-form.file-input label="{{ __( $field['label'] ?? 'Default Label') }}"
                                   name="data.{{ $field['slug'] ?? 'file' }}.value"
                                   id="{{ $field['slug'] ?? '' }}" :disabled="($field['is_disabled'] ?? 'no') === 'yes'" :multiple="($field['is_multiple'] ?? 'no') === 'yes'" />
                @break

            @case('table')
                <div class="table-container mt-3">
                    <label>{{ __($field['label'] ?? 'Table') }}</label>
                    <table class="table table-bordered table-striped">
                        <tbody>
                        @foreach ($field['fields'] as $rowIndex => $row)
                            <tr>
                                @foreach ($row as $k => $j)
                                    <td>
                                        @switch($j['type'])
                                            @case('text')
                                                <x-form.text-input
                                                        name="data.{{ $field['slug'] }}.fields.{{ $rowIndex }}.{{ $j['slug'] }}.value"
                                                        label="{{ $j['label'] }}"
                                                        id="{{ $field['slug'] }}.{{ $key }}.{{ $rowIndex }}.{{ $j['slug'] }}}"
                                                        :placeholder="$j['placeholder'] ??
                                                                                    'Enter value'" :readonly="($j['is_readonly'] ?? 'no') === 'yes'"
                                                        :disabled="($j['is_disabled'] ?? 'no') === 'yes'" />
                                                @break

                                            @case('select')
                                                <x-form.select-input
                                                        name="data.{{ $field['slug'] }}.fields.{{ $rowIndex }}.{{ $j['slug'] }}.value"
                                                        label="{{ $j['label'] }}" :multiple="($j['is_multiple'] ?? 'no') === 'yes'"
                                                        id="{{ $field['slug'] }}.{{ $rowIndex }}.{{ $j['slug'] }}"
                                                        :options="collect($j['option'] ?? [])
                                                                                    ->pluck('label', 'value')
                                                                                    ->toArray()" :placeholder="$j['placeholder'] ??
                                                                                    'Select'"
                                                        :disabled="($j['is_disabled'] ?? 'no') === 'yes'" />
                                                @break

                                            @case('file')
                                                <x-form.file-input label="{{ $j['label'] ?? '' }}"
                                                                   name="data.{{ $field['slug'] }}.fields.{{ $rowIndex }}.{{ $j['slug'] }}.value"
                                                                   id="{{ $field['slug'] }}.{{ $rowIndex }}.{{ $j['slug'] }}"
                                                                   :disabled="($j['is_disabled'] ?? 'no') === 'yes'" :multiple="($j['is_multiple'] ?? 'no') === 'yes'" />
                                                @break
                                        @endswitch
                                    </td>
                                @endforeach
                                <td>
                                    <button type="button"
                                            wire:click="removeTableRow('{{ $field['slug'] }}', {{ $rowIndex }})"
                                            class="btn btn-danger">
                                        <i class="bx bx-trash"> </i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="text-end mt-3">
                        <button type="button" wire:click="addTableRow('{{ $field['slug'] }}')"
                                class="btn btn-primary">
                            {{ __('Add Row') }}
                        </button>
                    </div>

                </div>
                @break
            @case('group')
                <div class="pl-4 border-l-4 border-primary mb-4">
                    <div class="divider divider-primary text-start text-primary">
                        <h5 class="divider-text ">{{__($field['label'] ?? 'Group') }}</h5>
                    </div>
                    @foreach ($field['fields'] as $j)
                        @switch($j['type'])
                            @case('text')
                                <x-form.text-input
                                        name="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value"
                                        label="{{  __($j['label'])}}"
                                        id="{{ $field['slug'] }}.{{ $j['slug'] }}"
                                        :placeholder="$j['placeholder'] ?? 'Enter value'"
                                        :readonly="($j['is_readonly'] ?? 'no') === 'yes'"
                                        :disabled="($j['is_disabled'] ?? 'no') === 'yes'" />
                                @break

                            @case('select')
                                <x-form.select-input
                                        name="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value"
                                        label="{{  __($j['label']) }}"
                                        :multiple="($j['is_multiple'] ?? 'no') === 'yes'"
                                        id="{{ $field['slug'] }}.{{ $j['slug'] }}"
                                        :options="collect($j['option'] ?? [])->pluck('label', 'value')->toArray()"
                                        :placeholder="$j['placeholder'] ?? 'Select'"
                                        :disabled="($j['is_disabled'] ?? 'no') === 'yes'" />
                                @break

                            @case('file')
                                <x-form.file-input
                                        label="{{ $j['label'] ?? '' }}"
                                        name="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value"
                                        id="{{ $field['slug'] }}.{{ $j['slug'] }}"
                                        :disabled="($j['is_disabled'] ?? 'no') === 'yes'"
                                        :multiple="($j['is_multiple'] ?? 'no') === 'yes'" />
                                @break
                            @case('radio')
                                <x-form.radio-input label="{{  __($j['label'] ?? 'Default Label') }}"
                                                    name="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value" :options="collect($j['option'] ?? [])
                                                ->pluck('value', 'label')
                                                ->toArray()" :checked="$j['default_value'] ?? ''"
                                                    :disabled="($j['is_disabled'] ?? 'no') === 'yes'" />
                                @break
                            @case('checkbox')
                                @foreach ($j['option'] ?? [] as $option)
                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox"
                                                   id="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value"
                                                   @if (($j['is_disabled'] ?? 'no') === 'yes') disabled @endif
                                                   wire:model="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value"
                                                   value="{{ $j['value'] }}">
                                            <label class="form-label"
                                                   for="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value"
                                                   style="font-size: 0.95rem;">
                                                {{  __(ucwords(str_replace('_', ' ', $j['label']))) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                @break
                        @endswitch
                    @endforeach
                </div>
                @break

            @default
                <p>{{  __($field['label'] ?? 'Unknown Field Type') }}</p>
        @endswitch

        @if (!empty($field['helper_text']))
            <small class="form-text text-muted">{{  __($field['helper_text']) }}</small>
        @endif

        @error('data.' . $field['slug'] . '.value')
        <div class="text-danger">{{  __($message) }}</div>
        @enderror
    </div>
