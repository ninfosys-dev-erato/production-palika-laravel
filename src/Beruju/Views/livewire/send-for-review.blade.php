<div>
	<form wire:submit.prevent="send">
		<div class="mb-3">
			<label for="remarks" class="form-label">{{ __('beruju::beruju.remarks') }} <span class="text-danger">*</span></label>
			<textarea id="remarks" rows="3" wire:model="remarks" class="form-control rounded-0 @error('remarks') is-invalid @enderror" placeholder="{{ __('beruju::beruju.enter_remarks_for_reviewer') }}"></textarea>
			@error('remarks')
				<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="d-flex justify-content-end gap-2">
			<button type="button" wire:click="$dispatch('close-modal')" class="btn btn-secondary rounded-0">{{ __('beruju::beruju.cancel') }}</button>
			<button type="submit" class="btn btn-primary rounded-0">{{ __('beruju::beruju.send_for_review') }}</button>
		</div>
	</form>
</div>


