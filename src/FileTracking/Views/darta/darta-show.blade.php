<x-layout.app>
    <div class="container py-5">
        <!-- Navigation buttons at the top -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i> {{ __('filetracking::filetracking.back_to_list') }}
            </a>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.register_files.edit', ['id' => $record->id]) }}"
                    class="btn btn-primary px-4 py-2 d-flex align-items-center">
                    <i class="bi bi-pencil-square me-2"></i> {{ __('filetracking::filetracking.edit_record') }}
                </a>

                @if (can('darta_delete'))
                    <button type="button"
                        onclick="return confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()"
                        wire:click="delete({{ $record->id }})"
                        class="btn btn-danger px-4 py-2 d-flex align-items-center">
                        <i class="bi bi-trash me-2" title="Delete"></i>
                        {{ __('filetracking::filetracking.delete_record') }}
                    </button>
                @endif
            </div>
        </div>

        <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
            <!-- Header with gradient background -->
            <div class="card-header py-3" style="border-bottom: 3px solid rgba(0,0,0,0.1);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-file-earmark-text fs-3 me-2"></i>
                    <h4 class="mb-0 fw-bold">{{ __('filetracking::filetracking.file_record_details') }}</h4>
                </div>
            </div>

            <!-- Card body with improved spacing -->
            <div class="card-body p-4 bg-light">
                <div class="row g-4">
                    <!-- Registration Number -->
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-hash text-primary me-2"></i>
                                <h6 class="fw-bold mb-0">{{ __('filetracking::filetracking.registration_number') }}</h6>
                            </div>
                            <p class="mb-0 fs-5">#{{ $record->reg_no ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-card-heading text-primary me-2"></i>
                                <h6 class="fw-bold mb-0">{{ __('filetracking::filetracking.title') }}</h6>
                            </div>
                            <p class="mb-0 fs-5">{{ $record->title ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Applicant Name -->
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-person text-primary me-2"></i>
                                <h6 class="fw-bold mb-0">{{ __('filetracking::filetracking.applicant_name') }}</h6>
                            </div>
                            <p class="mb-0 fs-5">{{ $record->applicant_name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Mobile Number -->
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-telephone text-primary me-2"></i>
                                <h6 class="fw-bold mb-0">{{ __('filetracking::filetracking.mobile_number') }}</h6>
                            </div>
                            <p class="mb-0 fs-5">{{ $record->applicant_mobile_no ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                <h6 class="fw-bold mb-0">{{ __('filetracking::filetracking.address') }}</h6>
                            </div>
                            <p class="mb-0 fs-5">{{ $record->applicant_address ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Document Level -->
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-layers text-primary me-2"></i>
                                <h6 class="fw-bold mb-0">{{ __('filetracking::filetracking.document_level') }}</h6>
                            </div>
                            <p class="mb-0 fs-5">{{ ucfirst($record->document_level ?? 'N/A') }}</p>
                        </div>
                    </div>

                    <!-- Ward -->
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-building text-primary me-2"></i>
                                <h6 class="fw-bold mb-0">{{ __('filetracking::filetracking.ward') }}</h6>
                            </div>
                            <p class="mb-0 fs-5">{{ $record->ward ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Departments -->
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-diagram-3 text-primary me-2"></i>
                                <h6 class="fw-bold mb-0">{{ __('filetracking::filetracking.departments') }}</h6>
                            </div>
                            <p class="mb-0 fs-5">
                                @if (!empty($record->departments()))
                                    {{ $record->departments()->pluck('title')->implode(', ') }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Created At -->
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-calendar-date text-primary me-2"></i>
                                <h6 class="fw-bold mb-0">{{ __('filetracking::filetracking.created_at') }}</h6>
                            </div>
                            <p class="mb-0 fs-5">{{ \Carbon\Carbon::parse($record->created_at)->format('Y-m-d H:i') }}
                            </p>
                        </div>
                    </div>

                    @if (!empty($record->file))
                        <div class="col-12">
                            <div class="p-3 bg-white rounded-3 shadow-sm">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-info-circle text-primary me-2"></i>
                                    <h6 class="fw-bold mb-0">
                                        {{ __('filetracking::filetracking.additional_information') }}
                                    </h6>
                                </div>

                                @php
                                    // Decode JSON string to array if needed
                                    $files = is_string($record->file)
                                        ? json_decode($record->file, true)
                                        : $record->file;

                                @endphp


                                @if (!empty($files) && is_array($files))
                                    <div class="row">
                                        @foreach ($files as $file)
                                            @php
                                                $fileUrl = customFileAsset(
                                                    config('src.FileTracking.fileTracking.file'),
                                                    $file,
                                                    'local',
                                                    'tempUrl',
                                                );
                                            @endphp

                                            <div class="col-auto mb-2">
                                                <a href="{{ $fileUrl }}" target="_blank"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bx bx-file"></i>
                                                    {{ __('yojana::yojana.view_uploaded_file') }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">{{ __('No file(s) found.') }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
