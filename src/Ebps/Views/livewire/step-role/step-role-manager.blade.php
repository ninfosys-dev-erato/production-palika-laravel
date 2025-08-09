<div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ __('ebps::ebps.manage_step_roles') }} - {{ $mapStep->title }}</h5>
        </div>
        <div class="card-body">
           
            <form wire:submit.prevent="save">
                <!-- Form Submitter Information -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('ebps::ebps.form_submitter') }}</label>
                        <input type="text" class="form-control" value="{{ $mapStep->form_submitter }}" readonly>
                        <small class="text-muted">
                            @if($mapStep->form_submitter === 'Palika')
                                {{ __('ebps::ebps.submitter_roles_required') }}
                            @else
                                {{ __('ebps::ebps.no_submitter_roles_needed') }}
                            @endif
                        </small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('ebps::ebps.application_type') }}</label>
                        <input type="text" class="form-control" value="{{ $mapStep->application_type }}" readonly>
                    </div>
                </div>

                <!-- Submitter Roles Section -->
                @if($showSubmitterRoles)
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-bold">{{ __('ebps::ebps.submitter_roles') }}</label>
                            <button type="button" class="btn btn-sm btn-info" wire:click="addSubmitterRole">
                                <i class="bx bx-plus"></i> {{ __('ebps::ebps.add_submitter_role') }}
                            </button>
                        </div>
                        
                        @if(empty($submitterRoleIds))
                            <p class="text-muted">{{ __('ebps::ebps.no_submitter_roles_assigned') }}</p>
                        @else
                            @foreach($submitterRoleIds as $index => $roleId)
                            <div class="row mb-2" wire:key="submitter-{{ $index }}">
                                <div class="col-md-8">
                                    <select wire:model="submitterRoleIds.{{ $index }}" class="form-control">
                                        <option value="">{{ __('ebps::ebps.select_role') }}</option>
                                        @foreach($availableRoles as $role)
                                            <option value="{{ $role['id'] }}">
                                                {{ $role['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("submitterRoleIds.{$index}")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                   
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-sm btn-danger" wire:click="removeSubmitterRole({{ $index }})">
                                        <i class="bx bx-trash"></i> {{ __('ebps::ebps.remove') }}
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif

                <!-- Approver Roles Section -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-bold">{{ __('ebps::ebps.approver_roles') }}</label>
                            <button type="button" class="btn btn-sm btn-info" wire:click="addApproverRole">
                                <i class="bx bx-plus"></i> {{ __('ebps::ebps.add_approver_role') }}
                            </button>
                        </div>
                        
                        @if(empty($approverRoleIds))
                            <p class="text-muted">{{ __('ebps::ebps.no_approver_roles_assigned') }}</p>
                        @else
                            @foreach($approverRoleIds as $index => $roleId)
                            <div class="row mb-2" wire:key="approver-{{ $index }}">
                                <div class="col-md-8">
                                    <select wire:model="approverRoleIds.{{ $index }}" class="form-control">
                                        <option value="">{{ __('ebps::ebps.select_role') }}</option>
                                        @foreach($availableRoles as $role)
                                            <option value="{{ $role['id'] }}">
                                                {{ $role['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("approverRoleIds.{$index}")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @if(config('app.debug'))
                                        <small class="text-muted">Current value: {{ $roleId ?? 'null' }}</small>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-sm btn-danger" wire:click="removeApproverRole({{ $index }})">
                                        <i class="bx bx-trash"></i> {{ __('ebps::ebps.remove') }}
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Save Button -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> {{ __('ebps::ebps.save_changes') }}
                        </button>
                        <a href="{{ route('admin.ebps.map_steps.index') }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 