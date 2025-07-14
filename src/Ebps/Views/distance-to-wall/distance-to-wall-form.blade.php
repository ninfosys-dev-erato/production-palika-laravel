<x-layout.app header="DistanceToWall  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">DistanceToWall</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($distanceToWall))
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
                            @if (!isset($distanceToWall))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($distanceToWall) ? __('ebps::ebps.create_distancetowall') : __('ebps::ebps.update_distancetowall') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.distance_to_walls.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.distancetowall_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($distanceToWall))
            <livewire:ebps.distance_to_wall_form  :$action :$distanceToWall />
        @else
            <livewire:ebps.distance_to_wall_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
