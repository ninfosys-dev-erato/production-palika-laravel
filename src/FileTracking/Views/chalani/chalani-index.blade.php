<x-layout.app header="{{ __('filetracking::filetracking.filerecord_list') }}">


    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('filetracking::filetracking.chalani') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('filetracking::filetracking.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('filetracking::filetracking.chalani') }}
                    </h5>
                    @perm('chalani_create')
                        <div>
                            <a href="{{ route('admin.chalani.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('filetracking::filetracking.add_chalani') }}</a>

                        </div>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:file_tracking.chalani_table theme="bootstrap-5" />
                </div>
            </div>

        </div>
    </div>
</x-layout.app>
