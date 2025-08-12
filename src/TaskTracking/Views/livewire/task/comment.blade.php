<div class="card-footer bg-white">
    <div class="d-flex justify-content-between align-items-center">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#comments" aria-controls="comments" aria-selected="false">
                    {{ __('tasktracking::tasktracking.comment') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#activity"
                    aria-controls="activity" aria-selected="false">
                    {{ __('tasktracking::tasktracking.activity') }}
                </button>
            </li>
        </ul>

        <button class="btn btn-primary"
            onclick="window.location.href='{{ route('admin.tasks.edit', $task->id) }}'">{{ __('tasktracking::tasktracking.edit_task') }}</button>
    </div>


    <div class="tab-content mt-2" id="taskTabsContent">
        <div class="tab-pane fade show active" id="comments" role="tabpanel">
            <div>
                <textarea class="form-control" rows="3" placeholder="{{ __('tasktracking::tasktracking.add_a_comment') }}..."
                    wire:model.defer="commentContent" name="commentContent"></textarea>

                <div class="mb-3">
                    <div class="form-group">
                        <label for="uploadFiles">{{ __('tasktracking::tasktracking.upload_attachments') }}</label>
                        <input wire:model="uploadFiles" name="uploadFiles" type="file" class="form-control"
                            accept=".pdf,.doc,.docx,image/*" multiple>
                        @error('uploadFiles.*')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        @if ($uploadFiles)
                            <div class="row">
                                @foreach ($uploadFiles as $file)
                                    <div class="col-md-3 col-sm-4 col-6 mb-3">
                                        @if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']))
                                            <img src="{{ $file->temporaryUrl() }}" alt="Image Preview"
                                                class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
                                        @endif

                                        @if (in_array($file->getClientOriginalExtension(), ['pdf']))
                                            <div class="card" style="max-width: 200px;">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ __('tasktracking::tasktracking.pdf_file') }}</h5>
                                                    <p class="card-text">{{ $file->getClientOriginalName() }}</p>
                                                    <a href="{{ $file->temporaryUrl() }}" target="_blank"
                                                        class="btn btn-primary btn-sm">
                                                        {{ __('tasktracking::tasktracking.open_pdf') }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <button class="btn btn-primary mt-3" wire:click="addComment">{{ __('tasktracking::tasktracking.add_comment') }}</button>
            </div>

            @foreach ($task->comments->reverse() as $comment)
                <div class="mb-2 mt-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                            style="width: 24px; height: 24px;">
                            {{ substr($comment->commenter->name, 0, 1) }}
                        </div>
                        <strong>{{ $comment->commenter->name }}</strong>
                        <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mt-2 mb-0">{{ $comment->content }}</p>

                    @if ($comment->attachments->isNotEmpty())
                        <div class="mt-2">
                            <h6>{{ __('tasktracking::tasktracking.attachments') }}:</h6>
                            <ul class="list-unstyled">
                                @foreach ($comment->attachments as $attachment)
                                    @php
                                        $files = json_decode($attachment->file, true);
                                    @endphp

                                    @if ($files && is_array($files))
                                        @foreach ($files as $file)
                                            @php
                                                $fileUrl = customFileAsset(
                                                    config('src.TaskTracking.TaskTracking.path'),
                                                    $file,
                                                    'local',
                                                    'tempUrl'
                                                );
                                                $pdfUrl = customFileAsset(
                                                    config('src.TaskTracking.TaskTracking.path'),
                                                    $file,
                                                    'local',
                                                    'tempUrl'
                                                );
                                                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                $fileName = pathinfo($file, PATHINFO_FILENAME);
                                            @endphp

                                            <li class="document-item d-flex align-items-center mb-2 p-2 border rounded"
                                                style="background-color: #f8f9fa;">
                                                @if (in_array($extension, ['png', 'jpeg', 'jpg']))
                                                    <i class="bi bi-image text-primary me-2"></i>
                                                    <a href="{{ $fileUrl }}" target="_blank">
                                                        <p class="text mb-0">{{ 'IMAGE' }} ({{ $extension }})
                                                        </p>
                                                    </a>
                                                @elseif ($extension === 'pdf')
                                                    <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                    <a href="{{ $pdfUrl }}" target="_blank">
                                                        <p class="text mb-0">{{ 'PDF' }} ({{ $extension }})
                                                        </p>
                                                    </a>
                                                @else
                                                    <i class="bi bi-file-earmark text-secondary me-2"></i>
                                                    <a href="{{ $fileUrl }}" target="_blank">
                                                        <p class="text mb-0">{{ 'IMAGE' }} ({{ $extension }})
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
            @endforeach
        </div>

        <div class="tab-pane fade" id="activity" role="tabpanel">
            <div class="task-activities">
                <h3>Activity Log</h3>
                <ul class="list-group">
                    @if ($task->taskActivities->isNotEmpty())
                        @foreach ($task->taskActivities->reverse() as $activity)
                            <li class="list-group-item">
                                <div>
                                    <strong>{{ $activity->user->name }}</strong>
                                    @if ($activity->action == 'task-created')
                                        created the task
                                    @elseif($activity->action == 'task-updated')
                                        updated the task
                                    @elseif($activity->action == 'comment-added')
                                        added a comment
                                    @elseif($activity->action == 'attachment-uploaded')
                                        uploaded an attachment
                                    @else
                                        performed an action: <em>{{ $activity->action }}</em>
                                    @endif

                                    @if ($activity->description)
                                        <br><small>{{ $activity->description }}</small>
                                    @endif
                                </div>

                                <div class="text-muted">
                                    <small>{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('comment-added', () => {
            window.location.reload();
        });
    </script>
@endscript
