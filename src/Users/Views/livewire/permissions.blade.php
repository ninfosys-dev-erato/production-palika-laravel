<div>
    <h5 class="text-primary fw-bold mb-3">{{ __('users::users.assigned_permission') }}</h5>

    @foreach ($permissions as $moduleName => $modulePermissions)
        <div class="mb-4">
            <h6 class="fw-bold mb-2" style="color: #01399A; font-size: 1.1rem; text-transform: capitalize;">
                {{ ucwords($moduleName) }}
            </h6>

            <div class="row">
                @foreach ($modulePermissions as $permission)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="{{ $permission['id'] }}"
                                {{ $user->hasPermissionTo($permission['name']) ? 'checked' : '' }}
                                wire:change="togglePermission('{{ $permission['id'] }}', '{{ $user->id }}')">
                            <label class="form-check-label" for="{{ $permission['id'] }}" style="font-size: 0.95rem;">
                                {{ ucwords(str_replace('_', ' ', $permission['name'])) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr style="border-color: #ddd; margin-top: 10px;">
        </div>
    @endforeach
</div>
