<x-layout.business-app header="Building Registration {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('organization.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.building_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($mapApply))
                    {{ __('ebps::ebps.create') }}
                @else
                    {{ __('ebps::ebps.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($mapApply))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($mapApply) ? __('ebps::ebps.create_building_registration') : __('ebps::ebps.update_building_registration') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('organization.ebps.building-registrations.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.building_registration_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($mapApply))
                    <livewire:business_portal.ebps.building_registration_form :$action :$mapApply />
                @else
                    <livewire:business_portal.ebps.building_registration_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.business-app>
