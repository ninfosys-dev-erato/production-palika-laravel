<x-layout.app header="StoreyDetail  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">StoreyDetail</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($storeyDetail))
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
                            @if (!isset($storeyDetail))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($storeyDetail) ? __('ebps::ebps.create_storeydetail') : __('ebps::ebps.update_storeydetail') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.storey_details.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.storeydetail_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($storeyDetail))
            <livewire:ebps.storey_detail_form  :$action :$storeyDetail />
        @else
            <livewire:ebps.storey_detail_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
