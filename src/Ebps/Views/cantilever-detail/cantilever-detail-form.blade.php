<x-layout.app header="CantileverDetail  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">CantileverDetail</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($cantileverDetail))
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
                            @if (!isset($cantileverDetail))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($cantileverDetail) ? __('ebps::ebps.create_cantileverdetail') : __('ebps::ebps.update_cantileverdetail') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.cantilever_details.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.cantileverdetail_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($cantileverDetail))
            <livewire:ebps.cantilever_detail_form  :$action :$cantileverDetail />
        @else
            <livewire:ebps.cantilever_detail_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
