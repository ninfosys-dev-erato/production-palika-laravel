<x-layout.app header="EquipmentAdditionalCost  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">EquipmentAdditionalCost</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($equipmentAdditionalCost))
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
                            @if (!isset($equipmentAdditionalCost))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($equipmentAdditionalCost) ? __('yojana::yojana.create_equipmentadditionalcost') : __('yojana::yojana.update_equipmentadditionalcost') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.equipment_additional_costs.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.equipmentadditionalcost_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($equipmentAdditionalCost))
            <livewire:equipment_additional_costs.equipment_additional_cost_form  :$action :$equipmentAdditionalCost />
        @else
            <livewire:equipment_additional_costs.equipment_additional_cost_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
