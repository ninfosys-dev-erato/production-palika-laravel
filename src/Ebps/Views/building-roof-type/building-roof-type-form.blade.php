<x-layout.app header="BuildingRoofType  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('ebps::ebps.building_roof_type')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($buildingRoofType))
                    {{__('ebps::ebps.create')}}
                @else
                    {{__('ebps::ebps.edit')}}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($buildingRoofType))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($buildingRoofType) ? __('ebps::ebps.create_building_roof_type') : __('ebps::ebps.update_building_roof_type') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.building_roof_types.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.building_roof_type_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($buildingRoofType))
                    <livewire:ebpd.building_roof_type_form :$action :$buildingRoofType />
                @else
                    <livewire:ebps.building_roof_type_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>