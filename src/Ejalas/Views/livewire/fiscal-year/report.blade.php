<div>
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ejalas::ejalas.fiscal_year') }}</a>
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
                            <label for="fiscalYear" class="form-label"> {{ __('ejalas::ejalas.fiscal_year') }} </label>
                            <select name="" id="" class="form-select" wire:model="selectedYear">
                                <option value="" hidden>{{ __('ejalas::ejalas.select_a_year') }}</option>
                                @foreach ($fiscalYears as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Button -->
                        <button class="btn btn-primary mt-4" wire:click="searchReport"> {{ __('ejalas::ejalas.search') }} </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-center">
                        <table class="table table-bordered w-75 mt-4">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-start"> {{ __('ejalas::ejalas.dispute_matter') }} </th>
                                    <th class="text-start"> {{ __('ejalas::ejalas.total_complaints') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalCount = 0;
                                @endphp

                                @if ($reportCollections && count($reportCollections))
                                    @foreach ($reportCollections as $item)
                                        @php
                                            $totalCount += $item->total;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->disputeMatter->title ?? 'N/A' }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach

                                    <!-- Total Row -->
                                    <tr class="fw-bold bg-light">
                                        <td>{{ __('ejalas::ejalas.total') }}</td>
                                        <td>{{ $totalCount }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No data found for the selected
                                            criteria.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@script
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
@endscript
