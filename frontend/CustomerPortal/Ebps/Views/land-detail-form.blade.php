<x-layout.customer-app header="{{ __('Customer Land Detai ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('customer.customer_land_detais.index') }}">{{ __('ebps::ebps.customer_land_detai') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($customerLandDetail))
                    {{ __('ebps::ebps.edit') }}
                @else
                    {{ __('ebps::ebps.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($customerLandDetail))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($customerLandDetail) ? __('ebps::ebps.create_customer_land_detail') : __('ebps::ebps.update_customer_land_detail') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('customer.ebps.land-detail-index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.customer_land_detail_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($customerLandDetail))
                    <livewire:customer_portal.ebps.customer_land_detail_form :$action :$customerLandDetail />
                @else
                    <livewire:customer_portal.ebps.customer_land_detail_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.customer-app>
