<ul class="menu-inner py-1">

    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('organization.dashboard') ? 'active' : '' }}">
        <a href="{{ route('organization.dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">{{ __('Dashboard') }}</div>
        </a>
    </li>

    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('organization.dashboard') ? 'active' : '' }}">
        <a href="{{ route('organization.profile') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">{{ __('Profile') }}</div>
        </a>
    </li>

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">{{ __('ebps::ebps.map_applications') }}</span>
    </li>

    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('organization.ebps.map_apply.*') ? 'active' : '' }}">
        <a href="{{ route('organization.ebps.map_apply.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">{{ __('ebps::ebps.map_applications') }}</div>
        </a>
    </li>

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">{{ __('ebps::ebps.building_registration_application') }}</span>
    </li>

    <li
        class="menu-item {{ \Illuminate\Support\Facades\Route::is('organization.ebps.building-registrations.*') ? 'active' : '' }}">
        <a href="{{ route('organization.ebps.building-registrations.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">{{ __('ebps::ebps.building_registration_application') }}</div>
        </a>
    </li>

</ul>
