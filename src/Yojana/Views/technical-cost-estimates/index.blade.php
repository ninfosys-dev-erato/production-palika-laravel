<x-layout.app header="TechnicalCostEstimate List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">TechnicalCostEstimate</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('technical_cost_estimates create')
                        <a href="{{ route('admin.technical_cost_estimates.create') }}" class="btn btn-info"><i
                                class="fa fa-plus"></i> Add TechnicalCostEstimate</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:technical_cost_estimates.technical_cost_estimate_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
