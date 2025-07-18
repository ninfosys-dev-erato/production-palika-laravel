<x-layout.app header="BuildingConstructionType  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('ebps::ebps.building_construction_type')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($buildingConstructionType))
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
                    @if (!isset($buildingConstructionType))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($buildingConstructionType) ? __('ebps::ebps.create_building_construction_type') : __('ebps::ebps.update_building_construction_type') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.building_construction_types.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.building_construction_type_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($buildingConstructionType))
                    <livewire:ebps.building_construction_type_form :$action :$buildingConstructionType />
                @else
                    <livewire:ebps.building_construction_type_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
