<x-layout.app header="Business Registration Form">
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">Business Nature</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @if (isset($businessNature))
                    {{__('businessregistration::businessregistration.create')}}
                    @else
                    {{__('businessregistration::businessregistration.edit')}}
                    @endif
                </li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-primary fw-bold mb-0">
                    {{ __('businessregistration::businessregistration.business_nature_form') }}
                </h5>
                <a href="{{ route('admin.business-registration.business-nature.index') }}" class="btn btn-info"><i
                            class="bx bx-list-ul"></i>{{ __('businessregistration::businessregistration.business_nature_lists') }}</a>
            </div>
            <div class="card-body">
                @if (isset($businessNature))
                    <livewire:business_registration.business_nature_form :$action
                                                                                     :$businessNature/>
                @else
                    <livewire:business_registration.business_nature_form :$action/>
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
