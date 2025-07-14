<x-layout.app header="Fuel  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">Fuel</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($fuel))
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
                            @if (!isset($fuel))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($fuel) ? __('yojana::yojana.create_fuel') : __('yojana::yojana.update_fuel') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.fuels.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.fuel_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($fuel))
            <livewire:fuels.fuel_form  :$action :$fuel />
        @else
            <livewire:fuels.fuel_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
