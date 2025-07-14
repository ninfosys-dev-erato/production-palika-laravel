<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('grantmanagement::grantmanagement.grant_management_system') }}</span>
</li>

<li
    class="menu-item  {{ \Illuminate\Support\Facades\Route::is('admin.farmers.*', 'admin.cooperative.*', 'admin.groups.*', 'admin.enterprises.*') ? 'open' : '' }}">
    <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Grantees">{{ __('grantmanagement::grantmanagement.grantees') }}</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.farmers.*') ? 'active' : '' }}">
            <a href="{{ route('admin.farmers.index') }}" class="menu-link">

                <div data-i18n="Farmers">{{ __('grantmanagement::grantmanagement.farmers') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.cooperative.*') ? 'active' : '' }}">
            <a href="{{ route('admin.cooperative.index') }}" class="menu-link">

                <div data-i18n="Cooperatives">{{ __('grantmanagement::grantmanagement.cooperatives') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.groups.*') ? 'active' : '' }}">
            <a href="{{ route('admin.groups.index') }}" class="menu-link">

                <div data-i18n="Group">{{ __('grantmanagement::grantmanagement.group') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.enterprises.*') ? 'active' : '' }}">
            <a href="{{ route('admin.enterprises.index') }}" class="menu-link">

                <div data-i18n="Enterprise">{{ __('grantmanagement::grantmanagement.enterprise') }}</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.grant_programs.*') ? 'active' : '' }}">
    <a href="{{ route('admin.grant_programs.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-category"></i>
        <div data-i18n="Tasks">{{ __('grantmanagement::grantmanagement.programactivities') }}</div>
    </a>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.grant_release.*') ? 'active' : '' }}">
    <a href="{{ route('admin.grant_release.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-category"></i>
        <div data-i18n="Tasks">{{ __('grantmanagement::grantmanagement.grant_release') }}</div>
    </a>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.cash_grants.*') ? 'active' : '' }}">
    <a href="{{ route('admin.cash_grants.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-category"></i>
        <div data-i18n="Tasks">{{ __('grantmanagement::grantmanagement.for_cash_grant') }}</div>
    </a>
</li>


<li
    class="menu-item  {{ \Illuminate\Support\Facades\Route::is('admin.grant_types.*', 'admin.cooperative_types.*', 'admin.cooperative_types.*', 'admin.enterprise_types.*', 'admin.grant_offices.*', 'admin.helplessness_types.*') ? 'open' : '' }}">
    <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Grantees">{{ __('grantmanagement::grantmanagement.grant_type') }}</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.grant_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.grant_types.index') }}" class="menu-link">

                <div data-i18n="Farmers">{{ __('grantmanagement::grantmanagement.grant_type') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.cooperative_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.cooperative_types.index') }}" class="menu-link">

                <div data-i18n="Cooperatives">{{ __('grantmanagement::grantmanagement.cooperative_type') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.affiliations.*') ? 'active' : '' }}">
            <a href="{{ route('admin.affiliations.index') }}" class="menu-link">

                <div data-i18n="Cooperatives">{{ __('grantmanagement::grantmanagement.cooperative_membership') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.enterprise_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.enterprise_types.index') }}" class="menu-link">
                <div data-i18n="Enterprise Type">{{ __('grantmanagement::grantmanagement.enterprise_type') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.grant_offices.*') ? 'active' : '' }}">
            <a href="{{ route('admin.grant_offices.index') }}" class="menu-link">

                <div data-i18n="Grant Offices">{{ __('grantmanagement::grantmanagement.grant_offices') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.helplessness_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.helplessness_types.index') }}" class="menu-link">

                <div data-i18n="Helplessness Type">{{ __('grantmanagement::grantmanagement.helplessness_type') }}</div>
            </a>
        </li>
    </ul>
</li>

<!-- Reports -->
<li class="menu-item {{ Route::is(
    'admin.reports.grant_programs.reports',
    'admin.reports.cash_grant.reports',
    'admin.reports.grant_release.reports',
    'admin.reports.farmers.reports',
    'admin.reports.groups.reports',
    'admin.reports.enterprises.reports',
    'admin.reports.cooperative.reports'
) ? 'open' : '' }}">
    <a href="#" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bxs-report'></i>
        <div data-i18n="Reports">{{ __('grantmanagement::grantmanagement.reports') }}</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ Route::is('admin.reports.grant_programs.reports') ? 'active' : '' }}">
            <a href="{{ route('admin.reports.grant_programs.reports') }}" class="menu-link">
                <div data-i18n="Grant Programs Reports">
                    {{ __('grantmanagement::grantmanagement.grant_programs_report') }}
                </div>
            </a>
        </li>

        <li class="menu-item {{ Route::is('admin.reports.cash_grant.reports') ? 'active' : '' }}">
            <a href="{{ route('admin.reports.cash_grant.reports') }}" class="menu-link">
                <div data-i18n="Cash Grant Reports">
                    {{ __('grantmanagement::grantmanagement.cash_grant_report') }}
                </div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.reports.grant_release.reports') ? 'active' : '' }}">
            <a href="{{ route('admin.reports.grant_release.reports') }}" class="menu-link">
                <div data-i18n="Grant Release Reports">
                    {{ __('grantmanagement::grantmanagement.grant_release_report') }}
                </div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.reports.farmers.reports') ? 'active' : '' }}">
            <a href="{{ route('admin.reports.farmers.reports') }}" class="menu-link">
                <div data-i18n="Farmer Reports">
                    {{ __('grantmanagement::grantmanagement.farmer_reports') }}
                </div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.reports.groups.reports') ? 'active' : '' }}">
            <a href="{{ route('admin.reports.groups.reports') }}" class="menu-link">
                <div data-i18n="Group Reports">
                    {{ __('grantmanagement::grantmanagement.group_reports') }}
                </div>
            </a>
        </li>

        <li class="menu-item {{ Route::is('admin.reports.enterprises.reports') ? 'active' : '' }}">
            <a href="{{ route('admin.reports.enterprises.reports') }}" class="menu-link">
                <div data-i18n="Enterprise Reports">
                    {{ __('grantmanagement::grantmanagement.enterprises_reports') }}
                </div>
            </a>
        </li>

        <li class="menu-item {{ Route::is('admin.reports.cooperative.reports') ? 'active' : '' }}">
            <a href="{{ route('admin.reports.cooperative.reports') }}" class="menu-link">
                <div data-i18n="Enterprise Reports">
                    {{ __('grantmanagement::grantmanagement.cooperative_reports') }}
                </div>
            </a>
        </li>


    </ul>
</li>