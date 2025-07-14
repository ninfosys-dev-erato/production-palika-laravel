<x-layout.app header="BuildingCriteria  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">BuildingCriteria</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($buildingCriteria))
                    Create
                @else
                    Edit
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($buildingCriteria))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($buildingCriteria) ? __('ebps::ebps.create_buildingcriteria') : __('ebps::ebps.update_buildingcriteria') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.building_criterias.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.buildingcriteria_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($buildingCriteria))
                    <livewire:ebps.building_criteria_form :$action :$buildingCriteria />
                @else
                    <livewire:ebps.building_criteria_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>