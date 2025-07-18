<form wire:submit.prevent="search">

    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="divider divider-primary text-start text-primary fw-bold mx-4 mb-0">
                <div class="divider-text fs-4">{{ __('tokentracking::tokentracking.search') }}</div>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <!-- Input Fields -->
                    <div class="col-md col-12">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-key"></i>
                            </span>
                            <input type="text" class="form-control border-start-0"
                                placeholder="{{ __('tokentracking::tokentracking.enter_a_token') }}" wire:model="token">
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-user"></i>
                            </span>
                            <input type="number" class="form-control border-start-0"
                                placeholder="{{ __('tokentracking::tokentracking.enter_customer_number') }}"
                                wire:model="customer">
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="startDate" id="start_date"
                                class=" nepali-date form-control border-start-0"
                                placeholder="{{ __('tokentracking::tokentracking.start_date') }}">
                            {{-- <input type="date" class="form-control border-start-0" placeholder="Enter starting date"
                                wire:model="startDate"> --}}
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <div class="input-group">
                            <span class="input-group-text bg-warning text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="endDate" id="end_date"
                                class="nepali-date form-control border-start-0"
                                placeholder="{{ __('tokentracking::tokentracking.end_date') }}">
                        </div>
                    </div>


                    <!-- Buttons Group -->
                    <div class="col-md-auto col-12">
                        <div class="d-flex gap-2 justify-content-end w-100">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bx bx-search me-1"></i> {{ __('tokentracking::tokentracking.search') }}
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" wire:click="clear">
                                <i class="bx bx-x-circle me-1"></i> {{ __('tokentracking::tokentracking.clear') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($registerTokenData)
        @foreach ($registerTokenData as $token)
            <div class="container mt-4">
                <div class="card mx-auto shadow">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white py-3 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white">
                                <i class="bx bx-id-card me-2"></i>
                                {{ __('tokentracking::tokentracking.token_holder_details') }}
                            </h5>
                            <span class="badge bg-light text-primary fs-6">{{ $token->token }}</span>
                        </div>
                    </div>
                    <!-- Card Body -->


                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fs-6 fw-semibold">{{ __('tokentracking::tokentracking.name') }}</small>
                                    <div class="fw-medium text-dark">
                                        <i class="bx bx-user me-1"></i> {{ $token->tokenHolder->name ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.email') }}</small>
                                    <div class="fw-medium text-dark">
                                        <i class="bx bx-envelope me-1"></i>
                                        {{ $token->tokenHolder->email ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.mobile_no') }}</small>
                                    <div class="fw-medium text-dark">
                                        <i class="bx bx-phone me-1"></i>
                                        {{ $token->tokenHolder->mobile_no ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.address') }}</small>
                                    <div class="fw-medium text-dark">
                                        <i class="bx bx-map me-1"></i> {{ $token->tokenHolder->address ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr> <!-- Divider Line -->

                        <!-- Token Details -->


                        <div class="row mt-3">
                            <h5 class="text-primary"><i class="bx bx-key me-2"></i>
                                {{ __('tokentracking::tokentracking.token_details') }}</h5>

                            <!-- First Row: Purpose, Fiscal Year, Current Branch -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.purpose') }}</small>
                                    <div class="fw-medium text-dark">
                                        <i class="bx bx-flag me-1"></i>
                                        {{ $token->token_purpose ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.fiscal_year') }}</small>
                                    <div class="fw-medium text-dark">
                                        <i class="bx bx-calendar me-1"></i>
                                        {{ $token->fiscal_year ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.current_branch') }}</small>
                                    <div class="fw-medium text-dark">
                                        <i class="bx bx-building me-1"></i>
                                        {{ $token->currentBranch->title ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Second Row: Entry Time, Exit Time, Estimated Time -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.entry_time') }}</small>
                                    <div class="fw-medium text-dark">
                                        <i class="bx bx-time-five text-success me-1"></i>
                                        {{ $token->entry_time ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.exit_time') }}</small>
                                    <div class="fw-medium text-dark">
                                        <i class="bx bx-time text-danger me-1"></i>
                                        {{ $token->exit_time ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.estimated_time') }}</small>
                                    <div class="fw-medium text-dark">
                                        <i class="bx bx-hourglass text-warning me-1"></i>
                                        {{ $token->estimated_time ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Third Row: Status, Stage -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.stage') }}</small>
                                    <select wire:model="stages.{{ $token->id }}"
                                        class="form-select fw-medium text-dark"
                                        wire:change="stageChange({{ $token->id }})">
                                        @foreach (\Src\TokenTracking\Enums\TokenStageEnum::cases() as $case)
                                            <option value="{{ $case->value }}"
                                                {{ $token->stage == $case->value ? 'selected' : '' }}>
                                                {{ __($case->name) }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small
                                        class="text-secondary fw-semibold fs-6">{{ __('tokentracking::tokentracking.status') }}</small>
                                    <select wire:model="statuses.{{ $token->id }}"
                                        class="form-select fw-medium text-dark">
                                        @foreach (\Src\TokenTracking\Enums\TokenStatusEnum::cases() as $case)
                                            <option value="{{ $case->value }}"
                                                {{ $token->status == $case->value ? 'selected' : '' }}>
                                                {{ __($case->name) }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">

                            <button type="button" class="btn btn-primary btn-lg w-25"
                                wire:click="updateToken({{ $token->id }})">
                                <i class="bx bx-save me-2"></i>
                                {{ __('tokentracking::tokentracking.update_token_holder') }}


                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="container mt-4">
            <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                style="height: 200px;">
                <h5 class="text-center">{{ __('tokentracking::tokentracking.no_data_to_show') }}</h5>

                @error('startDate')
                    <small class="text-danger">{{ __($message) }}</small>
                @enderror

                @error('endDate')
                    <small class="text-danger">{{ __($message) }}</small>
                @enderror
            </div>
        </div>

    @endif
</form>
