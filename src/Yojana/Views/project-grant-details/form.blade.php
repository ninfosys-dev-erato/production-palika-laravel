<x-layout.app header="ProjectGrantDetail  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">ProjectGrantDetail</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($projectGrantDetail))
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
                            @if (!isset($projectGrantDetail))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($projectGrantDetail) ? __('yojana::yojana.create_projectgrantdetail') : __('yojana::yojana.update_projectgrantdetail') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.project_grant_details.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.projectgrantdetail_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($projectGrantDetail))
            <livewire:project_grant_details.project_grant_detail_form  :$action :$projectGrantDetail />
        @else
            <livewire:project_grant_details.project_grant_detail_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
