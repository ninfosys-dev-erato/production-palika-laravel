<x-layout.app header="MaterialCollection  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">MaterialCollection</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($materialCollection))
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
                            @if (!isset($materialCollection))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($materialCollection) ? __('yojana::yojana.create_materialcollection') : __('yojana::yojana.update_materialcollection') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.material_collections.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.materialcollection_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($materialCollection))
            <livewire:material_collections.material_collection_form  :$action :$materialCollection />
        @else
            <livewire:material_collections.material_collection_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
