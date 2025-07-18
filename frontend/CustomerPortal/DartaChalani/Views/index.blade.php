<x-layout.customer-app header="Business registration">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Business Registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('List') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="text-primary fw-bold">{{ __('Darta Chalani Lists') }}</h5>
                    </div>
                </div>

                <div class="card-body">
                    <livewire:customer_portal.darta_chalani.darta_chalani_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.customer-app>
