<x-layout.app header="{{ __('businessregistration::businessregistration.businessrenewal_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('businessregistration::businessregistration.business_renewal') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('businessregistration::businessregistration.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="text-primary fw-bold">
                            {{ __('businessregistration::businessregistration.business_renewal') }}</h5>
                        {{-- <div>
                            @perm('business_renewals create')
                                <a href="{{ route('admin.business-registration.renewals.create', ['type' => $type]) }}"
                                    class="btn btn-info"><i class="bx bx-plus"></i>

                                    {{ __('businessregistration::businessregistration.add_business_renewal') }}</a>
                            @endperm
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <livewire:business_registration.business_renewal_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
