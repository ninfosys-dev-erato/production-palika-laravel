<x-layout.app header="FileRecordNotifiee  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('filetracking::filetracking.filerecordnotifiee') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($fileRecordNotifiee))
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
                    @if (!isset($fileRecordNotifiee))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($fileRecordNotifiee) ? __('filetracking::filetracking.create_filerecordnotifiee') : __('filetracking::filetracking.update_filerecordnotifiee') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.file_record_notifiees.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('filetracking::filetracking.filerecordnotifiee_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($fileRecordNotifiee))
                    <livewire:file_tracking.file_record_notifiee_form :$action :$fileRecordNotifiee />
                @else
                    <livewire:file_tracking.file_record_notifiee_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
