<x-layout.app header="FuelDemand  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">FuelDemand</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($fuelDemand))
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
                            @if (!isset($fuelDemand))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($fuelDemand) ? __('yojana::yojana.create_fueldemand') : __('yojana::yojana.update_fueldemand') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.fuel_demands.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.fueldemand_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($fuelDemand))
            <livewire:fuel_demands.fuel_demand_form  :$action :$fuelDemand />
        @else
            <livewire:fuel_demands.fuel_demand_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
