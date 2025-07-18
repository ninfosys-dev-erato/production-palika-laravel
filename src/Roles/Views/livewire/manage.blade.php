<div class="div">
    @foreach ($roles as $role)
        @if ($role->name !== 'super-admin')
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center"
                    onclick="toggleCollapse('permissions-{{ $role->id }}')" style="cursor: pointer;">
                    <strong>{{ ucwords($role->name) }}</strong>
                    <i class="bx bx-chevron-down"></i>
                </div>

                <div id="permissions-{{ $role->id }}" class="collapse" wire:ignore.self>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-4">
                                    <div
                                        class="custom-control custom-switch custom-switch-off-grey custom-switch-on-success">
                                        <input class="custom-control-input" id="{{ $role->id . '_' . $permission->id }}"
                                            type="checkbox"
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                            value="{{ $role->id . '_' . $permission->id }}"
                                            wire:change="updatePermission('{{ $role->id }}', '{{ $permission->id }}', $event.target.checked)">
                                        <label class="custom-control-label"
                                            for="{{ $role->id . '_' . $permission->id }}">{{ ucwords(str_replace('_', ' ', $permission->name)) }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

<script>
    function toggleCollapse(id) {
        const element = document.getElementById(id);
        element.classList.toggle('show');
    }
</script>
