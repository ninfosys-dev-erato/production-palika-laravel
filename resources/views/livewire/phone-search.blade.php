<div class="mb-4">
    <label for="phone" class="form-label fw-bold fs-7 d-block">{{ __('Search User By Phone Number') }}</label>
    <div class="input-group">
        <input type="text" class="form-control" id="phone" wire:model.defer="phone"
            placeholder={{ __('Enter phone number') }} aria-label="Phone number" aria-describedby="button-addon2"
            wire:keydown="search">
        <button class="btn btn-outline-primary" type="button" wire:click.prevent="search">
            {{ __('Search') }}
        </button>
    </div>
    @error('phone')
        <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>
