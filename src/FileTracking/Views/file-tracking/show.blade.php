@php
    switch ($fileRecord->subject_type) {
        case 'Src\Grievance\Models\GrievanceDetail':
            $route = route('admin.grievance.grievanceDetail.show', $fileRecord->subject_id);
            break;

        case 'Src\Recommendation\Models\ApplyRecommendation':
            $route = route('admin.recommendations.apply-recommendation.show', $fileRecord->subject_id);
            break;

        case 'Src\BusinessRegistration\Models\BusinessRegistration':
            $route = route('admin.business-registration.business-registration.show', $fileRecord->subject_id);
            break;
        case 'Src\FileTracking\Models\FileRecord':
            $route = route('admin.file_records.show', $fileRecord->subject_id);
            break;
    }
@endphp
<x-layout.app header="File Record">
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-center text-primary flex-grow-1 text-center mb-0">{{ __('filetracking::filetracking.file_record_details') }}</h3>
            <a href="javascript:history.back()" class="btn btn-info ms-3">
                <i class="bx bx-arrow-back"></i> {{ __('filetracking::filetracking.back') }}
            </a>
        </div>
        <div class="card shadow-sm mb-5">
            <div class="card-header d-flex justify-content-between align-items-center bg-light text-primary">
                <h5 class="mb-0">{{ __('filetracking::filetracking.general_information') }}</h5>
                <a href="{{ $route }}" class="btn btn-primary btn-sm">
                    {{ __('filetracking::filetracking.view_detail') }}
                </a>
            </div>
            <div class="card-body">
                <p>
                    <i class="bx bx-file-text text-primary"></i>
                    <strong>{{ __('filetracking::filetracking.title') }}:</strong> {{ $fileRecord->title ?? 'N/A' }}
                </p>
                <p>
                    <i class="bx bx-user text-primary"></i>
                    <strong>{{ __('filetracking::filetracking.applicant_name') }}:</strong> {{ $fileRecord->applicant_name ?? 'N/A' }}
                </p>
                <p>
                    <i class="bx bx-phone text-primary"></i>
                    <strong>{{ __('filetracking::filetracking.mobile_number') }}:</strong>
                    <a href="tel:{{ $fileRecord->applicant_mobile_no }}">{{ $fileRecord->applicant_mobile_no ?? 'N/A' }}
                    </a> <br>
                </p>
                <p>
                    <i class="bx bx-barcode text-primary"></i>
                    <strong>{{ __('filetracking::filetracking.subject') }}:</strong> {{ class_basename($fileRecord->subject_type) ?? 'N/A' }}
                </p>
                <p>
                    <i class="bx bx-map text-primary"></i>
                    <strong>{{ __('filetracking::filetracking.ward') }}:</strong> {{ $fileRecord->ward ?? 'N/A' }}
                </p>
                <p>
                    <i class="bx bx-clipboard text-primary"></i>
                    <strong>{{ __('filetracking::filetracking.document_level') }}:</strong> {{ ucfirst($fileRecord->document_level ?? 'N/A') }}
                </p>
            </div>
        </div>
        <h4 class="text-primary mb-4">{{ __('filetracking::filetracking.file_record_logs') }}</h4>
        @forelse($fileRecordLog as $log)
            <div class="card shadow-sm mb-4">
                <div class="card-header text-primary">
                    <h6 class="mb-0">{{ __('filetracking::filetracking.log') }} #{{ $loop->iteration }}</h6>
                </div>
                <div class="card-body">
                    <p><i class="bx bx-info-circle text-secondary"></i> <strong>{{ __('filetracking::filetracking.status') }}:</strong> <span
                            class="badge bg-info text-dark">{{ $log->status }}</span></p>
                    <p><i class="bx bx-notepad text-secondary"></i> <strong>{{ __('filetracking::filetracking.notes') }}:</strong>
                        {{ $log->notes }}</p>
                    <p><i class="bx bx-time text-secondary"></i> <strong>{{ __('filetracking::filetracking.logged_at') }}:</strong>
                        {{ $log->created_at->format('d M Y, h:i A') }} by {{ $log->handler->name }} </p>
                </div>
            </div>
        @empty
            <div class="alert alert-warning" role="alert">
                {{ __('filetracking::filetracking.no_logs_available_for_this_file_record') }}
            </div>
        @endforelse
    </div>
</x-layout.app>
