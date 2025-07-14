<form wire:submit.prevent="search">
    <div
        class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <h4 class="text-primary mb-2 mb-md-0">{{ __('ebps::ebps.ebps_token') }}</h4>
        <div class="d-flex gap-2 ms-md-auto">
            <button type="button" wire:click="export" class="btn btn-outline-primary btn-sm">
                {{ __('ebps::ebps.export') }}
            </button>
            <button type="button" wire:click="downloadPdf" class="btn btn-outline-primary btn-sm" target="_blank">
                {{ __('ebps::ebps.pdf') }}
            </button>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="divider divider-primary text-start text-primary fw-bold mx-3 mb-0">
                <div class="divider-text fs-4">{{ __('ebps::ebps.search') }}</div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('ebps::ebps.start_date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-time"></i></span>
                            <input type="text" wire:model="startDate" id="start_date"
                                class="form-control border-start-0 nepali-date"
                                placeholder="{{ __('ebps::ebps.enter_start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('ebps::ebps.end_date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-time"></i></span>
                            <input type="text" wire:model="endDate" id="end_date"
                                class="form-control border-start-0 nepali-date"
                                placeholder="{{ __('ebps::ebps.enter_end_date') }}">
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('ebps::ebps.application_type') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select wire:model="selectedApplicationType" class="form-select">
                                <option value="" hidden>{{ __('ebps::ebps.select_application_type') }}</option>
                                @foreach ($applicationTypes as $type)
                                    <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('ebps::ebps.usage') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select wire:model="selectedUsage" class="form-select">
                                <option value="" hidden>{{ __('ebps::ebps.select_usage') }}</option>
                                @foreach ($usageOptions as $type)
                                    <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('ebps::ebps.building_structure') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select wire:model="selectedBuildingStructure" class="form-select">
                                <option value="" hidden>{{ __('ebps::ebps.select_building_structure') }}</option>
                                @foreach ($buildingStructures as $type)
                                    <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6" wire:ignore>
                        <label class="form-label">{{ __('ebps::ebps.ward') }}</label>
                        <div class="input-group">
                            <select wire:model="selectedWard" id="selectedWard" class="form-select" multiple>
                                @foreach ($wards as $id => $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bx bx-search me-1"></i> {{ __('ebps::ebps.search') }}
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" wire:click="clear">
                            <i class="bx bx-x-circle me-1"></i> {{ __('ebps::ebps.clear') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        @if ($mapApplyData && $mapApplyData->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>S.N</th>
                            <th>Submission No</th>
                            <th>Fiscal Year</th>
                            @if ($selectedApplicationType != \Src\Ebps\Enums\ApplicationTypeEnum::BUILDING_DOCUMENTATION->value)
                                <th>Usage</th>
                                <th>Construction Type</th>
                            @endif
                            @if ($selectedApplicationType == \Src\Ebps\Enums\ApplicationTypeEnum::OLD_APPLICATIONS->value)
                                <th>Registration No</th>
                                <th>Registration Date</th>
                            @endif
                            <th>Applicant Name</th>
                            <th>Mobile No</th>
                            <th>Address</th>
                            <th>Application Type</th>
                            <th>Application Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapApplyData as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $data->submission_id }}</td>
                                <td>{{ $data->fiscalYear->year }}</td>
                                @if ($data->application_type != \Src\Ebps\Enums\ApplicationTypeEnum::BUILDING_DOCUMENTATION->value)
                                    <td>
                                        {{ \Src\Ebps\Enums\PurposeOfConstructionEnum::tryFrom($data->usage)?->label() ?? '-' }}
                                    </td>

                                    <td>{{ $data->constructionType->title }}</td>
                                @endif
                                @if ($data->application_type == \Src\Ebps\Enums\ApplicationTypeEnum::OLD_APPLICATIONS->value)
                                    <td>{{ $data->registration_no }}</td>
                                    <td>{{ $data->registration_date }}</td>
                                @endif
                                <td>{{ $data->full_name }}</td>
                                <td>{{ $data->mobile_no }}</td>
                                <td>{{ "{$data->localBody?->title}-{$data->ward_no}" }}</td>
                                <td>{{ \Src\Ebps\Enums\ApplicationTypeEnum::from($data->application_type)->label() }}
                                </td>
                                <td>{{ $data->applied_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card text-center p-4 shadow-sm">
                <h5>{{ __('ebps::ebps.no_data_to_show') }}</h5>
                @error('startDate')
                    <small class="text-danger">{{ __($message) }}</small>
                @enderror
                @error('endDate')
                    <small class="text-danger">{{ __($message) }}</small>
                @enderror
            </div>
        @endif
    </div>
</form>
@script
    <script>
        $('#selectedWard').select2().on('change', function(e) {
            @this.set('selectedWard', $(this).val());
        });
    </script>
@endscript

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-pdf', (event) => {
                console.log(event);
                window.open(event.url, '_blank');
            });

        });
    </script>
@endpush
