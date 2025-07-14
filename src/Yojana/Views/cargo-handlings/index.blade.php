<x-layout.app header="CargoHandling List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">CargoHandling</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('cargo_handlings create')
                        <a href="{{ route('admin.cargo_handlings.create') }}" class="btn btn-info"><i
                                class="fa fa-plus"></i> Add CargoHandling</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:cargo_handlings.cargo_handling_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
