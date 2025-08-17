<x-layout.app header="{{ __('businessregistration::businessregistration.business_registration_form') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('businessregistration::businessregistration.business_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($businessRegistration))
                    {{ __('businessregistration::businessregistration.create') }}
                @else
                    {{ __('businessregistration::businessregistration.edit') }}
                @endif
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            @if (isset($registration->title))
                <h5 class="text-primary fw-bold mb-0"> {{ $registration->title }}</h4>
                @else
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('businessregistration::businessregistration.registration_form') }}
                    </h5>
            @endif

            <a href="{{ route('admin.business-registration.business-registration.index', ['type' => $businessRegistrationType]) }}"
                class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('businessregistration::businessregistration.business_registration_lists') }}</a>
        </div>
    </div>
    @if (isset($businessRegistration))
        <livewire:business_registration.business_registration_form :$businessRegistration :$action
            :$businessRegistrationType />
    @else
        <livewire:business_registration.business_registration_form :$action :$businessRegistrationType :$registration />
    @endif


</x-layout.app>
