<x-layout.app header="File Record {{ ucfirst(strtolower($action->value)) }} Form">


    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('filetracking::filetracking.chalani') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($fileRecord))
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
                    @if (!isset($fileRecord))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($fileRecord) ? __('filetracking::filetracking.create_chalani') : __('filetracking::filetracking.update_chalani') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.chalani.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('filetracking::filetracking.chalani_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($fileRecord))
                    <livewire:file_tracking.chalani_form :$action :$fileRecord />
                @else
                    <livewire:file_tracking.chalani_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
