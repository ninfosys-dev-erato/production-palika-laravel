<x-layout.app header="MapApplyDetail  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">{{__('ebps::ebps.mapapplydetail')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($mapApplyDetail))
                    {{__('ebps::ebps.create')}}
                    @else
                    {{__('ebps::ebps.edit')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($mapApplyDetail))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($mapApplyDetail) ? __('ebps::ebps.create_mapapplydetail') : __('ebps::ebps.update_mapapplydetail') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.map_apply_details.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.mapapplydetail_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($mapApplyDetail))
            <livewire:ebps.map_apply_detail_form  :$action :$mapApplyDetail />
        @else
            <livewire:ebps.map_apply_detail_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
