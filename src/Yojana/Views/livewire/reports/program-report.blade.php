<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.program_report') }}</h4>
        <div class="d-flex gap-2 ms-auto">
{{--            <button type="button" wire:click = "export" class="btn btn-outline-primary btn-sm">--}}
{{--                {{ __('yojana::yojana.export') }}--}}
{{--            </button>--}}
            <button type="button" wire:click = "downloadPdf" class="btn btn-outline-primary btn-sm">
                {{ __('yojana::yojana.print') }}
            </button>
        </div>
    </div>
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="divider divider-primary text-start text-primary fw-bold mx-4 mb-0">
                <div class="divider-text fs-6">{{ __('yojana::yojana.search') }}</div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row g-3">
                        {{-- Date Fields --}}
                        <div class="col-md-6 col-12">
                            <label class="form-label">{{ __('yojana::yojana.start_date') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-0">
                                    <i class="bx bx-time"></i>
                                </span>
                                <input type="text" wire:model="startDate" id="start_date"
                                    class="form-control border-start-0 nepali-date"
                                    placeholder="{{ __('yojana::yojana.start_date') }}">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label">{{ __('yojana::yojana.end_date') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-0">
                                    <i class="bx bx-time"></i>
                                </span>
                                <input type="text" wire:model="endDate" id="end_date"
                                    class="form-control border-start-0 nepali-date"
                                    placeholder="{{ __('yojana::yojana.end_date') }}">
                            </div>
                        </div>

                        {{-- Dropdowns --}}
                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.implementation_method') }}</label>
                            <select class="form-select" wire:model="selectedImplementationMethod">
                                <option value="">{{ __('yojana::yojana.select') }}</option>
                                @foreach ($implementationMethods as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.implementation_level') }}</label>
                            <select class="form-select" wire:model="selectedImplementationLevel">
                                <option value="">{{ __('yojana::yojana.select') }}</option>
                                @foreach ($implementationLevels as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.sub_region') }}</label>
                            <select class="form-select" wire:model="selectedSubRegion">
                                <option value="">{{ __('yojana::yojana.select') }}</option>
                                @foreach ($subRegions as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.plan_area') }}</label>
                            <select class="form-select" wire:model="selectedPlanArea">
                                <option value="">{{ __('yojana::yojana.select') }}</option>
                                @foreach ($planAreas as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.target') }}</label>
                            <select class="form-select" wire:model="selectedTarget">
                                <option value="">{{ __('yojana::yojana.select') }}</option>
                                @foreach ($targets as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.plan_type') }}</label>
                            <select class="form-select" wire:model="selectedPlanType">
                                <option value="">{{ __('yojana::yojana.select') }}</option>
                                @foreach ($planTypes as $type)
                                    <option value="{{ $type->value }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.nature') }}</label>
                            <select class="form-select" wire:model="selectedNature">
                                <option value="">{{ __('yojana::yojana.select') }}</option>
                                @foreach ($natures as $nature)
                                    <option value="{{ $nature->value }}">{{ $nature->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.project_group') }}</label>
                            <select class="form-select" wire:model="selectedProjectGroup">
                                <option value="">{{ __('yojana::yojana.select') }}</option>
                                @foreach ($projectGroups as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.ward') }}</label>
                            <select class="form-select" wire:model="selectedWard">
                                <option value="">{{ __('yojana::yojana.select') }}</option>
                                @foreach ($wards as $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 d-flex justify-content-center gap-3 mt-4">
                            <button type="button" class="btn btn-primary btn-sm" wire:loading.attr="disabled"
                                wire:target="search" wire:click="search">
                                <span wire:loading wire:target="search">
                                    <i class="bx bx-loader bx-spin me-1"></i>
                                </span>
                                <span wire:loading.remove wire:target="search">
                                    <i class="bx bx-search me-1"></i> {{ __('yojana::yojana.search') }}
                                </span>
                            </button>

                            <button type="button" class="btn btn-danger btn-sm" wire:click="clear">
                                <i class="bx bx-x-circle me-1"></i> {{ __('yojana::yojana.clear') }}
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div>
        @if ($plans && $plans->count())
            <div class="container mt-4">
                <div class="card shadow table-responsive" id="printContent">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>सि.न.</th>
                                <th>कार्यक्रमको नाम</th>
                                <th>कार्यान्वयन विधि</th>
                                <th>स्थान</th>
                                <th>वडा</th>
                                <th>कार्यान्वयन तह</th>
                                <th>क्षेत्र</th>
                                <th>प्रकृति</th>
                                <th>उपक्षेत्र</th>
                                <th>लक्ष्य समूह</th>
                                <th>बिनियोजित बजेट</th>
                                <th>बाँकी बजेट</th>
                                <th>स्थिति</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plans as $index => $row)
                                <tr>
                                    <td>{{ replaceNumbers($index + 1, true) }}</td>
                                    <td>{{ $row->project_name ?? 'N/A' }}</td>
                                    <td>{{ $row->implementationMethod->title ?? 'N/A' }}</td>
                                    <td>{{ $row->location ?? 'N/A' }}</td>

                                    <td>{{ $row->ward->ward_name_ne ?? 'N/A' }}</td>
                                    <td>{{ $row->implementationLevel->title ?? 'N/A' }}</td>


                                    <td>{{ $row->planArea->area_name ?? 'N/A' }}</td>
                                    <td>{{ $row->nature->label() }}</td>
                                    <td>{{ $row->subRegion->name ?? 'N/A' }}</td>
                                    <td>{{ $row->target->title ?? 'N/A' }}</td>

                                    <td>{{ replaceNumbers($row->allocated_budget, true) ?? 'N/A' }}</td>
                                    <td>{{ replaceNumbers($row->remaining_budget, true) ?? 'N/A' }}</td>
                                    <td>
                                        {{ $row->status->label() }}
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
                    <h5 class="text-center">{{ __('yojana::yojana.no_data_to_show') }}</h5>

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
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-pdf-in-new-tab', (event) => {
                console.log(event);
                window.open(event.url, '_blank');
            });

        });
    </script>
@endpush
