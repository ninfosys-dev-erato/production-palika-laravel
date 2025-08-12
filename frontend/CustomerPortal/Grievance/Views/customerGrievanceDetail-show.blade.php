@php
    function getTextColor($status)
    {
        switch (strtolower($status)) {
            case 'closed':
                return ' text-success';
            case 'replied':
                return ' text-primary';
            case 'investigating':
                return ' text-primary';
            case 'unseen':
                return ' text-warning';
            case 'medium':
                return ' text-warning';
            case 'high':
                return ' text-danger';
            case 'low':
                return ' text-primary';
            default:
                return ' text-dark';
        }
    }
@endphp

<x-layout.customer-app header="grievance::grievance.grievance_detail">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.grievance_detail') }}</a>
            </li>
        </ol>
    </nav>
    <div class="col-md-12">
        <div class="">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-primary fw-bold mb-0">{{ __('grievance::grievance.grievance_details') }}</h5>
                <a href="{{ route('customer.grievance.index') }}" class="btn btn-info"><i
                        class="bx bx-list-ul"></i>{{ __('grievance::grievance.grievance_detail_list') }}</a>
            </div>
            <div class="col-12">
                <div class="card mb-5 shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h4 class="mb-4 text-primary fw-bold">{{ __('grievance::grievance.token') }}: {{ $grievanceDetail->token }}
                        </h4>
                        <div class="row gy-3">

                            <div class="col-md-4 col-12">
                                <i
                                    class="bx {{ $grievanceDetail->is_public ? 'bx-check-circle text-success' : 'bx-x-circle text-danger' }} me-2"></i>
                                    <span class="fw-medium">{{ __('grievance::grievance.is_public') }}:</span>
                                    <span>{{ $grievanceDetail->is_public ? __('grievance::grievance.yes') : __('grievance::grievance.no') }}</span>
                            </div>

                            <div class="col-md-4 col-12">
                                <i class="bx bx-calendar-check text-secondary me-2"></i>
                                <span class="fw-medium">{{ __('grievance::grievance.status') }}:</span>
                                <span class="{{ getTextColor($grievanceDetail->status->value) }}">
                                    {{ strtoupper($grievanceDetail->status->value) }}
                                </span>
                            </div>
                            @if ($grievanceDetail->approved_at)
                                <div class="col-md-4 col-12">
                                    <i class="bx bx-calendar text-secondary me-2"></i>
                                    <span class="fw-medium">{{ __('grievance::grievance.approved_date') }}:</span>
                                    <span>{{ $grievanceDetail->approved_at }}</span>
                                </div>
                            @endif
                            <!-- Priority -->
                            <div class="col-md-4 col-12">
                                <i class="bx bx-flag text-secondary me-2"></i>
                                <span class="fw-medium">{{ __('grievance::grievance.priority') }}:</span>
                                <span class="{{ getTextColor($grievanceDetail->priority->value) }} fw-bold">
                                    {{ strtoupper($grievanceDetail->priority->value) }}
                                </span>
                            </div>

                            <div class="col col-12">
                                <i class="bx bx-category text-secondary me-2"></i>
                                <span class="fw-medium">{{ __('grievance::grievance.grievance_type') }}:</span>
                                <span>{{ $grievanceDetail->grievanceType->title }}</span>
                            </div>

                            <br>
                            <div class="col col-12">
                                <i class="bx bx-building text-secondary me-2"></i>
                                <span class="fw-medium">{{ __('grievance::grievance.branch') }}:</span>
                                @foreach ($branchTitles as $branchTitle)
                                    <span class="text-primary">{{ $branchTitle }} ||</span>
                                @endforeach
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-grievance-detail" aria-controls="navs-pills-grievance-detail"
                            aria-selected="false">
                            {{ __('grievance::grievance.grievance_detail') }}
                        </button>
                    </li>


                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-logs" aria-controls="navs-pills-logs" aria-selected="false">
                            {{ __('grievance::grievance.grievance_logs') }}
                        </button>
                    </li>

                </ul>

            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-pills-grievance-detail" role="tabpanel">
                            <div class="col-md-12">
                                <p class="mb-3">
                                    <strong class="text-dark">{{ __('grievance::grievance.subject') }}:</strong>
                                    <span class="text-muted">{{ $grievanceDetail->subject }}</span>
                                </p>

                                <div class="mb-4">
                                    <strong class="text-dark">{{ __('grievance::grievance.descriptions') }}:</strong>
                                    <div class="p-3 rounded shadow-sm"
                                        style="background-color: #f9f9f9; border: 1px solid #e0e0e0;">
                                        <p class="text-muted mb-0">{{ $grievanceDetail->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="card-body border shadow-lg bg-light flex-fill"
                                        style="border-radius: 10px;">
                                        <h5 class="text">{{ __('grievance::grievance.supporting_documents') }}</h5>
                                        <div class="row">
                                            @if ($grievanceDetail->files->isNotEmpty())
                                                @foreach ($grievanceDetail->files as $file)
                                                    @if (is_array($file->file_name))
                                                        @foreach ($file->file_name as $index => $fileName)
                                                            <div class="col-md-3 mb-3">
                                                                <div class="card border shadow-sm"
                                                                    style="border-radius: 8px; cursor: pointer;">
                                                                    <div class="card-body text-center p-2">
                                                                        @php
                                                                            $fileExtension = pathinfo(
                                                                                $fileName,
                                                                                PATHINFO_EXTENSION,
                                                                            );
                                                                            $disk = $grievanceDetail->is_public
                                                                                ? 'public'
                                                                                : 'private';
                                                                            
                                                                            
                                                                                $fileUrl = customFileAsset(
                                                                                    config('src.Grievance.grievance.path'),
                                                                                    $fileName,
                                                                                    $disk,
                                                                                    'tempUrl'
                                                                                );
                                                                            
                                                                        @endphp

                                                                        <div style="display: flex; gap: 5px;">

                                                                           
                                                                                <a href="{{ $fileUrl }}"
                                                                                    target="_blank"
                                                                                    style="display: inline-flex; align-items: center;">
                                                                                    <i class='bx bx-file'
                                                                                        style="font-size: 24px; color: #007bff; margin-right: 8px;"></i>
                                                                                </a>

                                                                            <p class="text-muted mb-0 small">
                                                                                {{ __('grievance::grievance.document') }}
                                                                                {{ $index + 1 }}:
                                                                                {{ strtoupper($fileExtension) }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="col-md-3 mb-3">
                                                            <div class="card border shadow-sm"
                                                                style="border-radius: 8px;">
                                                                <div class="card-body text-center p-2">
                                                                    @php
                                                                        $fileExtension = pathinfo(
                                                                            $file->file_name,
                                                                            PATHINFO_EXTENSION,
                                                                        );
                                                                        $disk = $grievanceDetail->is_public
                                                                            ? 'public'
                                                                            : 'private';
                                                                        
                                                                        $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                                                                        
                                                                        if ($isImage) {
                                                                            $fileUrl = customFileAsset(
                                                                                config('src.Grievance.grievance.path'),
                                                                                $file->file_name,
                                                                                $disk,
                                                                                'tempUrl'
                                                                            );
                                                                        } else {
                                                                            $fileUrl = customFileAsset(
                                                                                config('src.Grievance.grievance.path'),
                                                                                $file->file_name,
                                                                                $disk,
                                                                                'tempUrl'
                                                                            );
                                                                        }
                                                                    @endphp

                                                                    @if ($isImage)
                                                                        <a href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#imageModal"
                                                                            onclick="showImage('{{ $fileUrl }}')">
                                                                            <img src="{{ $fileUrl }}"
                                                                                alt="Document Image" class="img-fluid"
                                                                                style="height: 100px; width: 100%; object-fit: cover; border-radius: 4px;" />
                                                                        </a>
                                                                    @elseif (strtolower($fileExtension) === 'pdf')
                                                                        <a href="{{ $fileUrl }}"
                                                                            target="_blank">
                                                                            <img src="{{ asset('images/pdf-icon.png') }}"
                                                                                alt="PDF Document Icon"
                                                                                class="img-fluid"
                                                                                style="height: 120px; width: 100%; object-fit: cover; border-radius: 4px;" />
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ $fileUrl }}"
                                                                            target="_blank">
                                                                            <img src="{{ asset('images/file-icon.png') }}"
                                                                                alt="Document Icon"
                                                                                class="img-fluid"
                                                                                style="height: 120px; width: 100%; object-fit: cover; border-radius: 4px;" />
                                                                        </a>
                                                                    @endif
                                                                    <p class="text-muted mt-2 mb-0 small">
                                                                        {{ __('grievance::grievance.document') }}:{{ $fileExtension }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <div class="col-md-12">
                                                    <p class="text-center">
                                                        {{ __('grievance::grievance.no_supporting_document_provided') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">
                                                {{ __('grievance::grievance.document_image') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body d-flex justify-content-center align-items-center">
                                            <img id="modalImage" src="" alt="Full-size Document"
                                                class="img-fluid" style="max-width: 90%; max-height: 90%;" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function showImage(src) {
                                    document.getElementById('modalImage').src = src;
                                }
                            </script>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-logs" role="tabpanel">
                            <div class="col-md-12">
                                <livewire:grievance.grievance_detail_assign_history_form :$grievanceDetail />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.customer-app>
