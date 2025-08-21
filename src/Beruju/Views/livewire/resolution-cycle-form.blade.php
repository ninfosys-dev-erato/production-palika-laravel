<div>
    <form wire:submit="save">
        <div class="row">
            <!-- Incharge Selection -->
            <div class="col-md-6 mb-3">
                <label for="incharge_id" class="form-label">{{ __('beruju::beruju.incharge') }} <span class="text-danger">*</span></label>
                <select wire:model="resolutionCycle.incharge_id" id="incharge_id" class="form-select rounded-0 @error('resolutionCycle.incharge_id') is-invalid @enderror">
                    <option value="">{{ __('beruju::beruju.select_incharge') }}</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('resolutionCycle.incharge_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remarks -->
            <div class="col-md-6 mb-3">
                <label for="remarks" class="form-label">{{ __('beruju::beruju.remarks') }}</label>
                <textarea wire:model="resolutionCycle.remarks" id="remarks" rows="3" 
                          class="form-control rounded-0 @error('resolutionCycle.remarks') is-invalid @enderror"
                          placeholder="{{ __('beruju::beruju.enter_remarks') }}"></textarea>
                @error('resolutionCycle.remarks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary rounded-0" wire:click="resetResolutionCycle">
                {{ __('beruju::beruju.reset') }}
            </button>
            <button type="submit" class="btn btn-primary rounded-0">
                @if($action === \App\Enums\Action::CREATE)
                    {{ __('beruju::beruju.assign') }}
                @else
                    {{ __('beruju::beruju.update_resolution_cycle') }}
                @endif
            </button>
        </div>
    </form>
</div>
