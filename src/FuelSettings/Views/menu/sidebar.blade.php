<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('Fuel Management System') }}</span>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.fuel_settings.*') ? 'active' : '' }}">
    <a href="{{ route('admin.fuel_settings.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-gas-pump"></i>
        <div data-i18n="Tasks">{{ __('Fuel Setting') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.vehicle_categories.*') ? 'active' : '' }}">
    <a href="{{ route('admin.vehicle_categories.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-category"></i>
        <div data-i18n="Tasks">{{ __('Vehicle Category') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.vehicles.*') ? 'active' : '' }}">
    <a href="{{ route('admin.vehicles.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-car"></i>
        <div data-i18n="Tasks">{{ __('Vehicle') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.tokens.*') ? 'active' : '' }}">
    <a href="{{ route('admin.tokens.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-credit-card"></i>
        <div data-i18n="Tasks">{{ __('Token Request') }}</div>
    </a>
</li>



<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.review_tokens.*') ? 'active' : '' }}">
    <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-search-alt"></i>
        <div data-i18n="Tasks">{{ __('Review Token') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.accept_tokens.*') ? 'active' : '' }}">
    <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-check-circle"></i>
        <div data-i18n="Tasks">{{ __('Accept Token') }}</div>
    </a>
</li>
