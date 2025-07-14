<x-layout.app header="Role Form">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold mb-0">
                {{ $action->value === 'create' ? __('Add Roles') : __('Update Role') }}</h5>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('Permission') }} {{ __('List') }}</a>
        </div>
        <div class="card-body">
                @if (isset($role))
                    <livewire:roles.role_form :$action :$role />
                @else
                    <livewire:roles.role_form :$action />
                @endif
        </div>
    </div>
</x-layout.app>
