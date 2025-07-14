<x-layout.app header="FileRecordLog  {{ ucfirst(strtolower($action->value)) }} Form">


    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('filetracking::filetracking.file_record_log') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($fileRecordLog))
                    {{ __('filetracking::filetracking.create') }}
                @else
                    {{ __('filetracking::filetracking.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($fileRecordLog))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($fileRecordLog) ? __('filetracking::filetracking.create_filerecordlog') : __('filetracking::filetracking.update_filerecordlog') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.file_record_logs.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('filetracking::filetracking.filerecordlog_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($fileRecordLog))
                    <livewire:file_tracking.file_record_log_form :$action :$fileRecordLog />
                @else
                    <livewire:file_tracking.file_record_log_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
