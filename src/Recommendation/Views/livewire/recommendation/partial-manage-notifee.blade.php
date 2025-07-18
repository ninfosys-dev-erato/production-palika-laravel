<div class="div">
    <h6 class="mt-1">{{ __('recommendation::recommendation.assign_notifiees') }}</h6>
    <div class="row">
        @foreach ($roles as $role)
            <div class="col-md-3">
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="{{ $role->id }}" value="{{ $role->id }}"
                        wire:model="selectedRoles">
                    <label class="form-check-label"
                        for="{{ $role->id }}">{{ ucwords(str_replace('_', ' ', $role->name)) }}</label>
                </div>
            </div>
        @endforeach
    </div>
</div>