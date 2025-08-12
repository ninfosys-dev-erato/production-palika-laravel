<x-layout.app header="{{ __('beruju::beruju.beruju_management') }}">
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">{{ __('beruju::beruju.beruju_management') }}</span>
    </li>

    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.beruju.dashboard.*') ? 'active' : '' }}">
        <a href="{{ route('admin.beruju.dashboard.dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home"></i>
            <div data-i18n="Dashboard">{{ __('beruju::beruju.dashboard') }}</div>
        </a>
    </li>

    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.beruju.registration.*') ? 'active' : '' }}">
        <a href="{{ route('admin.beruju.registration.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-list-ul"></i>
            <div data-i18n="BerujuList">{{ __('beruju::beruju.beruju_registration') }}</div>
        </a>
    </li>

</x-layout.app>
