<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.report_according_to_allocated_budget') }}</h4>
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
                            <label class="form-label">{{ __('yojana::yojana.min_amount') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-0">
                                    <i class="bx bx-time"></i>
                                </span>
                                <input type="number" wire:model="minAmount" id="minAmount" min="0"
                                       class="form-control border-start-0" placeholder="{{ __('yojana::yojana.min_amount') }}">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label">{{ __('yojana::yojana.max_amount') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-0">
                                    <i class="bx bx-time"></i>
                                </span>
                                <input type="number" wire:model="maxAmount" id="maxAmount" min="0"
                                       class="form-control border-start-0" placeholder="{{ __('yojana::yojana.max_amount') }}">
                            </div>
                        </div>

                        {{-- Dropdowns --}}
                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.type') }}</label>
                            <select class="form-select" wire:model="type">
                                <option value="">{{ __('yojana::yojana.select') }}</option>
                                <option value="plan">{{ __('Plan') }}</option>
                                <option value="program">{{ __('Program') }}</option>
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.ward') }}</label>
                            <select class="form-select" wire:model="selectedWard">
                                <option value="">{{ __('yojana::yojana.all') }}</option>
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
                            <th>योजना नाम</th>
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
                                    {{$row->status->label()}}
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
