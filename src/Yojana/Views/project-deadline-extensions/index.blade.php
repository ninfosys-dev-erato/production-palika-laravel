<x-layout.app header="ProjectDeadlineExtension List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">ProjectDeadlineExtension</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('project_deadline_extensions create')
                        <a href="{{ route('admin.project_deadline_extensions.create') }}" class="btn btn-info"><i
                                class="fa fa-plus"></i> Add ProjectDeadlineExtension</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:project_deadline_extensions.project_deadline_extension_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
