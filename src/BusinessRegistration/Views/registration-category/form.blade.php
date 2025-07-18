<x-layout.app header="Registration Category Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('businessregistration::businessregistration.registration_category') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($registrationCategory))
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
                {{ __('businessregistration::businessregistration.registration_category') }} {{ $action->value === 'create' ? __('businessregistration::businessregistration.create') : __('businessregistration::businessregistration.edit') }}
            </h5>
            <a href="{{ route('admin.business-registration.registration-category.index') }}" class="btn btn-info"><i
                        class="bx bx-list-ul"></i>{{ __('businessregistration::businessregistration.registration_categories') }}</a>
        </div>
        <div class="card-body">
            @if (isset($registrationCategory))
                <livewire:business_registration.registration_category_form :$action
                                                                                       :$registrationCategory/>
            @else
                <livewire:business_registration.registration_category_form :$action/>
            @endif
        </div>
    </div>
</x-layout.app>
