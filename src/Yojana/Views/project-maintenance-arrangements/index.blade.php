<x-layout.app header="ProjectMaintenanceArrangement List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">ProjectMaintenanceArrangement</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('project_maintenance_arrangements create')
                        <a href="{{ route('admin.project_maintenance_arrangements.create') }}" class="btn btn-info"><i
                                class="fa fa-plus"></i> Add ProjectMaintenanceArrangement</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:project_maintenance_arrangements.project_maintenance_arrangement_table
                        theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
