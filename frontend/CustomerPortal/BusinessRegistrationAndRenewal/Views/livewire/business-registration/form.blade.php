<form wire:submit.prevent="save" enctype="multipart/form-data">
    @csrf
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Primary Detail') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="fiscal_year_id" class="form-label">{{ __('Fiscal Year') }}</label>
                        <select wire:model="businessRegistration.fiscal_year_id" name="fiscal_year_id"
                            class="form-select" id="fiscal_year_id" disabled>
                            <option>{{ __('Select Fiscal Year') }}</option>
                            @foreach ($fiscalYears as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('fiscal_year_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="entity_name"
                            class="form-label">{{ __('Business | Organization | Industry Name') }}</label>
                        <input wire:model="businessRegistration.entity_name" name="entity_name" type="text"
                            class="form-control" placeholder="{{ __('Business | Organization | Industry Name') }}">
                        <div>
                            @error('businessRegistration.entity_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="mobile_no"
                            class="form-label">{{ __('Business | Organization | Industry Contact Info') }}</label>
                        <input wire:model="businessRegistration.mobile_no" name="mobile_no" type="tel"
                            class="form-control"
                            placeholder="{{ __('Business | Organization | Industry Contact Info') }}">
                        <div>
                            @error('businessRegistration.mobile_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3" wire:ignore>
                    <div class="form-group">
                        <label for="business_nature" class="form-label">{{ __('Select Nature') }}</label>
                        <select wire:model.live="businessRegistration.business_nature" id="business_nature"
                            class="form-control {{ $errors->has('businessRegistration.business_nature') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('businessRegistration.business_nature') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                            <option>{{ __('Select Business Nature') }}</option>
                            @foreach ($businessNatures as $label => $value)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('businessRegistration.business_nature')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-6 mb-3" wire:ignore>
                    <div class="form-group">
                        <label for="department_id" class="form-label">{{ __('Select Department') }}</label>
                        <span class="text-danger">*</span>
                        <select wire:model.live="businessRegistration.department_id" id="department_id" required
                            class="form-control {{ $errors->has('businessRegistration.department_id') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('businessRegistration.department_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                            <option>{{ __('Select Department') }}</option>
                            @foreach ($departments as $label => $value)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('businessRegistration.department_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div> --}}

                <div class="divider divider-primary text-start text-primary font-14">
                    <h5 class="divider-text ">{{ __('Address Details') }}</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="province_id" class="form-label">{{ __('Province') }}</label>
                        <select wire:model.live="businessRegistration.province_id" name="province_id"
                            class="form-select" wire:change="getDistricts">
                            <option value="" selected hidden>{{ __('Select Province') }}</option>
                            @foreach ($provinces as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('businessRegistration.province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="district_id" class="form-label">{{ __('District') }}</label>
                        <select wire:model.live="businessRegistration.district_id" name="district_id"
                            class="form-select" wire:change="getLocalBodies">
                            <option value="" selected hidden>{{ __('Select District') }}</option>
                            @foreach ($districts as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('businessRegistration.district_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="local_body_id" class="form-label">{{ __('Local Body') }}</label>
                        <select wire:model.live="businessRegistration.local_body_id" name="local_body_id"
                            class="form-select" wire:change="getWards">
                            <option value="" selected hidden>{{ __('Select Local Body') }}</option>
                            @foreach ($localBodies as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('businessRegistration.local_body_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="ward_no" class="form-label">{{ __('Ward') }}</label>
                        <select wire:model.live="businessRegistration.ward_no" name="ward_no" class="form-select">
                            <option value="" selected hidden>{{ __('Select Ward') }}</option>
                            @foreach ($wards as $id => $title)
                                <option value="{{ $title }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('businessRegistration.ward_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="tole" class="form-label">{{ __('Enter Tole') }}</label>
                        <input wire:model="businessRegistration.tole" name="tole" type="text" class="form-control"
                            placeholder="{{ __('Enter Tole') }}">
                        <div>
                            @error('businessRegistration.tole')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="way" class="form-label">{{ __('Enter Way') }}</label>
                        <input wire:model="businessRegistration.way" name="way" type="text"
                            class="form-control" placeholder="{{ __('Enter Way') }}">
                        <div>
                            @error('businessRegistration.way')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Business | Organization | Industry Detail') }}</h5>
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label class="form-label">{{ __('Select Registration Category') }}</label>
                        <select class="form-select" wire:change.live="getRegistrationTypes($event.target.value)">
                            <option>{{ __('Select Registration Category') }}</option>
                            @foreach ($registrationCategories as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('businessRegistration.registration_type_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="registration_type_id"
                            class="form-label">{{ __('Select Registration Type') }}</label>
                        <select wire:model.live="businessRegistration.registration_type_id" class="form-select"
                            wire:change.live="setFields($event.target.value)">
                            <option>{{ __('Select Registration Type') }}</option>
                            @foreach ($registrationTypes as $label => $value)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('businessRegistration.registration_type_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div id="dynamic-form">
                    @if (!empty($data))
                        @foreach ($data as $key => $field)
                            <div class="form-group mb-3">
                                @switch($field['type'])
                                    @case('text')
                                        <x-form.text-input label="{{ $field['label'] ?? 'Default Label' }}" :type="$field['input_type'] ?? 'text'"
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
                                                        <label class="form-check-label"
                                                            for="{{ $field['slug'] }}-{{ $option['value'] }}"
                                                            style="font-size: 0.95rem;">
                                                            {{ ucwords(str_replace('_', ' ', $option['label'])) }}
                                                        </label>
                                                    </div>
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
                                            :multiple="($field['is_multiple'] ?? 'no') === 'yes'" :disabled="($field['is_disabled'] ?? 'no') === 'yes'" />
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
                                            :disabled="($field['is_disabled'] ?? 'no') === 'yes'" :multiple="($field['is_multiple'] ?? 'no') === 'yes'" />
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
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        <a href="javascript:history.back()" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('Back') }}</a>
    </div>
</form>


@script
    <script>
        $(document).ready(function() {

            const natureSelect = $('#business_nature');
            natureSelect.select2();

            natureSelect.on('change', function() {
                @this.set('businessRegistration.business_nature', $(this).val());
            })

            const departmentSelect = $('#department_id');
            departmentSelect.select2();

            departmentSelect.on('change', function() {
                @this.set('businessRegistration.department_id', $(this).val());
            })
        })
    </script>
@endscript
