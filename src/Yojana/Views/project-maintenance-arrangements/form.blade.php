<x-layout.app header="ProjectMaintenanceArrangement  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">ProjectMaintenanceArrangement</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($projectMaintenanceArrangement))
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
                            @if (!isset($projectMaintenanceArrangement))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($projectMaintenanceArrangement) ? __('yojana::yojana.create_projectmaintenancearrangement') : __('yojana::yojana.update_projectmaintenancearrangement') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.project_maintenance_arrangements.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.projectmaintenancearrangement_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($projectMaintenanceArrangement))
            <livewire:project_maintenance_arrangements.project_maintenance_arrangement_form  :$action :$projectMaintenanceArrangement />
        @else
            <livewire:project_maintenance_arrangements.project_maintenance_arrangement_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
