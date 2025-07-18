<x-layout.customer-app header="{{ __('Customer Land Detai List') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.customer_land_detail') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('ebps::ebps.customer_land_detail_list') }}</h5>
                    </div>
                    <div>

                        <a href="{{ route('customer.ebps.land-detail-create') }}" class="btn btn-info"><i
                                class="bx bx-plus"></i> {{ __('ebps::ebps.add_land_detail') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:customer_portal.ebps.customer_land_detail_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.customer-app>
