<x-layout.app header="ProjectDeadlineExtension  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">ProjectDeadlineExtension</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($projectDeadlineExtension))
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
                            @if (!isset($projectDeadlineExtension))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($projectDeadlineExtension) ? __('yojana::yojana.create_projectdeadlineextension') : __('yojana::yojana.update_projectdeadlineextension') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.project_deadline_extensions.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.projectdeadlineextension_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($projectDeadlineExtension))
            <livewire:project_deadline_extensions.project_deadline_extension_form  :$action :$projectDeadlineExtension />
        @else
            <livewire:project_deadline_extensions.project_deadline_extension_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
