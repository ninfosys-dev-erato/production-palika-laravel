<div>
    <div class="row flex-column">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="btn-toolbar demo-inline-spacing" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    <button type="button" class="btn btn-outline-secondary">
                        <i class="tf-icons bx bx-refresh"></i>
                    </button>
                    @if (!optional($fileRecord->seenFavourites)->is_archived)
                        <button type="button" class="btn btn-outline-secondary" wire:click="archieveFile">
                            <i class="tf-icons bx bx-archive-in"></i>
                        </button>
                    @endif

                </div>
            </div>

            <div>
                <a href="javascript:history.back()" class="btn btn-info">
                    <i class="bx bx-arrow-back"></i>{{ __('filetracking::filetracking.back') }}
                </a>
            </div>
        </div>

        <div class="d-flex flex-column mt-4 border p-3 rounded shadow-sm">
            <h3 class="fw-bold mb-3">
                #{{ $fileRecord->reg_no }} | {{ $fileRecord->title }}
            </h3>
            <span class="label label-success">
                {!! \Src\FileTracking\Enums\PatracharStatus::tryFrom($fileRecord->patrachar_status)?->label() 
                    ?? \Src\FileTracking\Enums\PatracharStatus::PENDING->label() !!}
            </span>
            <br>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <img src="{{ Avatar::create($fileRecord->applicant_name)->toBase64() }}"
                        class="rounded-circle img-thumbnail avatar-sm me-2" alt="User Avatar">
                    <div>

                        <p class="mb-0 fw-bold text-primary">{{ $fileRecord->applicant_name }}</p>
                        <small class="text-muted">{{ __('filetracking::filetracking.from') }}: {{ $fileRecord->sender?->name }}</small><br>

                        @if ($fileRecord->recipients()->isNotEmpty())
                            <small class="text-muted">{{ __('filetracking::filetracking.to') }}:
                                @foreach ($fileRecord->recipients() as $recipient)
                                    {{ $recipient->display_name }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </small>
                        @else
                            <small class="text-muted">{{ __('filetracking::filetracking.to') }}:
                                {{ $fileRecord->recipient_name }}

                            </small>
                        @endif

                    </div>
                </div>
                <div class="d-flex gap-3">
                    @if (!$fileRecord->is_farsyaut)
                        <button class="btn btn-primary" wire:click="openModalForForward">{{ __('filetracking::filetracking.forward') }}</button>
                        <button class="btn btn-secondary"
                            wire:click="openModalForFarsyaut">{{ __('filetracking::filetracking.Farsyaut') }}</button>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <small class="text-muted text-primary">{{ $fileRecord->created_at->diffForHumans() }}</small>
            </div>
        </div>
        @if ($fileRecord->file)
            @php
                $files = is_array($fileRecord->file) ? $fileRecord->file : json_decode($fileRecord->file, true);

            @endphp

            @if (is_array($files))
                @foreach ($files as $file)
                    @php
                        $fileUrl = customFileAsset(config('src.FileTracking.fileTracking.file'), $file, 'local', 'tempUrl');

                        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    @endphp

                    @if ($file)
                        <div class="card d-inline-block me-2 mb-2 cursor-pointer" style="width: 150px;"
                            data-bs-toggle="modal" data-bs-target="#filePreviewModal{{ $loop->index }}">
                            <div class="card-body text-center p-2">
                                <img src="{{ $fileUrl }}" alt="File Preview"
                                    class="img-fluid rounded mb-2" style="max-height: 80px; object-fit: cover;">
                                <div class="text-muted small">File Preview</div>
                                <div class="text-truncate small">{{ basename($file) }}</div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="filePreviewModal{{ $loop->index }}" tabindex="-1"
                            role="dialog" wire:ignore.self>
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('File Preview') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ $fileUrl }}" alt="{{ __('File Preview') }}"
                                            class="img-fluid rounded">
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ $fileUrl }}" download class="btn btn-primary">
                                            <i class="bx bx-download"></i> {{ __('Download') }}
                                        </a>
                                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-info">
                                            <i class="bx bx-link-external"></i> {{ __('Open in New Tab') }}
                                        </a>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-danger"> पत्र अपलोड गरिएको छैन</div>
            @endif
        @elseif ($fileRecord->subject?->document)
            @php
                $docUrls = $fileRecord->subject->document;
                $urls = collect($docUrls)->flatten(1)->filter()->values()->toArray();
            @endphp

            @foreach ($urls as $docUrl)
                @php
                    $extension = strtolower(pathinfo($docUrl, PATHINFO_EXTENSION));
                @endphp

                @if ($docUrl && $extension)
                    <div class="card d-inline-block me-2 mb-2 cursor-pointer" style="width: 150px;"
                        data-bs-toggle="modal" data-bs-target="#docPreviewModal{{ $loop->index }}">
                        <div class="card-body text-center p-2">
                            <img src="{{ $docUrl }}" alt="File Preview"
                                class="img-fluid rounded mb-2" style="max-height: 80px; object-fit: cover;">
                            <div class="text-muted small">File Preview</div>
                            <div class="text-truncate small">{{ basename($docUrl) }}</div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="docPreviewModal{{ $loop->index }}" tabindex="-1"
                        role="dialog" wire:ignore.self>
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('File Preview') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ $docUrl }}" alt="{{ __('File Preview') }}"
                                        class="img-fluid rounded">
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ $docUrl }}" download class="btn btn-primary">
                                        <i class="bx bx-download"></i> {{ __('Download') }}
                                    </a>
                                    <a href="{{ $docUrl }}" target="_blank" class="btn btn-info">
                                        <i class="bx bx-link-external"></i> {{ __('Open in New Tab') }}
                                    </a>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div class="p-4 border rounded bg-light text-center text-muted">
                पत्र अपलोड गरिएको छैन
            </div>
        @endif
        <hr>
    </div>
    @if (is_null($fileRecord->main_thread_id))
        @foreach ($fileRecord->logs->sortByDesc('created_at') as $fileRecordLog)
            <livewire:file_tracking.patrachar_thread :$fileRecordLog :key="$fileRecordLog->id" />
        @endforeach
    @else
        @foreach ($fileRecord->mainThreadLogs->sortByDesc('created_at') as $fileRecordLog)
            <livewire:file_tracking.patrachar_thread :$fileRecordLog :key="$fileRecordLog->id" />
        @endforeach
    @endif

    @if ($openModalForward)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow-lg rounded-3 border-0">
                    <div class="modal-header text-white">
                        <h5 class="modal-title fw-bold">{{ __('filetracking::filetracking.forward_file') }}</h5>
                        <button type="button" class="btn-close btn-close-white"
                            wire:click="closeModalForward"></button>
                    </div>
                    <div class="modal-body p-4">
                        <livewire:file_tracking.patrachar_forward_form :$fileRecord />
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-success" onclick="Livewire.dispatch('patrachar-forward')">
                            {{ __('filetracking::filetracking.doForward') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($openModalFarsyaut)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow-lg rounded-3 border-0">
                    <div class="modal-header text-white">
                        <h5 class="modal-title fw-bold">{{ __('filetracking::filetracking.farsyaut_file') }}</h5>
                        <button type="button" class="btn-close btn-close-white"
                            wire:click="closeModalFarsyaut"></button>
                    </div>
                    <div class="modal-body p-4">
                        <livewire:file_tracking.patrachar_farsyaut_form :$fileRecord />
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-success"
                            onclick="Livewire.dispatch('patrachar-farsyaut')"> {{ __('filetracking::filetracking.doFarsyaut') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
