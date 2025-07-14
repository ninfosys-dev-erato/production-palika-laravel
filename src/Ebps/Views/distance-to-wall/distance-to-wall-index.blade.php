<x-layout.app header="DistanceToWall List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">DistanceToWall</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('distance_to_walls create')
                        <a href="{{ route('admin.distance_to_walls.create') }}" class="btn btn-info"><i
                                class="bx bx-plus"></i> Add DistanceToWall</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:ebps.distance_to_wall_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
