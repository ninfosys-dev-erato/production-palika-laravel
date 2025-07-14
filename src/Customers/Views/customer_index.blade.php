<x-layout.app header="Customer List">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('Customer') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('List') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('Customer List') }}</h5>
                    </div>
                    <div>
                        <a href="{{ route('admin.customer.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                            {{ __('Add Customer') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:customers.customer_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
