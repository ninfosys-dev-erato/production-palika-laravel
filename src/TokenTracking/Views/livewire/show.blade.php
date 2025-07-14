<div class="container mt-4">
    <!-- Header Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h4 class="text-primary fw-bold mb-0">
                <i class="bx bx-detail me-2"></i>{{__('tokentracking::tokentracking.token_details')}}
            </h4>
            <div>
                <a href="javascript:history.back()" class="btn btn-primary">
                    <i class="bx bx-arrow-back"></i> {{ __('tokentracking::tokentracking.back') }}
                </a>

                @if ($registerToken->stage ===  Src\TokenTracking\Enums\TokenStageEnum::ENTRY->value)
                    <a href="{{ route('admin.register_tokens.edit', $registerToken->id) }}" class="btn btn-primary ms-2">
                        <i class="bx bx-edit"></i> {{ __('tokentracking::tokentracking.edit') }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Basic Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="t{__{('')}}ext-primary fw-semibold mb-4">
                        <i class="bx bx-info-circle me-2"></i>{{__('tokentracking::tokentracking.basic_information')}}
                    </h5>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-hash text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.token')}}</span>
                        </div>
                        <p class="fw-medium fs-5 ms-4">{{ $registerToken->token }}</p>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-target-lock text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.purpose')}}</span>
                        </div>
                        <p class="fw-medium ms-4">{{ $registerToken->token_purpose->label() ?? 'Unknown' }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-calendar text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.fiscal_year')}}</span>
                        </div>
                        <p class="fw-medium ms-4">{{ $registerToken->fiscal_year }}</p>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-calendar-event text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.date')}}</span>
                        </div>
                        <p class="fw-medium ms-4">{{ $registerToken->date }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status and Stage (Moved to second position) -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="text-primary fw-semibold mb-4">
                        <i class="bx bx-slider-alt me-2"></i>{{__('tokentracking::tokentracking.status_controls')}}
                    </h5>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bx bx-loader-circle text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.stage')}}</span>
                        </div>
                        <div class="ms-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="flex-grow-1">
                                    <select wire:model="registerToken.stage" class="form-select fw-medium text-dark"
                                        wire:change="isStageChange">
                                        @foreach (\Src\TokenTracking\Enums\TokenStageEnum::cases() as $case)
                                        <option value="{{ $case->value }}"
                                            {{ $registerToken->stage == $case->value ? 'selected' : '' }}>
                                            {{ __($case->name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn rounded-pill btn-icon btn-outline-success"
                                    wire:click="updateStage">
                                    <span class="tf-icons bx bx-check"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bx bx-toggle-left text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.status')}}</span>
                        </div>
                        <div class="ms-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="flex-grow-1">
                                    <select wire:model="registerToken.status" class="form-select fw-medium text-dark"
                                        wire:change="isStageChange">
                                        @foreach (\Src\TokenTracking\Enums\TokenStatusEnum::cases() as $case)
                                        <option value="{{ $case->value }}"
                                            {{ $registerToken->status == $case->value ? 'selected' : '' }}>
                                            {{ __($case->name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn rounded-pill btn-icon btn-outline-success"
                                    wire:click="updateStatus">
                                    <span class="tf-icons bx bx-check"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Time Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="text-primary fw-semibold mb-4">
                        <i class="bx bx-time me-2"></i>{{__('tokentracking::tokentracking.time_information')}}
                    </h5>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-time-five text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.entry_time')}}</span>
                        </div>
                        <p class="fw-medium ms-4">{{ $registerToken->entry_time }}</p>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-exit text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.exit_time')}}</span>
                        </div>
                        <p class="fw-medium ms-4">{{ $registerToken->exit_time ?? 'Not exited yet' }}</p>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-time text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.estimated_time')}}</span>
                        </div>
                        <p class="fw-medium ms-4">{{ $registerToken->estimated_time }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branch Information (Moved to fourth position) -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="text-primary fw-semibold mb-4">
                        <i class="bx bx-git-branch me-2"></i>{{__('tokentracking::tokentracking.branch_information')}}
                    </h5>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-git-branch text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.current_branch')}}</span>
                        </div>
                        <p class="fw-medium ms-4">{{ $registerToken->currentBranch->title }}</p>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-git-repo-forked text-primary me-2 fs-5"></i>
                            <span class="text-muted">{{__('tokentracking::tokentracking.all_branches')}}</span>
                        </div>
                        <div class="ms-4">

                                <span
                                    class="badge bg-primary rounded-pill me-1 mb-1 px-3 py-2">{{ $registerToken->getBranchFlowString() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('refresh', () => {
        window.location.reload();
    });
</script>
@endscript
