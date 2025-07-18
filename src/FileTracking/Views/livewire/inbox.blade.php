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
                        $fileUrl = customAsset(config('src.FileTracking.fileTracking.file'), $file, 'local');

                        $extension = strtolower(pathinfo(parse_url($file, PHP_URL_PATH), PATHINFO_EXTENSION));

                    @endphp

                    @if ($file)
                        <div class="p-4 border rounded bg-light text-center text-muted position-relative mt-4">
                            {{-- Download Icon --}}
                            <a href="{{ $fileUrl }}" download title="डाउनलोड गर्नुहोस्"
                                class="btn btn-light border rounded-circle shadow-sm position-absolute top-0 end-0 m-3"
                                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class='bx bx-download bx-sm'></i>
                            </a>

                            {{-- Preview based on file type --}}
                            @switch($extension)
                                @case('jpg')
                                @case('jpeg')
                                @case('png')
                                @case('gif')
                                @case('bmp')
                                @case('webp')
                                    <img src="{{ $fileUrl }}" alt="Uploaded Document" class="img-fluid rounded shadow-sm"
                                        style="max-height: 400px; width: 100%; object-fit: contain;">
                                @break

                                @case('pdf')
                                    <embed src="{{ $fileUrl }}" type="application/pdf" width="100%" height="600px"
                                        style="object-fit: contain;" />
                                @break

                                @default
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary mt-3">
                                        <i class='bx bx-link-external'></i> कागजात हेर्नुहोस्
                                    </a>
                            @endswitch
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
                    $extension = strtolower(pathinfo(parse_url($docUrl, PHP_URL_PATH), PATHINFO_EXTENSION));
                @endphp

                @if ($docUrl && $extension)
                    <div class="p-4 border rounded bg-light text-center text-muted position-relative">
                        {{-- Download Icon --}}
                        <a href="{{ $docUrl }}" download title="डाउनलोड गर्नुहोस्"
                            class="btn btn-light border rounded-circle shadow-sm position-absolute top-0 end-0 m-3"
                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class='bx bx-download bx-sm'></i>
                        </a>

                        {{-- Preview based on file type --}}
                        @switch($extension)
                            @case('jpg')
                            @case('jpeg')
                            @case('png')
                            @case('gif')
                            @case('bmp')
                            @case('webp')
                                <img src="{{ $docUrl }}" alt="Uploaded Document" class="img-fluid rounded shadow-sm"
                                    style="max-height: 400px; width: 100%; object-fit: contain;">
                            @break

                            @case('pdf')
                                <embed src="{{ $docUrl }}" type="application/pdf" width="100%" height="600px"
                                    style="object-fit: contain;" />
                            @break

                            @default
                                <a href="{{ $docUrl }}" target="_blank" class="btn btn-outline-primary mt-3">
                                    <i class='bx bx-link-external'></i> {{ __('filetracking::filetracking.view_document') }}
                                </a>
                        @endswitch
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
