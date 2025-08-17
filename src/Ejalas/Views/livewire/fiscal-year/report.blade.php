<div>
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ejalas::ejalas.fiscal_year') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ejalas::ejalas.list') }}</li>
        </ol>
    </nav>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">{{ __('ejalas::ejalas.fiscal_year_report') }}</h4>
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
                    <!-- Fiscal Year -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.fiscal_year') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedYear">
                                <option value="">{{ __('ejalas::ejalas.select_a_year') }}</option>
                                @foreach ($fiscalYears as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedYear')
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
        @if ($reportCollections && $reportCollections->count())
            <div class="container mt-4">
                <div class="card mx-auto shadow">
                    <table class="table table-border">
                        <thead>
                            <tr>
                                <th>{{ __('ejalas::ejalas.dispute_matter') }}</th>
                                <th>{{ __('ejalas::ejalas.total_complaints') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalCount = 0;
                            @endphp

                            @foreach ($reportCollections as $item)
                                @php
                                    $totalCount += $item->total;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td>{{ $item->disputeMatter->title ?? 'N/A' }}</td>
                                    <td>{{ $item->total }}</td>
                                </tr>
                            @endforeach

                            <!-- Total Row -->
                            <tr class="fw-bold bg-light">
                                <td>{{ __('ejalas::ejalas.total') }}</td>
                                <td>{{ $totalCount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="container mt-4">
                <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                    style="min-height: 200px;">
                    <h5 class="text-center">{{ __('ejalas::ejalas.no_data_to_show') }}</h5>

                    @error('selectedYear')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        @endif
    </div>
</div>
