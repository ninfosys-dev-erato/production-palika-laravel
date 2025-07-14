<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.plan_report_according_to_organization') }}</h4>
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
            <div class="divider divider-primary text-start fw-bold text-primary mx-4 mb-0">
                <div class="divider-text fs-6">{{ __('yojana::yojana.search') }}</div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row g-3">


                        {{-- Dropdowns --}}
                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.organization') }}</label>
                            <select class="form-select" wire:model="selectedOrganization">
                                <option value="">{{ __('yojana::yojana.all') }}</option>
                                @foreach ($organizations as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('selectedOrganization')
                                <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
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
        @if ($query && $query->count())
            <div class="container mt-4">
                <div class="card shadow table-responsive" id="printContent">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th colspan="3" class="text-center">संस्था</th>
                            <th colspan="4" class="text-center">संस्था प्रतिनिधि</th>
                        </tr>
                        <tr>
                            <th>सि.न.</th>
                            <th>संस्थाको नाम</th>
                            <th>कार्यान्वयन विधि</th>
                            <th>योजनाको नाम</th>
                            <th>नाम</th>
                            <th>पद</th>
                            <th>ठेगाना</th>
                            <th>सम्पर्क नं.</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($query as $index=>$row)
                            <tr>
                                <td>{{ replaceNumbers($index+1, true) }}</td>
                                <td>{{ $row->implementationAgency->organization->name ?? 'N/A' }}</td>
                                <td>{{ $row->implementationMethod->model->label() ?? 'N/A' }}</td>
                                <td>{{ $row->project_name ?? 'N/A' }}</td>
                                <td>{{ $row->implementationAgency->organization->representative ?? 'N/A' }}</td>
                                <td>{{ $row->implementationAgency->organization->post ?? 'N/A' }}</td>
                                <td>{{ $row->implementationAgency->organization->address ?? 'N/A' }}</td>
                                <td>{{ replaceNumbers($row->implementationAgency->organization->mobile_number, true) ?? 'N/A' }}</td>
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
