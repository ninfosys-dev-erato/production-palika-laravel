<x-layout.app header="CantileverDetail List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">CantileverDetail</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('cantilever_details create')
                        <a href="{{ route('admin.cantilever_details.create') }}" class="btn btn-info"><i
                                class="bx bx-plus"></i> Add CantileverDetail</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:ebps.cantilever_detail_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
