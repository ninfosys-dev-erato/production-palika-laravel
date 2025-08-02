<x-layout.app header="Permission List">

    <div class="card">

        <div class="card-header d-flex justify-content-between">
            <h5 class="text-primary fw-bold">{{ __('Permission') }} {{ __('List') }}</h5>
            @perm('permissions create')
                <div>
                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                        {{ __('Add') }} {{ __('Permission') }}</a>
                </div>
            @endperm

        </div>
        <div class="card-body">
            <livewire:permissions.permission_table theme="bootstrap-4" />
        </div>
    </div>
</x-layout.app>
