<x-layout.app header="ProjectInstallmentDetail List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">ProjectInstallmentDetail</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('plan create')
                        <a href="{{ route('admin.project_installment_details.create') }}" class="btn btn-info"><i
                                class="fa fa-plus"></i> Add ProjectInstallmentDetail</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:project_installment_details.project_installment_detail_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
