<div>
	<form wire:submit.prevent="submit">
		<div class="mb-3">
			<label class="form-label d-block">{{ __('beruju::beruju.decision') }} <span class="text-danger">*</span></label>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" id="decision-approved" value="approved" wire:model="decision">
				<label class="form-check-label" for="decision-approved">{{ __('beruju::beruju.approved') }}</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" id="decision-rejected" value="rejected" wire:model="decision">
				<label class="form-check-label" for="decision-rejected">{{ __('beruju::beruju.rejected') }}</label>
			</div>
			@error('decision')
				<div class="text-danger small">{{ $message }}</div>
			@enderror
		</div>

		<div class="mb-3">
			<label for="review-remarks" class="form-label">{{ __('beruju::beruju.remarks') }}</label>
			<textarea id="review-remarks" rows="3" wire:model="remarks" class="form-control rounded-0 @error('remarks') is-invalid @enderror" placeholder="{{ __('beruju::beruju.enter_remarks') }}">
			</textarea>
			@error('remarks')
				<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="d-flex justify-content-end gap-2">
			<button type="button" wire:click="$dispatch('close-modal')" class="btn btn-secondary rounded-0">{{ __('beruju::beruju.cancel') }}</button>
			<button type="submit" class="btn btn-primary rounded-0">{{ __('beruju::beruju.submit_review') }}</button>
		</div>
	</form>
</div>


