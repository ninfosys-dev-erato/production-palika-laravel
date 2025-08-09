<x-layout.app header="{{ __('ebps::ebps.map_apply_steps') }}">

    @php
        $isRoleFilteringEnabled = Src\Ebps\Models\EbpsFilterSetting::isRoleFilteringEnabled();
    @endphp

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.ebps.map_applies.index') }}" class="btn btn-outline-primary">
            <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
        </a>
    </div>

    <div class="container py-4">
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex flex-wrap align-items-start justify-content-between">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-map-alt text-primary fs-3 me-2"></i>
                            <h3 class="text-primary fw-bold mb-0">{{ __('ebps::ebps.map_steps_overview') }}</h3>
                        </div>
                        <h6 class="text-primary mb-0 ms-4">
                            {{ $mapApply->submission_id }} – {{ $mapApply->full_name }}
                        </h6>
                    </div>

                    <div class="mt-2 mt-md-0 d-flex gap-2">
                        <a href="{{ route('admin.ebps.change-owner', ['id' => $mapApply->id]) }}"
                            class="btn btn-outline-secondary btn-sm">
                            <i class="bx bx-user me-1"></i> {{ __('ebps::ebps.change_owner') }}
                        </a>

                        <a href="{{ route('admin.ebps.change-organization', ['id' => $mapApply->id]) }}"
                            class="btn btn-outline-secondary btn-sm">
                            <i class="bx bx-user me-1"></i> {{ __('ebps::ebps.change_organization') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Application Progress -->
                <div class="position-relative mb-5 px-4">
                    @php
                        $totalSteps = count($mapStepsBefore) + count($mapStepsAfter);
                        $completedSteps = $mapApply->mapApplySteps->where('status', 'accepted')->count();
                        $progressPercentage = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;
                    @endphp

                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="fw-semibold">{{ __('ebps::ebps.overall_progress') }}</h6>
                        <span class="badge bg-primary rounded-pill">{{ $completedSteps }}/{{ $totalSteps }}
                            {{ __('ebps::ebps.steps') }}</span>
                    </div>

                    <div class="progress" style="height: 10px; border-radius: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar"
                            style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <!-- Before Filling Application Steps -->
                <div class="mb-5">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 40px; height: 40px;">
                                <i class="bx bx-list-check fs-5"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-0">{{ __('ebps::ebps.steps_before_filling_application') }}</h4>
                        </div>
                        
                        <!-- Approve All Steps Button -->
                        <livewire:ebps.approve_all_steps :mapApply="$mapApply" />
                    </div>

                    @php
                        $previousStepApproved = true;
                        $beforeStepsApproved = true; // Assume all are approved initially
                    @endphp

                    <div class="timeline-steps mb-4">
                        @foreach ($mapStepsBefore as $index => $mapStep)
                            @php
                                $appliedStep = $mapApply->mapApplySteps->where('map_step_id', $mapStep->id)->first();
                                $status = $appliedStep ? $appliedStep->status : __('ebps::ebps.not_applied');
                                $mapApplyStep = Src\Ebps\Models\MapApplyStep::where('map_step_id', $mapStep->id)
                                    ->where('map_apply_id', $mapApply->id)
                                    ->first();
                                $canApply = $previousStepApproved;
                                $previousStepApproved = $status == 'accepted';

                                // If any before step is not accepted, set $beforeStepsApproved to false
                                if ($status !== 'accepted') {
                                    $beforeStepsApproved = false;
                                }

                                // Set status colors and icons
                                $statusColors = [
                                    'accepted' => [
                                        'bg' => 'bg-success',
                                        'text' => 'text-success',
                                        'icon' => 'bx-check-circle',
                                    ],
                                    'pending' => [
                                        'bg' => 'bg-warning',
                                        'text' => 'text-warning',
                                        'icon' => 'bx-time',
                                    ],
                                    'rejected' => [
                                        'bg' => 'bg-danger',
                                        'text' => 'text-danger',
                                        'icon' => 'bx-x-circle',
                                    ],
                                    'Not Applied' => [
                                        'bg' => 'bg-secondary',
                                        'text' => 'text-secondary',
                                        'icon' => 'bx-help-circle',
                                    ],
                                ];

                                $statusColor = $statusColors[$status] ?? $statusColors['Not Applied'];
                            @endphp

                            <div class="timeline-step mb-3">
                                <div class="row g-0">
                                    <div class="col-auto">
                                        <div class="timeline-step-marker">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="{{ $statusColor['bg'] }} rounded-circle d-flex align-items-center justify-content-center text-white"
                                                    style="width: 50px; height: 50px; box-shadow: 0 0 0 5px rgba(var(--bs-primary-rgb), 0.1);">
                                                    <i class="bx {{ $statusColor['icon'] }} fs-4"></i>
                                                </div>
                                                @if ($index < count($mapStepsBefore) - 1)
                                                    <div class="timeline-step-line"
                                                        style="height: 40px; width: 2px; background-color: #e0e0e0; margin: 10px 0;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="card shadow-sm border-0 ms-3 h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h5 class="card-title fw-semibold mb-0">{{ $mapStep->title }}</h5>
                                                    <span
                                                        class="badge {{ $statusColor['bg'] }} rounded-pill px-3 py-2">
                                                        <i class="bx {{ $statusColor['icon'] }} me-1"></i>
                                                        {{ $status }}
                                                    </span>
                                                </div>

                                                @php

                                                    $submitterEnum = Src\Ebps\Enums\FormSubmitterEnum::tryFrom(
                                                        $mapStep->form_submitter,
                                                    );
                                                @endphp

                                                <p class="card-text text-muted small mb-3">
                                                    <i class="bx bx-user me-1"></i>
                                                    {{ __('ebps::ebps.submitter') }}:
                                                    {{ $submitterEnum ? $submitterEnum->label() : ucfirst($mapStep->form_submitter) }}
                                                </p>

                                                <div class="d-flex justify-content-end mt-2">
                                                    @if (isSuperAdmin())
                                                        <!-- Superadmin buttons - always visible -->
                                                        <a href="{{ route('admin.ebps.map_applies.apply-map-step', ['mapStep' => $mapStep->id, 'mapApply' => $mapApply]) }}"
                                                            class="btn btn-primary btn-sm me-2">
                                                            <i class="bx bx-edit me-1"></i>{{ __('ebps::ebps.apply') }}
                                                        </a>

                                                        <button
                                                            class="btn btn-outline-secondary btn-sm d-flex align-items-center me-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#documentEditModal{{ $mapStep->id }}">
                                                            <i class="bx bx-upload me-1"></i>
                                                            {{ __('ebps::ebps.upload') }}
                                                        </button>

                                                        @if ($mapApplyStep)
                                                            <a href="{{ route('admin.ebps.map_applies.preview-map-step', ['mapApplyStep' => $mapApplyStep]) }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="bx bx-show me-1"></i>{{ __('ebps::ebps.view') }}
                                                            </a>
                                                        @endif
                                                    @else
                                                        <!-- Regular user buttons - with role-based access control -->
                                                        @if ($status != 'accepted' || $isRoleFilteringEnabled)
                                                            <a href="{{ route('admin.ebps.map_applies.apply-map-step', ['mapStep' => $mapStep->id, 'mapApply' => $mapApply]) }}"
                                                                class="btn btn-primary btn-sm me-2">
                                                                <i class="bx bx-edit me-1"></i>{{ __('ebps::ebps.apply') }}
                                                            </a>
                                                        @endif

                                                        @if ($mapApplyStep)
                                                            <a href="{{ route('admin.ebps.map_applies.preview-map-step', ['mapApplyStep' => $mapApplyStep]) }}"
                                                                class="btn btn-outline-primary btn-sm me-2">
                                                                <i class="bx bx-show me-1"></i>{{ __('ebps::ebps.view') }}
                                                            </a>
                                                        @endif

                                                        @if ($status != 'Not Applied' && $status != 'accepted' && $canApply)
                                                            <button
                                                                class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#documentEditModal{{ $mapStep->id }}">
                                                                <i class="bx bx-upload me-1"></i>
                                                                {{ __('ebps::ebps.upload') }}
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="documentEditModal{{ $mapStep->id }}" tabindex="-1"
                                aria-labelledby="documentEditModalLabel{{ $mapStep->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <livewire:ebps.ebps_upload_file :mapStep="$mapStep" :mapApply="$mapApply" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- After Filling Application Steps -->
                <div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="bx bx-file-find fs-5"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-0">{{ __('ebps::ebps.steps_after_filling_application') }}</h4>
                    </div>

                    @php
                        $previousStepApproved = $beforeStepsApproved; // Enable only if all before steps are accepted
                    @endphp

                    <div class="timeline-steps">
                        @foreach ($mapStepsAfter as $index => $mapStep)
                            @php
                                $appliedStep = $mapApply->mapApplySteps->where('map_step_id', $mapStep->id)->first();
                                $status = $appliedStep ? $appliedStep->status : __('ebps::ebps.not_applied');
                                $mapApplyStep = Src\Ebps\Models\MapApplyStep::where('map_step_id', $mapStep->id)
                                    ->where('map_apply_id', $mapApply->id)
                                    ->first();
                                $canApply = $previousStepApproved;
                                $previousStepApproved = $status == 'accepted';

                                // Set status colors and icons
                                $statusColors = [
                                    'accepted' => [
                                        'bg' => 'bg-success',
                                        'text' => 'text-success',
                                        'icon' => 'bx-check-circle',
                                    ],
                                    'pending' => [
                                        'bg' => 'bg-warning',
                                        'text' => 'text-warning',
                                        'icon' => 'bx-time',
                                    ],
                                    'rejected' => [
                                        'bg' => 'bg-danger',
                                        'text' => 'text-danger',
                                        'icon' => 'bx-x-circle',
                                    ],
                                    'Not Applied' => [
                                        'bg' => 'bg-secondary',
                                        'text' => 'text-secondary',
                                        'icon' => 'bx-help-circle',
                                    ],
                                ];

                                $statusColor = $statusColors[$status] ?? $statusColors['Not Applied'];

                                // If before steps are not all approved, show disabled state
                                $isDisabled = !$beforeStepsApproved && $status === 'Not Applied';
                            @endphp

                            <div class="timeline-step mb-3 {{ $isDisabled ? 'opacity-50' : '' }}">
                                <div class="row g-0">
                                    <div class="col-auto">
                                        <div class="timeline-step-marker">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="{{ $isDisabled ? 'bg-secondary' : $statusColor['bg'] }} rounded-circle d-flex align-items-center justify-content-center text-white"
                                                    style="width: 50px; height: 50px; box-shadow: 0 0 0 5px rgba(var(--bs-primary-rgb), 0.1);">
                                                    <i
                                                        class="bx {{ $isDisabled ? 'bx-lock' : $statusColor['icon'] }} fs-4"></i>
                                                </div>
                                                @if ($index < count($mapStepsAfter) - 1)
                                                    <div class="timeline-step-line"
                                                        style="height: 40px; width: 2px; background-color: #e0e0e0; margin: 10px 0;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="card shadow-sm border-0 ms-3 h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h5 class="card-title fw-semibold mb-0">{{ $mapStep->title }}</h5>
                                                    <span
                                                        class="badge {{ $isDisabled ? 'bg-secondary' : $statusColor['bg'] }} rounded-pill px-3 py-2">
                                                        <i
                                                            class="bx {{ $isDisabled ? 'bx-lock' : $statusColor['icon'] }} me-1"></i>
                                                        {{ $isDisabled ? __('ebps::ebps.locked') : $status }}
                                                    </span>
                                                </div>

                                                <p class="card-text text-muted small mb-3">
                                                    <i class="bx bx-user me-1"></i>
                                                    {{ __('ebps::ebps.submitter') }}:
                                                    {{ ucfirst($mapStep->form_submitter) }}
                                                </p>

                                                <div class="d-flex justify-content-end mt-2">
                                                    @if (isSuperAdmin())
                                                        <!-- Superadmin buttons - always visible -->
                                                        @if ($status !== 'accepted' && $canApply)
                                                            <a href="{{ route('admin.ebps.map_applies.apply-map-step', ['mapStep' => $mapStep->id, 'mapApply' => $mapApply]) }}"
                                                                class="btn btn-primary btn-sm me-2">
                                                                <i class="bx bx-edit me-1"></i>{{ __('ebps::ebps.apply') }}
                                                            </a>
                                                        @endif

                                                        @if ($mapApplyStep)
                                                            <a href="{{ route('admin.ebps.map_applies.preview-map-step', ['mapApplyStep' => $mapApplyStep]) }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="bx bx-show me-1"></i>{{ __('ebps::ebps.view') }}
                                                            </a>
                                                        @endif

                                                        @if ($status != 'Not Applied' && $status != 'accepted' && $canApply)
                                                            <button
                                                                class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#documentEditModal{{ $mapStep->id }}">
                                                                <i class="bx bx-upload me-1"></i>
                                                                {{ __('ebps::ebps.upload') }}
                                                            </button>
                                                        @endif
                                                    @else
                                                        <!-- Regular user buttons - with role-based access control -->
                                                        @if ($status !== 'accepted' && $canApply)
                                                            <a href="{{ route('admin.ebps.map_applies.apply-map-step', ['mapStep' => $mapStep->id, 'mapApply' => $mapApply]) }}"
                                                                class="btn btn-primary btn-sm me-2">
                                                                <i class="bx bx-edit me-1"></i>{{ __('ebps::ebps.apply') }}
                                                            </a>
                                                        @endif

                                                        @if ($mapApplyStep)
                                                            <a href="{{ route('admin.ebps.map_applies.preview-map-step', ['mapApplyStep' => $mapApplyStep]) }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="bx bx-show me-1"></i>{{ __('ebps::ebps.view') }}
                                                            </a>
                                                        @endif

                                                        @if ($status != 'Not Applied' && $status != 'accepted' && $canApply)
                                                            <button
                                                                class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#documentEditModal{{ $mapStep->id }}">
                                                                <i class="bx bx-upload me-1"></i>
                                                                {{ __('ebps::ebps.upload') }}
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="documentEditModal1" tabindex="-1"
                                aria-labelledby="documentEditModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <livewire:ebps.ebps_upload_file :$mapStep :$mapApply />
                                </div>
                            </div>

                            <div class="modal fade" id="documentEditModal{{ $mapStep->id }}" tabindex="-1"
                                aria-labelledby="documentEditModalLabel{{ $mapStep->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <livewire:ebps.ebps_upload_file :mapStep="$mapStep" :mapApply="$mapApply" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (!$beforeStepsApproved)
                        <div class="alert alert-warning mt-4">
                            <div class="d-flex">
                                <i class="bx bx-info-circle fs-4 me-2"></i>
                                <div>
                                    <h6 class="alert-heading fw-bold mb-1">
                                        {{ __('ebps::ebps.complete_previous_steps') }}</h6>
                                    <p class="mb-0">
                                        {{ __('ebps::ebps.you_need_to_complete_all_steps_in_the_before_filling_application_section_before_proceeding_to_these_steps') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline-step {
            position: relative;
        }

        .timeline-step-marker {
            position: relative;
            z-index: 1;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .badge {
            font-weight: 500;
        }
    </style>
</x-layout.app>
