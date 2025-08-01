<ul class="menu-inner py-1">
    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-grid-alt"></i>
            <div data-i18n="Analytics">{{ __('Main Menu') }}</div>
        </a>
    </li>
    @perm('customer access')
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.customer.index') ? 'active' : '' }}">
            <a href="{{ route('admin.customer.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Form">{{ __('Customer') }}</div>
            </a>
        </li>
    @endperm
    @if (\Illuminate\Support\Facades\Route::is('admin.grievance.*'))
        @include('Grievance::menu.sidebar')
    @endif

    @if (\Illuminate\Support\Facades\Route::is('admin.recommendations.*'))
        @include('Recommendation::menu.sidebar')
    @endif

    @if (
        \Illuminate\Support\Facades\Route::is(
            'admin.grant_management.index',
            'admin.affiliations.*',
            'admin.cash_grants.*',
            'admin.cooperative_farmers.*',
            'admin.cooperative_types.*',
            'admin.cooperative.*',
            'admin.enterprise_farmers.*',
            'admin.enterprise_types.*',
            'admin.enterprises.*',
            'admin.farmer_groups.*',
            'admin.farmers.*',
            'admin.grant_details.*',
            'admin.grant_offices.*',
            'admin.grant_programs.*',
            'admin.grant_release.*',
            'admin.grant_types.*',
            'admin.grants.*',
            'admin.groups.*',
            'admin.helplessness_types.',
            'admin.reports.cash_grant.reports',
            'admin.reports.grant_programs.reports',
            'admin.reports.cash_programs.*',
            'admin.reports.grant_release.reports',
            'admin.reports.cash_programs.reports.*',
            'admin.reports.farmers.reports',
            'admin.reports.groups.reports',
            'admin.reports.enterprises.reports',
            'admin.reports.cooperative.reports',
            'admin.helplessness_types.*'))
        @include('GrantManagement::menu.sidebar')
    @endif

    @if (
        \Illuminate\Support\Facades\Route::is(
            'admin.meetings.*',
            'admin.committee-types.*',
            'admin.committees.*',
            'admin.committee-members.*'))
        @include('Meetings::menu.sidebar')
    @endif

    @if (\Illuminate\Support\Facades\Route::is('admin.digital_board.*'))
        @include('DigitalBoard::menu.sidebar')
    @endif

    @if (\Illuminate\Support\Facades\Route::is('admin.business-registration.*', 'admin.business-deregistration.*'))
        @include('BusinessRegistration::menu.sidebar')
    @endif

    @if (
        \Illuminate\Support\Facades\Route::is(
            'admin.file_records.*',
            'admin.file_record_notifiees.*',
            'admin.file_record_logs.*',
            'admin.patrachar.*'))
        @include('FileTracking::menu.sidebar')
    @endif

    @php
        use Illuminate\Support\Facades\Route;

        $isRegisterFileRoute = Route::is('admin.register_files.*');
        $isChalaniRoute = Route::is('admin.chalani.*');
    @endphp

    @if ($isRegisterFileRoute || $isChalaniRoute)
        {{-- Dashboard --}}
        {{-- Register Files Section --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('Dashboard') }}</span>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.register_files.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">{{ __('Dashboard') }}</div>
            </a>
        </li>

        {{-- Register Files Section --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('Register Files') }}</span>
        </li>

        @perm('darta access')
            <li
                class="menu-item {{ Route::is('admin.register_files.index', 'admin.register_files.show', 'admin.register_files.edit') ? 'active' : '' }}">
                <a href="{{ route('admin.register_files.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Form">{{ __('Register Files') }}</div>
                </a>
            </li>
            <li class="menu-item {{ Route::is('admin.register_files.create') ? 'active' : '' }}">
                <a href="{{ route('admin.register_files.create') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Form">{{ __('Register Create') }}</div>
                </a>
            </li>
        @endperm

        {{-- Chalani Section --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('Chalani') }}</span>
        </li>

        @perm('darta access')
            <li
                class="menu-item {{ Route::is('admin.chalani.index', 'admin.chalani.show', 'admin.chalani.edit') ? 'active' : '' }}">
                <a href="{{ route('admin.chalani.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-send"></i>
                    <div data-i18n="Form">{{ __('Chalani') }}</div>
                </a>
            </li>

            <li class="menu-item {{ Route::is('admin.chalani.create') ? 'active' : '' }}">
                <a href="{{ route('admin.chalani.create') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                    <div data-i18n="Form">{{ __('New') }}</div>
                </a>
            </li>
        @endperm
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('Report') }}</span>
        </li>

        <li class="menu-item {{ Route::is('admin.register_files.report') ? 'active' : '' }}">
            <a href="{{ route('admin.register_files.report') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                <div data-i18n="Form">{{ __('Register File Report') }}</div>
            </a>
        </li>

        <li class="menu-item {{ Route::is('admin.chalani.report') ? 'active' : '' }}">
            <a href="{{ route('admin.chalani.report') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                <div data-i18n="Form">{{ __('Chalani Report') }}</div>
            </a>
        </li>
    @endif



    @if (
        \Illuminate\Support\Facades\Route::is(
            'admin.plan.*',
            'admin.programs.*',
            'admin.plan_areas.*',
            'admin.plans.*',
            'admin.budget_heads.*',
            'admin.budget_details.*',
            'admin.expense_heads.*',
            'admin.plan_levels.*',
            'admin.types.*',
            'admin.measurement_units.*',
            'admin.items.*',
            'admin.item_types.*',
            'admin.units.*',
            'admin.unit_types.*',
            'admin.configurations.*',
            'admin.targets.*',
            'admin.bank_details.*',
            'admin.budget_sources.*',
            'admin.sub_regions.*',
            'admin.implementation_levels.*',
            'admin.implementation_methods.*',
            'admin.project_groups.*',
            'admin.project_activity_groups.*',
            'admin.activities.*',
            'admin.process_indicators.*',
            'admin.agreement_formats.*',
            'admin.letter_samples.*',
            'admin.activities.*',
            'admin.norm_types.*',
            'admin.letter_types.*',
            'admin.source_types.*',
            'admin.test_lists.*',
            'admin.budget_transfer.*',
            'admin.committee_types.*',
            'admin.applications.*',
            'admin.log_books.*',
            'admin.consumer_committees.*',
            'admin.consumer_committee_members.*',
            'admin.organizations.*',
            'admin.plan_reports.*',
            'admin.benefited_members.*'))
        @include('Yojana::menu.sidebar')
    @endif


    @if (
        \Illuminate\Support\Facades\Route::is(
            'admin.ebps.*',
            'admin.ebps.land-use-areas.*',
            'admin.ebps.map_pass_groups.*'))
        @include('Ebps::menu.sidebar')
    @endif

    @if (
        \Illuminate\Support\Facades\Route::is(
            'admin.register_tokens.*',
            'admin.token_logs.*',
            'admin.token_holders.*',
            'admin.searchToken.*',
            'admin.token_feedbacks.*',
            'admin.tokenReport.*',
            'admin.token_dashboard.*'))
        @include('TokenTracking::menu.sidebar')
    @endif

    @if (\Illuminate\Support\Facades\Route::is('admin.ejalas.*', 'admin.dashboard.*'))
        @include('Ejalas::menu.sidebar')
    @endif

    @if (
        \Illuminate\Support\Facades\Route::is(
            'admin.task-tracking.*',
            'admin.anusuchis.*',
            'admin.task.projects.*',
            'admin.task-types.*',
            'admin.tasks.*'))
        @include('TaskTracking::menu.sidebar')
    @endif

    @if (
        \Illuminate\Support\Facades\Route::is(
            'admin.fuel_settings.*',
            'admin.vehicle_categories.*',
            'admin.vehicles.*',
            'admin.fuel.*',
            'admin.tokens.*'))
        @include('FuelSettings::menu.sidebar')
    @endif

    @if (
        \Illuminate\Support\Facades\Route::is(
            'admin.dashboard',
            'admin.customer.index',
            'admin.wards.index',
            'admin.setting.*',
            'admin.employee.*',
            'admin.settings.*',
            'admin.setting_groups.*',
            'admin.users.*',
            'admin.roles.*',
            'admin.permissions.*',
            'admin.letter-head-sample.*'))
        @perm('general_setting access')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">{{ __('General Settings') }}</span>
            </li>
            <li
                class="menu-item  {{ \Illuminate\Support\Facades\Route::is('admin.setting.*', 'admin.wards.index') ? 'open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">{{ __('System Settings') }}</div>
                </a>
                <ul class="menu-sub">
                    <li
                        class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.setting.fiscal-years.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.setting.fiscal-years.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            <div data-i18n="FiscalYear">{{ __('Fiscal Year') }}</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.setting.form.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.setting.form.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-dock-bottom"></i>
                            <div data-i18n="LetterHead">{{ __('Form') }}</div>
                        </a>
                    </li>

                    @perm('office_setting access')
                        <li
                            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.setting.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.setting.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-table"></i>
                                <div data-i18n="Form">{{ __('Office Setting') }}</div>
                            </a>
                        </li>
                    @endperm
                    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.wards.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.wards.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-building-house"></i>
                            <div data-i18n="Form">{{ __('Wards') }}</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.letter-head-sample.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.letter-head-sample.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-video"></i>
                            <div data-i18n="Videos">{{ __('LetterHead Sample') }}</div>
                        </a>
                    </li>
                </ul>
            </li>
            @include('Settings::menu.sidebar')
        @endperm

        @perm('human_resource access')
            @include('Employees::menu.sidebar')
        @endperm

        @perm('users access')
            @include('Users::menu.sidebar')
        @endperm
    @endif

</ul>
