<x-layout.app header="{{ __('Collateral List') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Collateral') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('List') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('Collateral List') }}</h5>
                    </div>
                    <div>
                        @perm('plan create')
                            <a href="{{ route('admin.collaterals.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('Add Collateral') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:yojana.collateral_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
