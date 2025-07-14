<div class="div">
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
</div>
