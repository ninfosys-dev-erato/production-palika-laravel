<div>
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ejalas::ejalas.complaint_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ejalas::ejalas.list') }}</li>
        </ol>
    </nav>
    <div class="row g-3 mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary mt-2 me-2" wire:click="downloadPdf">Print</button>"
                </div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex w-100 align-items-center">
                        <!-- Start Date Input -->
                        <div class="me-3">
                            <label for="startDate" class="form-label"> {{ __('ejalas::ejalas.ejalashstartdate') }}
                            </label>
                            <input type="text" class="form-control nepali-date" id="startDate" wire:model="startDate"
                                required />
                            <div>
                                @error('startDate')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- End Date Input -->
                        <div class="me-3">
                            <label for="endDate" class="form-label"> {{ __('ejalas::ejalas.ejalashenddate') }} </label>
                            <input type="text" class="form-control nepali-date" id="endDate" wire:model="endDate"
                                required />
                            <div>
                                @error('endDate')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Search Button -->
                        <button class="btn btn-primary mt-4" wire:click="searchReport">
                            {{ __('ejalas::ejalas.search') }} </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <livewire:ejalas.case_record_table theme="bootstrap-4" :report="true" />
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @script
    <script>
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
    </script>
@endscript --}}
