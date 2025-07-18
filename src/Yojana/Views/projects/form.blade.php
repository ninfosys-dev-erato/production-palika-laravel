<x-layout.app header="Project  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">Project</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($project))
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
                            @if (!isset($project))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($project) ? __('yojana::yojana.create_project') : __('yojana::yojana.update_project') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.projects.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.project_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($project))
            <livewire:projects.project_form  :$action :$project />
        @else
            <livewire:projects.project_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
