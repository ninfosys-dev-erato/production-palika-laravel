<x-layout.app header="Project  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('tasktracking::tasktracking.project') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($project))
                    {{ __('tasktracking::tasktracking.create') }}
                @else
                    {{ __('tasktracking::tasktracking.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ $action->value === 'create' ? __('tasktracking::tasktracking.create') . ' ' . __('tasktracking::tasktracking.project') : __('tasktracking::tasktracking.update') . ' ' . __('tasktracking::tasktracking.project') }}
                    </h5>

                    <div>
                        @perm('tsk_setting edit')
                            <a href="{{ route('admin.task.projects.index') }}" class="btn btn-info"><i
                                    class="bx bx-list-ol"></i>{{ __('tasktracking::tasktracking.project_list') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($project))
                        <livewire:task_tracking.project_form :$action :$project />
                    @else
                        <livewire:task_tracking.project_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
