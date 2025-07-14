<x-layout.customer-app header="{{ __('Business Registration Form') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Business Registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($registrationType))
                    {{ __('Create') }}
                @else
                    {{ __('Edit') }}
                @endif
            </li>

        </ol>
    </nav>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold mb-0">
                {{ __('Business Registration Form') }}
            </h5>
            <a href="{{ route('customer.business-registration.business-registration.index') }}" class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('Business Registration Lists') }}</a>
        </div>
        <div class="card-body">
            @if (isset($businessRegistration))
                <livewire:customer_portal.business_registration_and_renewal.business_registration_form :$action
                    :$businessRegistration />
            @else
                <livewire:customer_portal.business_registration_and_renewal.business_registration_form :$action />
            @endif
        </div>
    </div>
</x-layout.customer-app>
