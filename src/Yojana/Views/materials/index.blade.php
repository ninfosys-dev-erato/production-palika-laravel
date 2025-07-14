<x-layout.app header="Material List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">Material</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('materials create')
                        <a href="{{ route('admin.materials.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> Add
                            Material</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:materials.material_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
