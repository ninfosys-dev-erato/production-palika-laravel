<x-layout.app header="MaterialType  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">MaterialType</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($materialType))
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
                            @if (!isset($materialType))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($materialType) ? __('yojana::yojana.create_materialtype') : __('yojana::yojana.update_materialtype') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.material_types.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.materialtype_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($materialType))
            <livewire:material_types.material_type_form  :$action :$materialType />
        @else
            <livewire:material_types.material_type_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
