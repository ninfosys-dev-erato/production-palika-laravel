<x-layout.customer-app header="{{ __('grievance::grievance.grievance_details_form') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.complaint') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($customerGunaso))
                    {{ __('grievance::grievance.create') }}
                @else
                    {{ __('grievance::grievance.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        @if (!isset($customerGunaso))
                            <h5 class="text-primary fw-bold mb-0">
                                {{ !isset($customerGunaso) ? __('grievance::grievance.create_grievance') : __('grievance::grievance.update_grievance') }}
                            </h5>
                        @endif


                        <div>
                            <a href="{{ route('customer.grievance.index') }}" class="btn btn-info">
                                <i class="bx bx-list-ol"></i>{{ __('grievance::grievance.grievance_list') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (isset($customerGunaso))
                            <livewire:customer.gunaso.gunaso-form :$action :$customerGunaso />
                        @else
                            <livewire:customer_portal.grievance.gunaso_form :$action :admin="false" />
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout.customer-app>
