<x-layout.app header="{{__('Four Boundary '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.four_boundaries.index')}}">{{__('ebps::ebps.four_boundary')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($fourBoundary))
                        {{__('ebps::ebps.edit')}}
                    @else
                       {{__('ebps::ebps.create')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($fourBoundary))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($fourBoundary) ? __('ebps::ebps.create_four_boundary') : __('ebps::ebps.update_four_boundary') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.four_boundaries.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.four_boundary_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($fourBoundary))
            <livewire:four_boundaries.four_boundary_form  :$action :$fourBoundary />
        @else
            <livewire:four_boundaries.four_boundary_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
