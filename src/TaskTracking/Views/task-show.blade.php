<x-layout.app header="Task Details">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold mb-0">{{ __('tasktracking::tasktracking.task_details') }}</h5>
        <a href="javascript:history.back()" class="btn btn-info"><i class="bx bx-arrow-back"></i>{{ __('tasktracking::tasktracking.back') }}</a>
    </div>
    <div class="mt-2">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">

                    <h5 class="card-title mb-0 text-primary">{{ $task->task_no }}</h5>
                    <h6 class="text-muted mb-0">{{ $task->title }}</h6>
                </div>
                <span class="badge bg-primary rounded-pill text-white">{{ ucfirst($task->status) }}</span>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <!-- Project -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small">{{ __('tasktracking::tasktracking.project') }}</div>
                            <div class="mt-1 fw-bold">{{ $task->project->title }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small">{{ __('tasktracking::tasktracking.task_type') }}</div>
                            <div class="mt-1 fw-bold">{{ $task->taskType->type_name }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small">{{ __('tasktracking::tasktracking.assignee') }}</div>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                    style="width: 24px; height: 24px;">
                                    {{ substr($task->assignee->name, 0, 1) }}
                                </div>
                                <span class="fw-bold">{{ $task->assignee->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small">{{ __('tasktracking::tasktracking.reporter') }}</div>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                    style="width: 24px; height: 24px;">
                                    {{ substr($task->reporter->name, 0, 1) }}
                                </div>
                                <span class="fw-bold">{{ $task->reporter->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small">{{ __('tasktracking::tasktracking.start_date') }}</div>
                            <div class="mt-1">{{ $task->start_date ?? 'None' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="text-muted small">{{ __('tasktracking::tasktracking.due_date') }}</div>
                            <div class="mt-1">{{ $task->end_date ?? 'None' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="text-muted small mb-2">{{ __('tasktracking::tasktracking.description') }}</div>
                    <p class="mb-0">{!! $task->description !!}</p>
                </div>

                <div class="mt-4">
                    @if ($task->attachments->isNotEmpty())
                        <div class="mt-2">
                            <h6>{{ __('tasktracking::tasktracking.attachments') }}:</h6>
                            <ul class="list-unstyled">
                                @foreach ($task->attachments as $attachment)
                                    @php
                                        $files = json_decode($attachment->file, true);
                                    @endphp

                                    @if ($files && is_array($files))
                                        @foreach ($files as $file)
                                            @php
                                                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                $fileName = pathinfo($file, PATHINFO_FILENAME);
                                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                                                
                                                if ($isImage) {
                                                    $fileUrl = customAsset(
                                                        config('src.TaskTracking.TaskTracking.path'),
                                                        $file,
                                                    );
                                                } else {
                                                    $fileUrl = customFileAsset(
                                                        config('src.TaskTracking.TaskTracking.path'),
                                                        $file,
                                                        'local',
                                                        'tempUrl'
                                                    );
                                                }
                                            @endphp

                                            <li class="document-item d-flex align-items-center mb-2 p-2 border rounded"
                                                style="background-color: #f8f9fa;">
                                                @if ($isImage)
                                                    <i class="bi bi-image text-primary me-2"></i>
                                                    <a href="{{ $fileUrl }}" target="_blank">
                                                        <p class="text mb-0">{{ 'IMAGE' }} ({{ $extension }})
                                                        </p>
                                                    </a>
                                                @elseif ($extension === 'pdf')
                                                    <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                    <a href="{{ $fileUrl }}" target="_blank">
                                                        <p class="text mb-0">{{ 'PDF' }} ({{ $extension }})
                                                        </p>
                                                    </a>
                                                @else
                                                    <i class="bi bi-file-earmark text-secondary me-2"></i>
                                                    <a href="{{ $fileUrl }}" target="_blank">
                                                        <p class="text mb-0">{{ 'FILE' }} ({{ $extension }})
                                                        </p>
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    @else
                                        <li>{{ __('tasktracking::tasktracking.no_files_attached') }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>


            <div class="card-footer bg-light border-top py-3">
                <livewire:task_tracking.task_comment_activity :$task />
            </div>
        </div>
    </div>
</x-layout.app>
