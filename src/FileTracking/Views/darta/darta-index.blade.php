<x-layout.app header="{{ __('filetracking::filetracking.filerecord_list') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('filetracking::filetracking.file_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('filetracking::filetracking.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('filetracking::filetracking.registered_files') }}
                    </h5>
                    @perm('darta create')
                        <div>
                            <a href="{{ route('admin.register_files.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i>
                                {{ __('filetracking::filetracking.register_files') }}</a>

                        </div>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:file_tracking.darta_table theme="bootstrap-5" />
                </div>
            </div>

        </div>
    </div>
</x-layout.app>
