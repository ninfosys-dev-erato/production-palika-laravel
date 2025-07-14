<x-layout.app header="TaskType  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('tasktracking::tasktracking.task_type') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($taskType))
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
                        {{ !isset($taskType) ? __('tasktracking::tasktracking.create') . ' ' . __('tasktracking::tasktracking.task_type') : __('tasktracking::tasktracking.update') . ' ' . __('tasktracking::tasktracking.task_type') }}
                    </h5>
                    <div>
                        @perm('task_type access')
                            <a href="{{ route('admin.task-types.index') }}" class="btn btn-info">
                                <i class="bx bx-list-ol"></i>{{ __('tasktracking::tasktracking.task_type_list') }}
                            </a>
                        @endperm
                    </div>
                </div>
                @if (isset($taskType))
                    <livewire:task_tracking.task_type_form :$action :$taskType />
                @else
                    <livewire:task_tracking.task_type_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
