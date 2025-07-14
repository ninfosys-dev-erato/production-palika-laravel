<x-layout.app header="StructureType  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">StructureType</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($structureType))
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
                            @if (!isset($structureType))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($structureType) ? __('ebps::ebps.create_structuretype') : __('ebps::ebps.update_structuretype') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.structure_types.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.structuretype_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($structureType))
            <livewire:ebps.structure_type_form  :$action :$structureType />
        @else
            <livewire:ebps.structure_type_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
