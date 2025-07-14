<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.employee.*') ? 'open' : '' }}">
    <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user-plus"></i>
        <div data-i18n="Account Settings">{{ __('employees::employees.human_resource') }}</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.employee.branch.*') ? 'active' : '' }}">
            <a href="{{ route('admin.employee.branch.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-sitemap"></i>
                <div data-i18n="Branch">{{ __('employees::employees.department') }}</div>
            </a>
        </li>

        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.employee.designation.*') ? 'active' : '' }}">
            <a href="{{ route('admin.employee.designation.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-tag"></i>
                <div data-i18n="Designation">{{ __('employees::employees.designation') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.employee.employee.*') ? 'active' : '' }}">
            <a href="{{ route('admin.employee.employee.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Employee">{{ __('employees::employees.employee') }}</div>
            </a>
        </li>
    </ul>
</li>
