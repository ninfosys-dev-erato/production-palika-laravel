<form wire:submit.prevent="save">
    <div class="card mb-3 rounded-0">
        <div class="card-body">


            <!-- Group 1: General Information -->
            <div class="divider divider-primary text-start text-primary mb-4">
                <div class="divider-text fw-bold fs-6">
                    {{ __('beruju::beruju.general_information') }}
                </div>
            </div>
            <div class="row g-4">
                <!-- Fiscal Year ID -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="fiscal_year_id" class="form-label">{{ __('beruju::beruju.fiscal_year_id') }}</label>
                        <select wire:model="berujuEntry.fiscal_year_id"
                            class="form-select rounded-0 @error('berujuEntry.fiscal_year_id') is-invalid @enderror">
                            <option value="">{{ __('beruju::beruju.select_fiscal_year') }}</option>
                            @foreach ($fiscalYears as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('berujuEntry.fiscal_year_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Audit Type -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="audit_type" class="form-label">{{ __('beruju::beruju.audit_type') }}</label>
                        <select wire:model="berujuEntry.audit_type"
                            class="form-select rounded-0 @error('berujuEntry.audit_type') is-invalid @enderror">
                            <option value="">{{ __('beruju::beruju.select_audit_type') }}</option>
                            @foreach ($auditTypeOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('berujuEntry.audit_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Entry Date -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="entry_date" class="form-label">{{ __('beruju::beruju.entry_date') }}</label>
                        <input wire:model="berujuEntry.entry_date" type="text"
                            class="form-control rounded-0 nepali-date @error('berujuEntry.entry_date') is-invalid @enderror"
                            placeholder="{{ __('beruju::beruju.enter_entry_date') }}">
                        @error('berujuEntry.entry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Reference Number -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="reference_number"
                            class="form-label">{{ __('beruju::beruju.reference_number') }}</label>
                        <input wire:model="berujuEntry.reference_number" type="text"
                            class="form-control rounded-0 @error('berujuEntry.reference_number') is-invalid @enderror"
                            placeholder="{{ __('beruju::beruju.enter_reference_number') }}">
                        @error('berujuEntry.reference_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Branch ID -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="branch_id" class="form-label">{{ __('beruju::beruju.branch_id') }}</label>
                        <select wire:model="berujuEntry.branch_id"
                            class="form-select rounded-0 @error('berujuEntry.branch_id') is-invalid @enderror">
                            <option value="">{{ __('beruju::beruju.select_branch') }}</option>
                            @foreach ($branches as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('berujuEntry.branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Project ID -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="project_id" class="form-label">{{ __('beruju::beruju.project_id') }}</label>
                        <input wire:model="berujuEntry.project_id" type="text"
                            class="form-control rounded-0 @error('berujuEntry.project_id') is-invalid @enderror"
                            placeholder="{{ __('beruju::beruju.enter_project_id') }}">
                        {{-- <select wire:model="berujuEntry.project_id"
                            class="form-select rounded-0 @error('berujuEntry.project_id') is-invalid @enderror">
                            <option value="">{{ __('beruju::beruju.select_project') }}</option>
                            <!-- Options will be added later -->
                        </select> --}}
                        @error('berujuEntry.project_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3 rounded-0">
        <div class="card-body">


            <!-- Group 2: Beruju Details -->
            <div class="divider divider-primary text-start text-primary mb-4">
                <div class="divider-text fw-bold fs-6">
                    {{ __('beruju::beruju.beruju_details') }}
                </div>
            </div>
            <div class="row g-4">
                <!-- Beruju Category -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="beruju_category"
                            class="form-label">{{ __('beruju::beruju.beruju_category') }}</label>
                        <select wire:model="berujuEntry.beruju_category"
                            class="form-select rounded-0 @error('berujuEntry.beruju_category') is-invalid @enderror">
                            <option value="">{{ __('beruju::beruju.select_beruju_category') }}
                            </option>
                            @foreach ($berujuCategoryOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('berujuEntry.beruju_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Sub Category ID -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="sub_category_id"
                            class="form-label">{{ __('beruju::beruju.sub_category_id') }}</label>
                        <select wire:model="berujuEntry.sub_category_id"
                            class="form-select rounded-0 @error('berujuEntry.sub_category_id') is-invalid @enderror">
                            <option value="">{{ __('beruju::beruju.select_sub_category') }}</option>
                            @foreach ($subCategories as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('berujuEntry.sub_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Amount -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="amount" class="form-label">{{ __('beruju::beruju.amount') }}</label>
                        <input wire:model="berujuEntry.amount" type="number" step="0.01"
                            class="form-control rounded-0 @error('berujuEntry.amount') is-invalid @enderror"
                            placeholder="{{ __('beruju::beruju.enter_amount') }}">
                        @error('berujuEntry.amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Currency Type -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="currency_type" class="form-label">{{ __('beruju::beruju.currency_type') }}</label>
                        <select wire:model="berujuEntry.currency_type"
                            class="form-select rounded-0 @error('berujuEntry.currency_type') is-invalid @enderror">
                            <option value="">{{ __('beruju::beruju.select_currency_type') }}
                            </option>
                            @foreach ($currencyTypeOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('berujuEntry.currency_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Legal Provision -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="legal_provision"
                            class="form-label">{{ __('beruju::beruju.legal_provision') }}</label>
                        <input wire:model="berujuEntry.legal_provision" type="text"
                            class="form-control rounded-0 @error('berujuEntry.legal_provision') is-invalid @enderror"
                            placeholder="{{ __('beruju::beruju.enter_legal_provision') }}">
                        @error('berujuEntry.legal_provision')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Deadline -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="action_deadline"
                            class="form-label">{{ __('beruju::beruju.action_deadline') }}</label>
                        <input wire:model="berujuEntry.action_deadline" type="text"
                            class="form-control rounded-0 nepali-date @error('berujuEntry.action_deadline') is-invalid @enderror"
                            placeholder="{{ __('beruju::beruju.enter_action_deadline') }}">
                        @error('berujuEntry.action_deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card  mb-3 rounded-0">
        <div class="card-body">


            <!-- Group 3: Description and Notes -->
            <div class="divider divider-primary text-start text-primary mb-4">
                <div class="divider-text fw-bold fs-6">
                    {{ __('beruju::beruju.details_and_evidences') }}
                </div>
            </div>
            <div class="row g-4">

                <!-- Description -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('beruju::beruju.description') }}</label>
                        <textarea wire:model="berujuEntry.description" rows="5"
                            class="form-control rounded-0 @error('berujuEntry.description') is-invalid @enderror"
                            placeholder="{{ __('beruju::beruju.enter_description') }}"></textarea>
                        @error('berujuEntry.description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="notes" class="form-label">{{ __('beruju::beruju.notes') }}</label>
                        <textarea wire:model="berujuEntry.notes" rows="5"
                            class="form-control rounded-0 @error('berujuEntry.notes') is-invalid @enderror"
                            placeholder="{{ __('beruju::beruju.enter_notes') }}"></textarea>
                        @error('berujuEntry.notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

    </div>

    <livewire:beruju.evidence_document_upload :$berujuEntry />




    <div class="card-footer">
        <button type="submit" class="btn btn-primary rounded-0"
            wire:loading.attr="disabled">{{ __('beruju::beruju.save') }}</button>
        <a href="{{ route('admin.beruju.registration.index') }}" class="btn btn-secondary rounded-0">
            {{ __('beruju::beruju.back') }}
        </a>
    </div>

</form>
