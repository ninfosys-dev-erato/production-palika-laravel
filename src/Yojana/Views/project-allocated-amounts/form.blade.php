<x-layout.app header="ProjectAllocatedAmount  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">ProjectAllocatedAmount</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($projectAllocatedAmount))
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
                            @if (!isset($projectAllocatedAmount))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($projectAllocatedAmount) ? __('yojana::yojana.create_projectallocatedamount') : __('yojana::yojana.update_projectallocatedamount') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.project_allocated_amounts.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.projectallocatedamount_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($projectAllocatedAmount))
            <livewire:project_allocated_amounts.project_allocated_amount_form  :$action :$projectAllocatedAmount />
        @else
            <livewire:project_allocated_amounts.project_allocated_amount_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
