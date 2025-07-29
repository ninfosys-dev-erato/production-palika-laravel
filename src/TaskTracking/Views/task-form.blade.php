<x-layout.app header="Task  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('tasktracking::tasktracking.task') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($task))
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
                        {{ $action->value === 'create' ? __('tasktracking::tasktracking.create') . ' ' . __('tasktracking::tasktracking.task') : __('tasktracking::tasktracking.update') . ' ' . __('tasktracking::tasktracking.task') }}
                    </h5>
                    <div>
                        @perm('tsk_setting edit')
                            <a href="javascript:history.back()" class="btn btn-info"><i
                                    class="bx bx-arrow-back"></i>{{ __('tasktracking::tasktracking.back') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($task))
                        <livewire:task_tracking.task_update_form :$action :$task />
                    @else
                        <livewire:task_tracking.task_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
