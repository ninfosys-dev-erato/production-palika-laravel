<div>
    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="javascript:history.back()" class="btn btn-outline-primary">
            <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
        </a>
    </div>
    <div class="document-editor-container">
        <div class="card shadow border-0 rounded-3">
            <!-- Header -->
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="card-title mb-0 text-primary fw-bold">
                        <i class="bx bx-file-edit me-2"></i>{{ __('ebps::ebps.document_editor') }}
                    </h5>
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check form-switch d-flex align-items-center gap-2 pe-3 border-end">
                            <span class="text-muted fw-semibold">{{ __('ebps::ebps.edit') }}</span>
                            <input type="checkbox" class="form-check-input toggle-switch" id="previewToggle"
                                {{ $preview ? 'checked' : '' }} wire:click="togglePreview">
                            <span class="text-muted fw-semibold">{{ __('ebps::ebps.preview') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $isCompletelyEmpty = true;
                foreach ($data as $group) {
                    if (!empty(array_filter($group))) {
                        $isCompletelyEmpty = false;
                        break;
                    }
                }
            @endphp

            <!-- Main Tabs Navigation -->
            <ul class="nav nav-tabs nav-tabs-modern" role="tablist">

                @if (empty($isCompletelyEmpty))
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab === 'form' ? 'active' : '' }} fw-semibold px-4 py-3" 
                            wire:click="switchTab('form')" type="button" role="tab">
                            <i class="bx bx-edit-alt me-2"></i>{{ __('ebps::ebps.form_input') }}
                        </button>
                    </li>
                @endif
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'preview' ? 'active' : '' }} fw-semibold px-4 py-3" 
                        wire:click="switchTab('preview')" type="button" role="tab">
                        <i class="bx bx-show me-2"></i>{{ __('ebps::ebps.previewedit') }}
                    </button>
                </li>
            </ul>

            <div class="tab-content p-0">
                <!-- Form Input Tab -->
                @if (empty($isCompletelyEmpty))
                    <div class="tab-pane fade {{ $activeTab === 'form' ? 'show active' : '' }}" id="form-content">
                        <div class="p-4">
                            @foreach ($letters as $formId => $letterContent)
                                @php
                                    $formTitle = Src\Settings\Models\Form::where('id', $formId)->first()->title;
                                @endphp

                                @if ($data[$formId])
                                    <div class="form-letter-container mb-4">
                                        <div class="section-title d-flex align-items-center mb-3">
                                            <div class="section-line bg-primary"></div>
                                            <h6 class="mb-0 text-primary fw-bold">{{ $formTitle }}</h6>
                                        </div>

                                        <div class="row">

                                            <!-- Form Fields Column -->
                                            <div class="col-md-6">
                                                <div class="card shadow-sm h-100">
                                                    <div class="card-header bg-light py-3">
                                                        <h6 class="mb-0 fw-bold">
                                                            <i
                                                                class="bx bx-list-ul me-2"></i>{{ __('ebps::ebps.form_fields') }}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body p-4">
                                                        <div class="row">
                                                            @foreach ($data[$formId] ?? [] as $key => $field)
                                                                <div class="col-md-6 mb-3">
                                                                    <div class="form-group">
                                                                        @switch($field['type'])
                                                                            @case('text')
                                                                                <x-form.text-input
                                                                                    label="{{ $field['label'] ?? 'Default Label' }}"
                                                                                    :type="$field['input_type'] ??
                                                                                        'text'"
                                                                                    name="data.{{ $formId }}.{{ $field['slug'] }}.value"
                                                                                    id="{{ $formId }}_{{ $field['slug'] }}"
                                                                                    :readonly="($field['is_readonly'] ?? 'no') === 'yes'" :disabled="($field['is_disabled'] ?? 'no') === 'yes'"
                                                                                    class="form-control shadow-sm border-0" />
                                                                            @break

                                                                            @default
                                                                                <p class="text-muted">
                                                                                    {{ $field['label'] ?? 'Unknown Field Type' }}
                                                                                </p>
                                                                        @endswitch
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <!-- Save Button -->
                                                        <div class="mt-3">
                                                            <button type="button"
                                                                wire:click="saveAndGenerate({{ $formId }})"
                                                                class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                                                                <i
                                                                    class="bx bx-save me-2"></i>{{ __('ebps::ebps.save') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                @endif
                                <hr class="my-4">
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Preview/Edit Tab -->
                <div class="tab-pane fade {{ $activeTab === 'preview' ? 'show active' : '' }}" id="preview-content">
                    <div class="p-4">
                        @foreach ($letters as $formId => $letterContent)
                            @php
                                $form = Src\Settings\Models\Form::where('id', $formId)->first();
                                $formTitle = $form->title;
                            @endphp

                            <div class="mb-4">
                                <div class="section-title d-flex align-items-center mb-3">
                                    <div class="section-line bg-primary"></div>
                                    <h6 class="mb-0 text-primary fw-bold">{{ $formTitle }}</h6>
                                </div>

                                <div class="card shadow-sm">
                                    <div
                                        class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">
                                            <i class="bx bx-edit me-2"></i>{{ __('ebps::ebps.document_content') }}
                                        </h6>
                                        <div class="btn-group">
                                            <button class="btn btn-primary btn-sm" type="button"
                                                wire:loading.attr="disabled" wire:click="save({{ $formId }})">
                                                <i class="bx bx-save me-1"></i> {{ __('ebps::ebps.save') }}
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                                wire:loading.attr="disabled"
                                                wire:click="resetLetter({{ $formId }})">
                                                <i class="bx bx-reset me-1"></i> {{ __('ebps::ebps.reset') }}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body p-0">
                                        <div class="editor-container {{ $preview ? 'd-none' : '' }}">
                                            <div class="p-3 bg-light border-bottom d-flex align-items-center">
                                                <span class="badge bg-primary me-2">
                                                    <i class="bx bx-edit me-1"></i>{{ __('ebps::ebps.edit_mode') }}
                                                </span>
                                                <small
                                                    class="text-muted">{{ __('ebps::ebps.make_changes_to_your_document_here') }}</small>
                                            </div>
                                            <div class="p-4">
                                                <x-form.ck-editor-dynamic id="map_letter_{{ $formId }}"
                                                    :formId="$formId" :value="$letters[$formId] ?? ''" />
                                            </div>
                                        </div>

                                        <div class="preview-container {{ !$preview ? 'd-none' : '' }}">
                                            <div class="p-3 bg-light border-bottom d-flex align-items-center">
                                                <span class="badge bg-success me-2">
                                                    <i class="bx bx-show me-1"></i>{{ __('ebps::ebps.preview_mode') }}
                                                </span>
                                                <small
                                                    class="text-muted">{{ __('ebps::ebps.this_is_how_your_document_will_appear') }}</small>
                                            </div>
                                            <div class="p-4 preview-content">
                                                {!! $letterContent !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Prevent default Bootstrap tab behavior and use Livewire instead
        document.addEventListener('DOMContentLoaded', function() {
            // Remove Bootstrap tab event listeners
            const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
            tabButtons.forEach(button => {
                button.removeAttribute('data-bs-toggle');
                button.removeAttribute('data-bs-target');
            });
        });
    </script>

    <style>
        /* Modern styling for the document editor */
        .document-editor-container {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        .card {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-top-left-radius: 0.75rem !important;
            border-top-right-radius: 0.75rem !important;
        }

        /* Modern tabs */
        .nav-tabs-modern {
            border-bottom: none;
            padding: 0 1rem;
            margin-top: 0.5rem;
        }

        /* Prevent tab content from collapsing */
        .tab-pane {
            transition: opacity 0.3s ease;
        }

        .tab-pane.fade {
            opacity: 0;
        }

        .tab-pane.fade.show {
            opacity: 1;
        }

        /* Ensure tab content stays visible during updates */
        .tab-content {
            min-height: 400px;
        }

        .nav-tabs-modern .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            transition: all 0.3s ease;
            border-radius: 0;
            position: relative;
        }

        .nav-tabs-modern .nav-link:hover {
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }

        .nav-tabs-modern .nav-link.active {
            color: #0d6efd;
            background-color: transparent;
            border-bottom: 3px solid #0d6efd;
        }

        /* Section title styling */
        .section-title {
            position: relative;
        }

        .section-line {
            width: 4px;
            height: 20px;
            background-color: #0d6efd;
            margin-right: 10px;
            border-radius: 2px;
        }

        /* Form controls */
        .form-control {
            border-radius: 0.5rem;
            padding: 0.625rem 0.75rem;
            border: 1px solid #dee2e6;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Toggle switch */
        .toggle-switch {
            cursor: pointer;
            width: 3rem;
            height: 1.5rem;
            background-color: #e9ecef;
            border-radius: 1.5rem;
            position: relative;
            transition: all 0.3s ease;
            border: 1px solid #ced4da;
        }

        .toggle-switch:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        /* Buttons */
        .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* Letter preview */
        .letter-preview {
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            background-color: #fff;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            border-radius: 0.375rem;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .row {
                flex-direction: column;
            }

            .col-md-6 {
                margin-bottom: 1.5rem;
            }

            .col-md-6:last-child {
                margin-bottom: 0;
            }
        }
    </style>

</div>
