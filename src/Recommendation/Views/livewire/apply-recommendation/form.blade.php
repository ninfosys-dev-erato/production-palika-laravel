<div>
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    @if ($showCategory)
                        <div class="divider divider-primary text-start text-primary font-14">
                            <div class="divider-text ">{{ __('recommendation::recommendation.recommendation_details') }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            @if ($action === App\Enums\Action::CREATE)
                                <label
                                    for="recommendation_category_id">{{ __('recommendation::recommendation.recommendation_category') }}</label>
                                <span class="text-danger">*</span>
                                <select dusk="recommendation-recommendation_category_id-field"
                                    id="recommendation_category_id" name="recommendation_category_id"
                                    class="form-select select2-component @error('recommendation_category_id') is-invalid @enderror"
                                    style="width: 100%;" required wire:model="recommendation_category_id"
                                    wire:change.live="loadRecommendation($event.target.value)">
                                    <option value="" hidden>
                                        {{ __('recommendation::recommendation.choose_recommendation_category') }}
                                    </option>
                                    @foreach ($recommendationCategory as $id => $title)
                                        <option value="{{ $id }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                                @error('recommendation_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            @if ($action === App\Enums\Action::CREATE)
                                <label
                                    for="recommendation_id">{{ __('recommendation::recommendation.recommendation') }}</label>
                                <span class="text-danger">*</span>
                                <select dusk="recommendation-recommendation_id-field" id="recommendation_id"
                                    name="recommendation_id" class="form-control" wire:model="recommendation_id"
                                    wire:change="setFields($event.target.value)">
                                    <option value="" hidden>
                                        {{ __('recommendation::recommendation.choose_recommendation') }}</option>
                                    @foreach ($recommendations as $id => $title)
                                        <option value="{{ $id }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                            @elseif($action === App\Enums\Action::UPDATE)
                                <label
                                    for="recommendation_id">{{ __('recommendation::recommendation.recommendation') }}</label>
                                <input type="text" readonly class="form-control"
                                    value="{{ $this->applyRecommendation->recommendation->title ?? '' }}">
                            @endif
                        </div>
                    @else
                        <h4 class="text-primary"><i class="bx bx-radio-circle"></i> {{ $recommendation->title }}</h4>
                    @endif
                </div>
                <div class="form-group col-md-2">
                    <label for="signee" class="form-label">{{ __('recommendation::recommendation.signee') }}</label>
                    @if ($applyRecommendation->ward_id)
                        <livewire:signee-select :wards="[$applyRecommendation->ward_id]" :selectedUserId="$applyRecommendation->signee_id" :departments="[$applyRecommendation->recommendation->branches]" />
                    @else
                        <livewire:signee-select />
                    @endif

                </div>
                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text ">{{ __('recommendation::recommendation.applicant_details') }}</div>
                </div>
                <div class="col-md-10 mb-3" wire:ignore>
                    @if ($action === App\Enums\Action::CREATE)
                        <x-form.select-input label="{{ __('recommendation::recommendation.customer') }}"
                            id="customer_id" name="customer_id" wire:model="customer_id"
                            placeholder="{{ __('recommendation::recommendation.choose_customer') }}" required />
                    @elseif($action === App\Enums\Action::UPDATE)
                        <label for="name">{{ __('recommendation::recommendation.customer') }}</label>
                        <input type="text" readonly class="form-control"
                            value="{{ $this->applyRecommendation->customer->name . ' ( ' . $this->applyRecommendation->customer->mobile_no . ' ) ' }}">
                    @endif
                </div>
                @if ($action === App\Enums\Action::CREATE)
                    <div class="col-md-2 mb-3">
                        <button type="button" class="form-control" style="margin-top: 20px; "
                            wire:click="openCustomerKycModal">
                            + {{ __('recommendation::recommendation.add_customer') }}</button>
                    </div>
                @endif

                <div class="col-md-10 mb-3" wire:ignore>
                    @if ($action === App\Enums\Action::CREATE)
                        <label for="fiscal_year_id">{{ __('recommendation::recommendation.fiscal_year') }}</label>
                        <select dusk="recommendation-fiscal_year_id-field" id="fiscal_year_id" name="fiscal_year_id"
                            class="form-control" wire:model="fiscal_year_id">
                            <option value="">{{ __('recommendation::recommendation.choose_fiscal_year') }}
                            </option>
                            @foreach ($fiscalYears as $year)
                                <option value="{{ $year->id }}">{{ $year->year }}</option>
                            @endforeach
                        </select>
                    @elseif($action === App\Enums\Action::UPDATE)
                        <label for="name">{{ __('recommendation::recommendation.fiscal_year') }}</label>
                        <input type="text" readonly class="form-control"
                            value="{{ $this->applyRecommendation->fiscalYear?->year }}">
                    @endif
                </div>

                @if (!empty($data))
                    <div class="divider divider-primary text-start text-primary font-14">
                        <div class="divider-text ">
                            {{ __('recommendation::recommendation.recommendation_description') }}</div>
                    </div>
                    <div class="col-md-12">
                        @foreach ($data as $key => $field)
                            @if (key_exists('slug', $field))
                                <div class="form-group mb-3">
                                    @switch($field['type'])
                                        @case('text')
                                            <x-form.text-input label="{{ $field['label'] ?? 'Default Label' }}"
                                                :type="$field['input_type'] ?? 'text'" name="data.{{ $field['slug'] }}.value"
                                                id="{{ $field['slug'] }}" :readonly="($field['is_readonly'] ?? 'no') === 'yes'" :disabled="($field['is_disabled'] ?? 'no') === 'yes'" />
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
                                                name="data.{{ $field['slug'] }}.value" id="{{ $field['slug'] }}"
                                                :options="collect($field['option'] ?? [])
                                                    ->pluck('label', 'value')
                                                    ->toArray()" placeholder="{{ $field['placeholder'] ?? 'Select any one' }}"
                                                :multiple="($field['is_multiple'] ?? '0') === '1'" :disabled="($field['is_disabled'] ?? 'no') === 'yes'" />
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
                                                name="data.{{ $field['slug'] ?? 'file' }}.value"
                                                id="{{ $field['slug'] ?? '' }}" :disabled="($field['is_disabled'] ?? 'no') === 'yes'" :multiple="($field['is_multiple'] ?? '0') === '1'" />
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
                                                                                    :options="collect(
                                                                                        $j['option'] ?? [],
                                                                                    )
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

                                        @case('group')
                                            <div class="pl-4 border-l-4 border-primary mb-4">
                                                <div class="divider divider-primary text-start text-primary">
                                                    <h5 class="divider-text ">{{ __($field['label'] ?? 'Group') }}</h5>
                                                </div>
                                                @foreach ($field['fields'] as $j)
                                                    @switch($j['type'])
                                                        @case('text')
                                                            <x-form.text-input
                                                                name="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value"
                                                                label="{{ __($j['label']) }}"
                                                                id="{{ $field['slug'] }}.{{ $j['slug'] }}" :placeholder="$j['placeholder'] ?? 'Enter value'"
                                                                :readonly="($j['is_readonly'] ?? 'no') === 'yes'" :disabled="($j['is_disabled'] ?? 'no') === 'yes'" />
                                                        @break

                                                        @case('select')
                                                            <x-form.select-input
                                                                name="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value"
                                                                label="{{ __($j['label']) }}" :multiple="($j['is_multiple'] ?? 'no') === 'yes'"
                                                                id="{{ $field['slug'] }}.{{ $j['slug'] }}" :options="collect($j['option'] ?? [])
                                                                    ->pluck('label', 'value')
                                                                    ->toArray()"
                                                                :placeholder="$j['placeholder'] ?? 'Select'" :disabled="($j['is_disabled'] ?? 'no') === 'yes'" />
                                                        @break

                                                        @case('file')
                                                            <x-form.file-input label="{{ $j['label'] ?? '' }}"
                                                                name="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value"
                                                                id="{{ $field['slug'] }}.{{ $j['slug'] }}" :disabled="($j['is_disabled'] ?? 'no') === 'yes'"
                                                                :multiple="($j['is_multiple'] ?? 'no') === 'yes'" />
                                                        @break

                                                        @case('radio')
                                                            <x-form.radio-input label="{{ __($j['label'] ?? 'Default Label') }}"
                                                                name="data.{{ $field['slug'] }}.fields.{{ $j['slug'] }}.value"
                                                                :options="collect($j['option'] ?? [])
                                                                    ->pluck('value', 'label')
                                                                    ->toArray()" :checked="$j['default_value'] ?? ''" :disabled="($j['is_disabled'] ?? 'no') === 'yes'" />
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
                                                                            {{ __(ucwords(str_replace('_', ' ', $j['label']))) }}
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
    @if ($showCustomerKycModal)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('recommendation::recommendation.create_customer') }}</h5>
                        <button type="button" wire:click="closeCustomerKycModal"
                            class="btn btn-light d-flex justify-content-center align-items-center shadow-sm"
                            style="width: 40px; height: 40px; border: none; background-color: transparent;">
                            <span style="color: red; font-size: 20px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <livewire:customers.customer_form :$action :$isModalForm :isFo />
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            const ward = @json(App\Facades\GlobalFacade::ward());

            $('#customer_id').select2({
                ajax: {
                    url: function(params) {
                        let base = '{{ parse_url(url()->route('customers.search'), PHP_URL_PATH) }}';
                        let query = [];

                        if (params.term) {
                            if (/^\d+$/.test(params.term)) {
                                query.push('filter[mobile_no]=' + params.term);
                            } else {
                                query.push('filter[name]=' + params.term);
                            }
                        }

                        query.push('ward=' + ward); // pass ward directly

                        return base + '?' + query.join('&');
                    },
                    delay: 250,
                    processResults: function(data) {
                        let selectOptions = [{
                            id: '',
                            text: 'All Customers'
                        }];

                        $.each(data.data, function(v, r) {
                            let option_name = r.mobile_no + ' (' + r.name + ')';
                            selectOptions.push({
                                id: r.id,
                                text: option_name
                            });
                        });

                        return {
                            results: selectOptions
                        };
                    }
                },
                templateSelection: function(data) {
                    return data.text;
                }
            }).on('select2:select', function(e) {
                @this.set('customer_id', $(this).val());
            });
        });
    </script>
@endpush

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
