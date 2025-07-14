<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.users.*' || 'admin.roles.*' || 'admin.permissions.*') ? 'open' : '' }}">
    <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user-plus"></i>
        <div data-i18n="Account Settings">{{ __('users::users.user_settings') }}</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.roles.index') ? 'active' : '' }}">
            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-check"></i>
                <div data-i18n="Roles">{{ __('users::users.roles') }}</div>
            </a>
        </li>

        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.permissions.index') ? 'active' : '' }}">
            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-lock-alt"></i>
                <div data-i18n="Permissions">{{ __('users::users.permissions') }}</div>
            </a>
        </li>

        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.users.index') ? 'active' : '' }}">
            <a href="{{ route('admin.users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Users">{{ __('users::users.users') }}</div>
            </a>
        </li>
    </ul>

</li>
