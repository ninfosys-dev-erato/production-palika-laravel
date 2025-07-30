<x-layout.app header="Business Registration Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('businessregistration::businessregistration.business_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($registrationType))
                    {{ __('businessregistration::businessregistration.create') }}
                @else
                    {{ __('businessregistration::businessregistration.edit') }}
                @endif
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold mb-0">
                {{ __('businessregistration::businessregistration.business_renewal_form') }}
            </h5>
            <a href="{{ route('admin.business-registration.business-registration.index') }}" class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('businessregistration::businessregistration.business_renewal_lists') }}</a>
        </div>


    </div>

    @if (isset($businessRegistration))
        <livewire:business_registration.business_renewal_form :$businessRegistration :$action />
    @else
        <livewire:business_registration.business_renewal_form :$action />
    @endif
</x-layout.app>
