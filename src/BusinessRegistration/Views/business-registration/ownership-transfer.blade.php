<x-layout.app header="{{ __('businessregistration::businessregistration.business_registration') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('businessregistration::businessregistration.business_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('businessregistration::businessregistration.list') }}</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold mb-0">
                {{ __('businessregistration::businessregistration.registration_form') }}
            </h5>

            <a href="{{ route('admin.business-registration.business-registration.index', ['type' => 'registration']) }}"
                class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('businessregistration::businessregistration.business_registration_lists') }}</a>
        </div>
    </div>
    <livewire:business_registration.business_ownership_transfer :$businessRegistration />

</x-layout.app>
