<x-layout.app header="User Permissions Manage">
    <div class="card">

        <div class="card-header">
            <strong>{{ $user->name }}</strong>
            <p>{{ $user->email }}</p> <br> {!! $user->active ? '<p class="text-success">Active</p>' : '<p class="text-danger">In-Active</p>' !!}
            <br>
            <small>Note: If a user is subscribed to a role, the permissions within that role are granted
                automatically and cannot be removed from here. Additionally, to perform actions like editing,
                deleting, or accessing any other permissions within a module, you must first have permission to view
                that module. This ensures that access is granted only to authorized users.</small>
        </div>

        <div class="card-body">
            <livewire:users.user_permissions :$user />
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.users.index') }}" class="btn btn-danger">Back</a>
        </div>
    </div>
</x-layout.app>
