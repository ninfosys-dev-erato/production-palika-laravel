<x-layout.app header="Road  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">Road</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($road))
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
                            @if (!isset($road))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($road) ? __('ebps::ebps.create_road') : __('ebps::ebps.update_road') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.roads.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.road_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($road))
            <livewire:ebps.road_form  :$action :$road />
        @else
            <livewire:ebps.road_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
