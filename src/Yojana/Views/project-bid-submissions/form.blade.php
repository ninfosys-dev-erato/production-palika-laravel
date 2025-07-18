<x-layout.app header="ProjectBidSubmission  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">ProjectBidSubmission</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($projectBidSubmission))
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
                            @if (!isset($projectBidSubmission))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($projectBidSubmission) ? __('yojana::yojana.create_projectbidsubmission') : __('yojana::yojana.update_projectbidsubmission') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.project_bid_submissions.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.projectbidsubmission_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($projectBidSubmission))
            <livewire:project_bid_submissions.project_bid_submission_form  :$action :$projectBidSubmission />
        @else
            <livewire:project_bid_submissions.project_bid_submission_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
