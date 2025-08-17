<div>
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ejalas::ejalas.court_submission') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ejalas::ejalas.list') }}</li>
        </ol>
    </nav>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">{{ __('ejalas::ejalas.court_submission_report') }}</h4>
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
                            <input type="text" class="form-control border-start-0 nepali-date" id="startDate"
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
        @if ($courtSubmissions && $courtSubmissions->count())
            <div class="container mt-4">
                <div class="card mx-auto shadow">
                    <table class="table table-border">
                        <thead>
                            <tr>
                                <th>{{ __('ejalas::ejalas.registration_no') }}</th>
                                <th>{{ __('ejalas::ejalas.complainer') }}</th>
                                <th>{{ __('ejalas::ejalas.defender') }}</th>
                                <th>{{ __('ejalas::ejalas.dispute_matter') }}</th>
                                <th>{{ __('ejalas::ejalas.submission_date') }}</th>
                                <th>{{ __('ejalas::ejalas.court_name') }}</th>
                                <th>{{ __('ejalas::ejalas.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courtSubmissions as $submission)
                                <tr class="hover:bg-gray-50">
                                    <td>{{ $submission->complaintRegistration?->reg_no ?? '' }}</td>
                                    <td>{{ implode(', ', $submission->complainers ?? []) }}
                                    </td>
                                    <td>{{ implode(', ', $submission->defenders ?? []) }}</td>
                                    <td>{{ $submission->complaintRegistration?->disputeMatter?->title ?? '' }}</td>
                                    <td>{{ $submission->submission_date_bs ?? '' }}</td>
                                    <td>{{ $submission->court_name ?? '' }}</td>
                                    <td>{{ $submission->status ? __('ejalas::ejalas.submitted') : __('ejalas::ejalas.pending') }}
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
