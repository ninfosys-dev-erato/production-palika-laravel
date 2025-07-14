<x-layout.app header="User List">

    <div class="card">

        <div class="card-header d-flex justify-content-between">
            <h5 class="text-primary fw-bold">{{ __('users::users.users') }}</h5>
            <div>
                @perm('users_create')
                    <a href="{{ route('admin.users.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                        {{ __('users::users.add_users') }}</a>
                @endperm
            </div>

        </div>
        <div class="card-body">
            <livewire:users.user_table theme="bootstrap-4" />
        </div>
    </div>
</x-layout.app>
