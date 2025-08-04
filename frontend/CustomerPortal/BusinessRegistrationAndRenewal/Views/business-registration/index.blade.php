<x-layout.customer-app header="Business registration">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
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
                        <h5 class="text-primary fw-bold">{{ __('Business Registration Lists') }}</h5>
                        <div>

                            <a href="{{ route('customer.business-registration.business-registration.create', ['type' => $type]) }}"
                                class="btn btn-info"><i class="bx bx-plus"></i>

                                {{ __('businessregistration::businessregistration.apply') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <livewire:business_registration.business_registration_table theme="bootstrap-4" :$type />
                </div>
            </div>
        </div>
    </div>
</x-layout.customer-app>
