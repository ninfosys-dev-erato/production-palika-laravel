<div>
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">

                @if ($showCategory)
                    @if ($action === App\Enums\Action::CREATE)
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label
                                for="recommendation_category_id">{{ __('recommendation::recommendation.recommendation_category') }}</label>
                            <span class="text-danger">*</span>
                            <select id="recommendation_category_id" name="recommendation_category_id" class="form-control"
                                class="form-select select2-component @error('recommendation_category_id') is-invalid @enderror"
                                wire:model="recommendation_category_id"
                                wire:change="loadRecommendation($event.target.value)" required>
                                <option value="" hidden>
                                    {{ __('recommendation::recommendation.choose_recommendation_category') }}</option>
                                @foreach ($recommendationCategory as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            @error('recommendation_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    @if ($action === App\Enums\Action::CREATE)
                        <div class="col-md-6 mb-3">
                            <label
                                for="recommendation_id">{{ __('recommendation::recommendation.recommendation') }}</label>
                            <span class="text-danger">*</span>
                            <select id="recommendation_id" name="recommendation_id" class="form-control"
                                wire:model="recommendation_id" wire:change="setFields($event.target.value)" required>
                                <option value="" hidden>
                                    {{ __('recommendation::recommendation.choose_recommendation') }}</option>
                                @foreach ($recommendations as $recommendation)
                                    <option value="{{ $recommendation->id }}">{{ $recommendation->title }}</option>
                                @endforeach
                            </select>
                        @elseif($action === App\Enums\Action::UPDATE)
                            <label
                                for="recommendation_id">{{ __('recommendation::recommendation.recommendation') }}</label>
                            <input type="text" readonly class="form-control"
                                value="{{ $this->applyRecommendation->recommendation->title ?? '' }}">
                    @endif
                @else
                    <h4 class="text-primary"><i class="bx bx-radio-circle"></i> {{ $recommendation->title }}</h4>
                @endif
            </div>

            @if (!empty($data))
                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text ">{{ __('recommendation::recommendation.recommendation_description') }}
                    </div>
                </div>
                <div class="col-md-12">
                    @foreach ($data as $key => $field)
                        @if (key_exists('slug', $field))
                            <div class="form-group mb-3">
                                @switch($field['type'])
                                    @case('text')
                                        <x-form.text-input label="{{ $field['label'] ?? 'Default Label' }}" :type="$field['input_type'] ?? 'text'"
                                            name="data.{{ $field['slug'] }}.value" id="{{ $field['slug'] }}" :readonly="($field['is_readonly'] ?? 'no') === 'yes'"
                                            :disabled="($field['is_disabled'] ?? 'no') === 'yes'" />
                                    @break

                                    @case('checkbox')
                                        <div>
                                            <label class="form-label">{{ $field['label'] ?? 'Checkbox' }}</label>
                                            @php
                                                $isMultiple = ($field['is_multiple'] ?? '0') === '1';
                                                $inputType = $isMultiple ? 'checkbox' : 'radio';
                                                $modelPath = "data.{$field['slug']}.value";
                                            @endphp

                                            @foreach ($field['option'] ?? [] as $option)
                                                <div class="form-check {{ $isMultiple ? 'form-check-inline' : '' }}">
                                                    <input type="{{ $inputType }}"
                                                        name="data.{{ $field['slug'] }}.value{{ $isMultiple ? '[]' : '' }}"
                                                        value="{{ $option['value'] }}"
                                                        id="{{ $field['slug'] }}-{{ $option['value'] }}"
                                                        class="form-check-input"
                                                        wire:model{{ $isMultiple ? '.live' : '' }}="{{ $modelPath }}{{ $isMultiple ? '.' . $option['value'] : '' }}"
                                                        @if (($field['is_disabled'] ?? 'no') === 'yes') disabled @endif>
                                                    <label class="form-check-label"
                                                        for="{{ $field['slug'] }}-{{ $option['value'] }}">
                                                        {{ $option['label'] }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @break

                                    @case('select')
                                        <x-form.select-input label="{{ $field['label'] ?? 'Default Label' }}"
                                            name="data.{{ $field['slug'] }}.value" id="{{ $field['slug'] }}" :options="collect($field['option'] ?? [])
                                                ->pluck('label', 'value')
                                                ->toArray()"
                                            placeholder="{{ $field['placeholder'] ?? 'Select any one' }}" :multiple="($field['is_multiple'] ?? '0') === '1'"
                                            :disabled="($field['is_disabled'] ?? 'no') === 'yes'" />
                                    @break

                                    @case('radio')
                                        <x-form.radio-input label="{{ $field['label'] ?? 'Default Label' }}"
                                            name="data.{{ $field['slug'] }}.value" :options="collect($field['option'] ?? [])
                                                ->pluck('value', 'label')
                                                ->toArray()" :checked="$field['default_value'] ?? ''"
                                            :disabled="($field['is_disabled'] ?? 'no') === 'yes'" />
                                    @break

                                    @case('file')
                                        <x-form.file-input label="{{ $field['label'] ?? 'Default Label' }}"
                                            name="data.{{ $field['slug'] ?? 'file' }}.value" id="{{ $field['slug'] ?? '' }}"
                                            :disabled="($field['is_disabled'] ?? 'no') === 'yes'" :multiple="($field['is_multiple'] ?? '0') === '1'" />
                                    @break

                                    @case('table')
                                        <div class="table-container mt-3">
                                            <label>{{ $field['label'] ?? 'Table' }}</label>
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
                                                                                name="data.{{ $field['slug'] }}.{{ $key }}.{{ $rowIndex }}.{{ $j['slug'] }}.value"
                                                                                label="{{ $field['label'] }}"
                                                                                id="{{ $field['slug'] }}.{{ $key }}.{{ $rowIndex }}.{{ $j['slug'] }}"
                                                                                :options="collect($j['option'] ?? [])
                                                                                    ->pluck('label', 'value')
                                                                                    ->toArray()" :placeholder="$j['placeholder'] ??
                                                                                    'Select'"
                                                                                :disabled="($j['is_disabled'] ?? 'no') === 'yes'" />
                                                                        @break
                                                                    @endswitch
                                                                </td>
                                                            @endforeach
                                                            <td>
                                                                <button type="button"
                                                                    wire:confirm="Are you sure you want to delete this record?"
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
                                                    {{ __('recommendation::recommendation._add_row') }}
                                                </button>
                                            </div>

                                        </div>
                                    @break

                                    @default
                                        <p>{{ $field['label'] ?? 'Unknown Field Type' }}</p>
                                @endswitch

                                @if (!empty($field['helper_text']))
                                    <small class="form-text text-muted">{{ $field['helper_text'] }}</small>
                                @endif

                                @error('data.' . $field['slug'] . '.value')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    @endforeach
                </div>

            @endif

            <div class='col-md-12'>
                <x-form.text-input label="{{ __('recommendation::recommendation.remarks') }}" id="remarks"
                    name="applyRecommendation.remarks" wire:model="applyRecommendation.remarks"
                    placeholder="{{ __('recommendation::recommendation.remarks') }}" />
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                {{ __('recommendation::recommendation.save') }}
            </button>
            <a href="{{ route('admin.recommendations.apply-recommendation.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger ml-2">
                {{ __('recommendation::recommendation.back') }}
            </a>
        </div>
    </form>
</div>

@script
    <script>
        $(document).ready(function() {

            const branchSelect = $('#recommendation_category_id');

            branchSelect.select2();

            branchSelect.on('change', function() {
                @this.set('recommendation_category_id', $(this).val());
                @this.call('loadRecommendation', $(this).val());

            })
        })
    </script>
@endscript
