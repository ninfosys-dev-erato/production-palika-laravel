<x-layout.app header="Material  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">Material</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($material))
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
                            @if (!isset($material))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($material) ? __('yojana::yojana.create_material') : __('yojana::yojana.update_material') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.materials.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.material_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($material))
            <livewire:materials.material_form  :$action :$material />
        @else
            <livewire:materials.material_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
