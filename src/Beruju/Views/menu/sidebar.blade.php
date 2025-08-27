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

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.beruju.sub-categories.*') ? 'active' : '' }}">
    <a href="{{ route('admin.beruju.sub-categories.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-category"></i>
        <div data-i18n="SubCategories">{{ __('beruju::beruju.sub_categories') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.beruju.action-types.*') ? 'active' : '' }}">
    <a href="{{ route('admin.beruju.action-types.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-task"></i>
        <div data-i18n="ActionTypes">{{ __('beruju::beruju.action_types') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.beruju.document-types.*') ? 'active' : '' }}">
    <a href="{{ route('admin.beruju.document-types.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="DocumentTypes">{{ __('beruju::beruju.document_types') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.beruju.reports.*') ? 'active' : '' }}">
    <a href="{{ route('admin.beruju.reports.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
        <div data-i18n="Reports">{{ __('beruju::beruju.beruju_reports') }}</div>
    </a>
</li>
