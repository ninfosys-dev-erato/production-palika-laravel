<x-layout.app header="{{ __('tasktracking::tasktracking.task_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('tasktracking::tasktracking.task') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('tasktracking::tasktracking.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">{{ __('tasktracking::tasktracking.task_list') }}</h5>
                    <div>
                        @perm('tsk_management create')
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#taskModal">
                                <i class="bx bx-plus"></i> {{ __('tasktracking::tasktracking.add_task') }}
                            </button>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:task_tracking.task_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit Task Form -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">
                        @if (isset($task))
                            {{ __('tasktracking::tasktracking.edit_task') }}
                        @else
                            {{ __('tasktracking::tasktracking.add_task') }}
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Call the Livewire Task Form Component -->
                    <div class="card-body">
                        @if (isset($task))
                            <livewire:task_tracking.task_form :$action :$task />
                        @else
                            <livewire:task_tracking.task_form :$action />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>


<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('taskSaved', () => {

            var modal = new bootstrap.Modal(document.getElementById('taskModal'));
            modal.hide();
        });
    });
</script>
