<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('ebps::ebps.requests') }}</span>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.requested-change') ? 'active' : '' }}">
    <a href="{{ route('admin.ebps.requested-change') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-buildings"></i>
        <div data-i18n="Tasks">{{ __('ebps::ebps.change_requests') }} </div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('ebps::ebps.ebps') }}</span>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.organizations.*') ? 'active' : '' }}">
    <a href="{{ route('admin.ebps.organizations.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-buildings"></i>
        <div data-i18n="Tasks">{{ __('ebps::ebps.organizations') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.map_applies.*') ? 'active' : '' }}">
    <a href="{{ route('admin.ebps.map_applies.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-buildings"></i>
        <div data-i18n="Tasks">{{ __('ebps::ebps.map_applications') }}</div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('ebps::ebps.old_map_application') }}</span>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.old_applications.*') ? 'active' : '' }}">
    <a href="{{ route('admin.ebps.old_applications.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-buildings"></i>
        <div data-i18n="Tasks">{{ __('ebps::ebps.old_map_applications') }}</div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('ebps::ebps.building_registration_application') }}</span>
</li>

<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.building-registrations.*') ? 'active' : '' }}">
    <a href="{{ route('admin.ebps.building-registrations.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-buildings"></i>
        <div data-i18n="Tasks">{{ __('ebps::ebps.building_registration_application') }}</div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('ebps::ebps.report') }}</span>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.report.*') ? 'active' : '' }}">
    <a href="{{ route('admin.ebps.report') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-buildings"></i>
        <div data-i18n="Tasks">{{ __('ebps::ebps.ebps_report') }}</div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('ebps::ebps.settings') }}</span>
</li>


<li
    class="menu-item has-sub 
    {{ request()->routeIs(
        'admin.ebps.land_use_areas.*',
        'admin.ebps.map_pass_groups.*',
        'admin.ebps.storeys.*',
        'admin.ebps.construction_types.*',
        'admin.ebps.building_construction_types.*',
        'admin.ebps.building_criterias.*',
        'admin.ebps.building_roof_types.*',
        'admin.ebps.map_steps.*',
        'admin.ebps.document.*',
        'admin.ebps.map_important_documents.*',
        'admin.ebps.form-template.*',
    )
        ? 'active open'
        : '' }}">

    <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="EBPS Settings">{{ __('ebps::ebps.ebps_settings') }}</div>
    </a>

    <ul class="menu-sub">

        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.land_use_areas.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.land_use_areas.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-buildings"></i>
                <div data-i18n="Tasks">{{ __('ebps::ebps.land_use_area') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.map_pass_groups.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.map_pass_groups.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tasks">{{ __('ebps::ebps.map_pass_group') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.storeys.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.storeys.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tasks">{{ __('ebps::ebps.storey') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.construction_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.construction_types.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tasks">{{ __('ebps::ebps.construction_type') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.building_construction_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.building_construction_types.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tasks">{{ __('ebps::ebps.building_construction_type') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.building_criterias.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.building_criterias.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tasks">{{ __('ebps::ebps.building_criterias') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.building_roof_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.building_roof_types.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tasks">{{ __('ebps::ebps.building_roof_type') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.map_steps.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.map_steps.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tasks">{{ __('ebps::ebps.map_step') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.document.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.documents.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tasks">{{ __('ebps::ebps.ebps_document') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.filter-settings.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.filter-settings') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tasks">{{ __('Filter Setting') }}</div>
            </a>
        </li>


    </ul>
</li>

<li class="menu-item has-sub 
    {{ request()->routeIs('admin.ebps.form.*') ? 'active open' : '' }}">

    <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="EBPS Settings">{{ __('ebps::ebps.form_template') }}</div>
    </a>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.ebps.form-template.*', 'admin.ebps.form.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ebps.form-template.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tasks">{{ __('ebps::ebps.ebps_form_template') }}</div>
            </a>
        </li>
    </ul>
</li>
