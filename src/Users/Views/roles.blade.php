<x-layout.app header="User Role Manage">
    <div class="card">

        <div class="card-header d-flex justify-content-between">
            <h3>User Role Manage</h3>

        </div>
        <div class="card-body">
            <livewire:users.user_roles :$user />
        </div>
    </div>
</x-layout.app>
