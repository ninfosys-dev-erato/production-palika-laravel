<x-layout.app header="Project List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('tasktracking::tasktracking.project') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('tasktracking::tasktracking.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('tasktracking::tasktracking.project_list') }}
                    </h5>
                    <div>
                        @perm('tsk_setting create')
                            <a href="{{ route('admin.task.projects.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i>
                                {{ __('tasktracking::tasktracking.add_project') }}</a>
                        @endperm

                    </div>
                </div>
                <div class="card-body">
                    <livewire:task_tracking.project_table theme="bootstrap-4" />
                </div>
            </div>

        </div>
    </div>
</x-layout.app>
