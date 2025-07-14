<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">{{ __('grantmanagement::grantmanagement.grant_programs_report') }}</h4>
        <div class="d-flex gap-2 ms-auto">
            <button type="button" wire:click="export" class="btn btn-outline-primary btn-sm">
                {{ __('grantmanagement::grantmanagement.export') }}
            </button>
            <button wire:click='downloadPdf' class="btn btn-outline-primary btn-sm" target="_blank">
                {{ __('grantmanagement::grantmanagement.pdf') }}
            </button>
        </div>
    </div>

    <div class=" py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="divider divider-primary text-start text-primary fw-bold mx-4 mb-0">
                <div class="divider-text fs-4">{{ __('grantmanagement::grantmanagement.search') }}</div>
            </div>

            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md col-12">
                        <label for="start_date" class="form-label">
                            {{ __('grantmanagement::grantmanagement.start_date') }}
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="start_date" id="start_date"
                                class="form-control border-start-0 nepali-date"
                                placeholder="{{ __('grantmanagement::grantmanagement.start_date') }}">
                        </div>
                        @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md col-12">
                        <label for="end_date" class="form-label">
                            {{ __('grantmanagement::grantmanagement.end_date') }}
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="end_date" id="end_date"
                                class="form-control border-start-0 nepali-date"
                                placeholder="{{ __('grantmanagement::grantmanagement.end_date') }}">
                        </div>
                        @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md col-12">
                        <label for="selectedFiscalYear" class="form-label">
                            {{ __('grantmanagement::grantmanagement.fiscal_year') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <select wire:model="selectedFiscalYear" id="selectedFiscalYear" class="form-select"
                                multiple>
                                @foreach ($fiscalYear as $id => $year)
                                    <option value="{{ $id }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedWards')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="col-md col-12">
                        <label for="selctedGrantType" class="form-label">
                            {{ __('grantmanagement::grantmanagement.grant_type') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <select id="selctedGrantType" class="form-select" multiple>
                                @foreach ($grantType as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedHelpnessType')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row g-3 mt-2 align-items-center">

                    <div class="col-md col-12">
                        <label for="selectedBranchType" class="form-label">
                            {{ __('grantmanagement::grantmanagement.branch') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <select id="selectedBranchType" class="form-select" multiple>
                                @foreach ($branch as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedHelpnessType')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="col-md col-12">
                        <label for="selctedGrantGivingOrg" class="form-label">
                            {{ __('grantmanagement::grantmanagement.grant_giving_organization') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <select id="selctedGrantGivingOrg" class="form-select" multiple>
                                @foreach ($grantOffice as $id => $office_name)
                                    <option value="{{ $id }}">{{ $office_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedHelpnessType')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md col-12">
                        <label for="selectedFiscalYear" class="form-label">
                            {{ __('grantmanagement::grantmanagement.grant_delivered_type') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <select id="grant_delivered_type" class="form-select" multiple
                                wire:model="grant_delivered_type">
                                @foreach (\Src\GrantManagement\Enums\GrantEnum::cases() as $item)
                                    <option value="{{ $item->value }}">{{ $item->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedWards')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center gap-2">
                        <button wire:click="showRelativeData" class="btn btn-primary btn-sm">
                            <i class="bx bx-search me-1"></i> {{ __('grantmanagement::grantmanagement.search') }}
                        </button>
                        <button wire:click="clearRelativeData" class="btn btn-danger btn-sm">
                            <i class="bx bx-x-circle me-1"></i> {{ __('grantmanagement::grantmanagement.clear') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Table to show the relative data -->
        <div class="overflow-x-auto mx-auto">

            @if (!empty($filtered_datas))
                <div class=" mt-4">
                    <div class="card mx-auto shadow">
                        <table class=" min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 border">
                                        {{ __('grantmanagement::grantmanagement.fiscal_year') }}
                                    </th>
                                    <th class="py-2 px-4 border">
                                        {{ __('grantmanagement::grantmanagement.grant_office') }}
                                    </th>
                                    <th class="py-2 px-4 border">
                                        {{ __('grantmanagement::grantmanagement.program_name') }}
                                    </th>
                                    <th class="py-2 px-4 border">
                                        {{ __('grantmanagement::grantmanagement.grant_type') }}
                                    </th>
                                    <th class="py-2 px-4 border">{{ __('grantmanagement::grantmanagement.branch') }}
                                    </th>
                                    <th class="py-2 px-4 border">
                                        {{ __('grantmanagement::grantmanagement.grant_delivered_type') }}
                                    </th>
                                    <th class="py-2 px-4 border">{{ __('grantmanagement::grantmanagement.amount') }}
                                    </th>
                                    <th class="py-2 px-4 border">
                                        {{ __('grantmanagement::grantmanagement.services_grant') }}
                                    </th>
                                    <th class="py-2 px-4 border">

                                        {{ __('grantmanagement::grantmanagement.for_grant') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filtered_datas as $data)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border">{{ $data->fiscalYear->year }}</td>
                                        <td class="py-2 px-4 border">{{ $data->grantingOrganization?->office_name }}
                                        </td>
                                        <td class="py-2 px-4 border">{{ $data->program_name }}</td>
                                        <td class="py-2 px-4 border">{{ $data->grantType?->title }}</td>

                                        <td class="py-2 px-4 border">{{ $data->branch?->title }}</td>
                                        <td class="py-2 px-4 border">{{ $data->grant_provided_type }}</td>
                                        <td class="py-2 px-4 border">{{ $data->grant_amount }}</td>
                                        <td class="py-2 px-4 border">{{ $data->grant_provided }}</td>
                                        <td class="py-2 px-4 border">
                                            @if (is_array($data->for_grant))
                                                {{ implode(', ', $data->for_grant) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="container mt-4">
                    <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                        style="min-height: 200px;">
                        <h5 class="text-center">{{ __('grantmanagement::grantmanagement.no_data_to_show') }}</h5>

                        @error('startDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror

                        @error('endDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            @endif
        </div>

    </div>


    @push('scripts')
        <script>
            $('#selectedFiscalYear').select2().on('change', function(e) {
                @this.set('selectedFiscalYear', $(this).val());
            });

            $('#selctedGrantType').select2().on('change', function(e) {
                @this.set('selectedGrantType', $(this).val());
            });

            $('#selectedBranchType').select2().on('change', function(e) {
                @this.set('selectedBranchType', $(this).val());
            });

            $('#grant_delivered_type').select2().on('change', function(e) {
                @this.set('grant_delivered_type', $(this).val());
            });

            $('#selctedGrantGivingOrg').select2().on('change', function(e) {
                @this.set('selectedGrantGivingOrg', $(this).val());
            });

            window.addEventListener('toast:error', event => {
                alert(event.detail.message);
            });

            document.addEventListener('livewire:initialized', () => {
                Livewire.on('clear-select2', () => {
                    $('#selectedFiscalYear').val(null).trigger('change');
                    $('#selctedGrantType').val(null).trigger('change');
                    $('#selectedBranchType').val(null).trigger('change');
                    $('#grant_delivered_type').val(null).trigger('change');
                    $('#ward_id').val(null).trigger('change');
                    $('#selctedGrantGivingOrg').val(null).trigger('change');
                });
            });
        </script>
    @endpush

</div>
