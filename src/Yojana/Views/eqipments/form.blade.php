<x-layout.app header="Equipment  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">Equipment</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($equipment))
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
                            @if (!isset($equipment))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($equipment) ? __('yojana::yojana.create_equipment') : __('yojana::yojana.update_equipment') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.equipment.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.equipment_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($equipment))
            <livewire:equipment.equipment_form  :$action :$equipment />
        @else
            <livewire:equipment.equipment_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
