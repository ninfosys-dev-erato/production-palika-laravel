<x-layout.app header="StructureType List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">StructureType</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('ebps_settings create')
                        <a href="{{ route('admin.structure_types.create') }}" class="btn btn-info"><i
                                class="bx bx-plus"></i> Add StructureType</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:ebps.structure_type_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
