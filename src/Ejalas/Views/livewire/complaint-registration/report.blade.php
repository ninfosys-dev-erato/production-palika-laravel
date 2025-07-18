<div>
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ejalas::ejalas.complaint_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ejalas::ejalas.list') }}</li>
        </ol>
    </nav>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">{{ __('ejalas::ejalas.complaint_registration_report') }}</h4>
        <div class="d-flex gap-2 ms-auto">
            <button type="button" wire:click="export" class="btn btn-outline-primary btn-sm">
                {{ __('Export') }}
            </button>
            <button wire:click='downloadPdf' class="btn btn-outline-primary btn-sm" target="_blank">
                {{ __('Pdf') }}
            </button>
        </div>
    </div>
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="divider divider-primary text-start text-primary fw-bold mx-4 mb-0">
                <div class="divider-text fs-4">{{ __('ejalas::ejalas.search') }}</div>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <!-- Start Date -->
                    <div class="col-md col-12">
                        <label for="startDate" class="form-label">{{ __('ejalas::ejalas.ejalashstartdate') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-time"></i></span>
                            <input type="text" class="form-control border-start-0 nepali-date " id="startDate"
                                wire:model="startDate" placeholder="{{ __('ejalas::ejalas.ejalashstartdate') }}">
                        </div>
                        @error('startDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div class="col-md col-12">
                        <label for="endDate" class="form-label">{{ __('ejalas::ejalas.ejalashenddate') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-time"></i></span>
                            <input type="text" class="form-control border-start-0 nepali-date" id="endDate"
                                wire:model="endDate" placeholder="{{ __('ejalas::ejalas.ejalashenddate') }}">
                        </div>
                        @error('endDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.status') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedStatus">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                <option value="pending">{{ __('ejalas::ejalas.pending') }}</option>
                                <option value="1">{{ __('ejalas::ejalas.registered') }}</option>
                                <option value="0">{{ __('ejalas::ejalas.rejected') }}</option>
                            </select>
                        </div>
                        @error('selectedStatus')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>

                    <!-- Dispute Matter -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.dispute_matter') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedDisputeMatter">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($disputeMatters as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedDisputeMatter')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>

                    <!-- Dispute Area -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.dispute_area') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedDisputeArea">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($disputeAreas as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedDisputeArea')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 align-items-center mt-3">
                    <!-- Ward -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.ward') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedWard">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($wards as $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedWard')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>

                    <!-- Reconciliation Center -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.reconciliation_center') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedReconciliationCenter">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($reconciliationCenters as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedReconciliationCenter')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center gap-2">
                        <button type="submit" class="btn btn-primary btn-sm" wire:click="searchReport"
                            wire:loading.attr="disabled" wire:target="searchReport">
                            <span wire:loading wire:target="searchReport"><i
                                    class="bx bx-loader bx-spin me-1"></i></span>
                            <span wire:loading.remove wire:target="searchReport"><i class="bx bx-search me-1"></i>
                                {{ __('ejalas::ejalas.search') }}</span>
                        </button>

                        <button type="button" class="btn btn-danger btn-sm" wire:click="clear">
                            <i class="bx bx-x-circle me-1"></i> {{ __('Clear') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="overflow-x-auto mx-auto">
        @if ($complaints && $complaints->count())
            <div class="container mt-4">
                <div class="card mx-auto shadow">
                    <table class="table table-border">
                        <thead>
                            <tr>
                                <th>दर्ता नं.</th>
                                <th>दर्ता मिति</th>
                                <th>निवेदक</th>
                                <th>विपक्षी</th>
                                <th>वार्ड</th>
                                <th>विवादको क्षेत्र</th>
                                <th>विवादको विषय</th>
                                <th>विवादको अवस्था</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complaints as $complaint)
                                <tr class="hover:bg-gray-50">
                                    <td>{{ $complaint->reg_no }}</td>
                                    <td>{{ $complaint->reg_date_bs }}</td>
                                    <td>{{ implode(', ', $complaint->complainers ?? []) }}</td>
                                    <td>{{ implode(', ', $complaint->defenders ?? []) }}</td>
                                    <td>{{ $complaint->ward_no }}</td>
                                    <td>{{ $complaint->disputeMatter?->disputeArea?->title ?? '' }}</td>
                                    <td>{{ $complaint->disputeMatter?->title ?? '' }}</td>
                                    <td>{{ is_null($complaint->status) ? 'निर्णय बाँकी' : ($complaint->status ? 'स्वीकृत' : 'अस्वीकृत') }}
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
                    <h5 class="text-center">{{ __('ejalas::ejalas.no_data_to_show') }}</h5>

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
@script
    {{-- <script>
        $(document).ready(function() {
            $('#startDate').nepaliDatePicker({
                dateFormat: '%y-%m-%d',
                closeOnDateSelect: true,
            }).on('dateSelect', function() {
                let nepaliDate = $(this).val();
                @this.set('startDate', nepaliDate);
            });
            $('#endDate').nepaliDatePicker({
                dateFormat: '%y-%m-%d',
                closeOnDateSelect: true,
            }).on('dateSelect', function() {
                let nepaliDate = $(this).val();
                @this.set('endDate', nepaliDate);
            });
        });
    </script> --}}
@endscript
