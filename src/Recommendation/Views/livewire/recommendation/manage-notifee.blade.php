<div class="div">
    <h5 class="text-primary fw-bold mb-0">{{ __('recommendation::recommendation.notifiees') }}</h5>
    <div class="row mb-4">
        @foreach ($roles as $role)
            <div class="col-md-3">
                <div class="form-check mt-3 me-3">
                    <input type="checkbox" class="form-check-input" id="{{ $role->id }}" value="{{ $role->id }}"
                        wire:model="selectedRoles">
                    <label class="form-check-label" for="{{ $role->id }}">
                        {{ ucwords(str_replace('_', ' ', $role->name)) }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
    <button wire:click="syncRoles" class="btn btn-primary">{{ __('recommendation::recommendation.save') }}</button>
</div>
