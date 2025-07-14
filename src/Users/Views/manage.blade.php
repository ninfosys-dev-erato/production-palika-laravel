<x-layout.app header="User List">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold mb-0">{{ __('users::users.manage_user') }}</h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-info"><i
                class="bx bx-list-ul"></i>{{ __('users::users.user_list') }}</a>
    </div>
    <div class="nav-align-left mb-6">
        <ul class="nav nav-pills me-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-home" aria-controls="navs-pills-home" aria-selected="true">
                    {{ __('users::users.user_details') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-roles" aria-controls="navs-pills-roles" aria-selected="false"
                    tabindex="-1">
                    {{ __('users::users.assigned_roles') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-permissions" aria-controls="navs-pills-left-permissions"
                    aria-selected="false" tabindex="-1">{{ __('users::users.assigned_permission') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-departments" aria-controls="navs-pills-left-departments"
                    aria-selected="false" tabindex="-1">{{ __('users::users.assigned_departments') }}</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-home" role="tabpanel">
                <livewire:users.user_details :$user />
            </div>

            <div class="tab-pane fade" id="navs-pills-roles" role="tabpanel">

                <div class="tab-pane fade show active" id="navs-pills-roles" role="tabpanel">
                    <livewire:users.user_roles :$user />
                </div>
            </div>

            <div class="tab-pane fade" id="navs-pills-permissions" role="tabpanel">

                <div class="tab-pane fade show active" id="navs-pills-permissions" role="tabpanel">
                    <livewire:users.user_permissions :$user />
                </div>
            </div>

            <div class="tab-pane fade" id="navs-pills-departments" role="tabpanel">

                <div class="tab-pane fade show active" id="navs-pills-departments" role="tabpanel">
                    <livewire:users.manage_user_department :$user />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
