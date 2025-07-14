<x-layout.app header="User List">
    <div class="card">

        <div class="card-header d-flex justify-content-between">
            <h5 class="text-primary fw-bold">{{ __('Users for Ward ' . $id) }}</h5>
            <div>
                @perm('users_create')
                    <a href="{{ route('admin.users.create', ['selectedward' => $id]) }}" class="btn btn-info"><i
                            class="bx bx-plus"></i>
                        {{ __('wards::wards.add_users') }}</a>
                    {{-- <a href="{{ route('admin.wards.adduser', ['selectedward' => $id]) }}" class="btn btn-info"><i
                            class="bx bx-plus"></i>
                        {{ __('wards::wards.add_users') }}</a> --}}
                @endperm
            </div>

        </div>
        <div class="card-body">
            <livewire:wards.user_table :$id theme="bootstrap-4" />
        </div>
    </div>
</x-layout.app>
