<x-layout.app header="Permission Form">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold mb-0">
                {{ $action->value === 'create' ? __('Create Permission') : __('Update Permission') }}</h5>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('Permission') }} {{ __('List') }}</a>
        </div>
        <div class="card-body">

            @if (isset($permission))
                <livewire:permissions.permission_form :$action :$permission />
            @else
                <livewire:permissions.permission_form :$action />
            @endif
        </div>
    </div>
</x-layout.app>
