<div class="div">
    <h5 class="text-primary fw-bold mb-0">{{ __('users::users.assigned_roles') }}</h5>

    <div class="row">
        @foreach ($roles as $role)
            <div class="col-md-3">
                <div class="form-check mt-3 me-3">
                    <input class="form-check-input" type="checkbox" value="" id="{{ $role->id }}"
                        {{ $user->hasRole($role->name) ? 'checked' : '' }}
                        wire:change="toggleRole('{{ $role->id }}', '{{ $user->id }}', $event.target.checked)">
                    <label class="form-check-label" for="{{ $role->id }}">
                        {{ ucwords(str_replace('_', ' ', $role->name)) }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>
