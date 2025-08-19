<div>
    @if(!$latestCycle)
        <div class="text-center py-4">
            <p class="text-muted">{{ __('beruju::beruju.no_active_resolution_cycle') }}</p>
            <p class="text-muted">{{ __('beruju::beruju.assign_resolution_cycle_first') }}</p>
        </div>
    @else
        <form wire:submit="save">
            <div class="row">
                <!-- Incharge Info (Display Only) -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('beruju::beruju.incharge') }}</label>
                    <div class="form-control-plaintext">
                        @if($latestCycle && $latestCycle->incharge)
                            <strong>{{ $latestCycle->incharge->name }}</strong>
                        @else
                            <span class="text-muted">{{ __('beruju::beruju.no_incharge_assigned') }}</span>
                        @endif
                    </div>
                </div>

            <!-- Action Type Selection -->
            <div class="col-md-6 mb-3">
                <label for="action_type_id" class="form-label">{{ __('beruju::beruju.action_type') }} <span class="text-danger">*</span></label>
                <select wire:model="berujuAction.action_type_id" id="action_type_id" class="form-select @error('berujuAction.action_type_id') is-invalid @enderror">
                    <option value="">{{ __('beruju::beruju.select_action_type') }}</option>
                    @foreach($actionTypes as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('berujuAction.action_type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <!-- Status Selection -->
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">{{ __('beruju::beruju.status') }} <span class="text-danger">*</span></label>
                <select wire:model="berujuAction.status" id="status" class="form-select @error('berujuAction.status') is-invalid @enderror">
                    <option value="Pending">{{ __('beruju::beruju.pending') }}</option>
                    <option value="Completed">{{ __('beruju::beruju.completed') }}</option>
                    <option value="Rejected">{{ __('beruju::beruju.rejected') }}</option>
                </select>
                @error('berujuAction.status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


        </div>

        <!-- Remarks -->
        <div class="row">
            <div class="col-12 mb-3">
                <label for="remarks" class="form-label">{{ __('beruju::beruju.remarks') }}</label>
                <textarea wire:model="berujuAction.remarks" id="remarks" rows="3" 
                          class="form-control @error('berujuAction.remarks') is-invalid @enderror"
                          placeholder="{{ __('beruju::beruju.enter_remarks') }}"></textarea>
                @error('berujuAction.remarks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-end gap-2">
            <button type="button" wire:click="resetAction" class="btn btn-secondary">
                {{ __('beruju::beruju.reset') }}
            </button>
            <button type="submit" class="btn btn-primary">
                @if($action === 'create')
                    {{ __('beruju::beruju.create') }}
                @else
                    {{ __('beruju::beruju.update') }}
                @endif
            </button>
        </div>
        </form>
    @endif
</div>
