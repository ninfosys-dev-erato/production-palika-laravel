<x-layout.app header="ProjectBidDetail  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">ProjectBidDetail</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($projectBidDetail))
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
                            @if (!isset($projectBidDetail))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($projectBidDetail) ? __('yojana::yojana.create_projectbiddetail') : __('yojana::yojana.update_projectbiddetail') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.project_bid_details.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.projectbiddetail_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($projectBidDetail))
            <livewire:project_bid_details.project_bid_detail_form  :$action :$projectBidDetail />
        @else
            <livewire:project_bid_details.project_bid_detail_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
