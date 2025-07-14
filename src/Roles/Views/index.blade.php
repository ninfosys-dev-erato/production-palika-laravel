<x-layout.app header="Role List">

    <div class="card">

        <div class="card-header d-flex justify-content-between">
            <h5 class="text-primary fw-bold">{{ __('Role List') }}</h5>
            <div>
                @perm('roles_create')
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                        {{ __('Add Roles') }}</a>
                @endperm
                @perm('roles_manage')
                    <a href="{{ route('admin.roles.manage') }}" class="btn btn-info"><i class="bx bx-cog"></i>
                        {{ __('Manage Roles') }}</a><br>
                @endperm
            </div>

        </div>
        <div class="card-body">
            <livewire:roles.role_table theme="bootstrap-4" />
        </div>
    </div>
</x-layout.app>
