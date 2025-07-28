{{-- Note added ps-4 for padding and low gap at the left side --}}
<style>
    /* When the <li> has the 'active' class, change the background color of the <a> element */
    li.active>a {
        background-color: #e4f0ff;
        color: #01399a !important;
    }
</style>
@php
    use Src\Ejalas\Enum\RouteName;
    use Src\Ejalas\Service\CheckRouteAdminService;

@endphp

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('ejalas::ejalas.ejalash') }}</span>
</li>

@perm('jms_settings access')
    <li
        class="menu-item has-sub {{ request()->routeIs('admin.ejalas.judicial_committees.*', 'admin.ejalas.judicial_members.*', 'admin.ejalas.dispute_area.*', 'admin.ejalas.local_levels.*', 'admin.ejalas.levels.*', 'admin.ejalas.mediators.*', 'admin.ejalas.dispute_matters.*', 'admin.ejalas.registration_indicators.*', 'admin.ejalas.priorities.*', 'admin.ejalas.parties.*', 'admin.ejalas.reconciliation_centers.*', 'admin.ejalas.judicial_employees.*') ? 'active open' : '' }}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Ejalas Management">{{ __('ejalas::ejalas.ejalas_management') }}</div>
        </a>
        <ul class="menu-sub">
            <li class="{{ \Illuminate\Support\Facades\Route::is('admin.ejalas.judicial_committees.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.judicial_committees.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-shield"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.judicial_committee') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.judicial_members.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.judicial_members.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.judicial_members') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.dispute_area.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.dispute_areas.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-map"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.dispute_area') }}</div>
                </a>
            </li>

            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.local_levels.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.local_levels.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-building-house"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.local_level') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.levels.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.levels.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-layer"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.levels') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.mediators.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.mediators.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.mediators') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.dispute_matters.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.dispute_matters.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-conversation"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.dispute_matters') }}</div>
                </a>
            </li>
            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.registration_indicators.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.registration_indicators.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-list-check"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.registration_indicator') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.priotities.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.priotities.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-bar-chart-alt"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.priority') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.parties.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.parties.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.party') }}</div>
                </a>
            </li>
            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.reconciliation_centers.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.reconciliation_centers.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.reconciliation_center') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.judicial_employees.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.judicial_employees.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.judicial_employee') }}</div>
                </a>
            </li>
        </ul>
    </li>
@endperm


@perm('jms_judicial_management access')
    <li
        class="menu-item has-sub 
    {{ request()->routeIs(
        'admin.ejalas.judicial_meetings.*',
        'admin.ejalas.dispute_registration_courts.*',
        'admin.ejalas.dispute_deadlines.*',
        'admin.ejalas.witnesses_representatives.*',
        'admin.ejalas.written_response_registrations.*',
        'admin.ejalas.case_records.*',
        'admin.ejalas.legal_documents.*',
        'admin.ejalas.court_submissions.*',
        'admin.ejalas.court_notices.*',
    )
        ? 'active open'
        : '' }}

    {{ CheckRouteAdminService::isActive(
        [
            'admin.ejalas.complaint_registrations.*',
            'admin.ejalas.mediator_selections.*',
            'admin.ejalas.hearing_schedules.*',
            'admin.ejalas.fulfilled_conditions.*',
            'admin.ejalas.settlements.*',
        ],
        RouteName::General,
    )
        ? 'active open'
        : '' }}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Ejalas Management">{{ __('ejalas::ejalas.judicial_management') }}</div>
        </a>
        <ul class="menu-sub">
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.judicial_meetings.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.judicial_meetings.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-edit-alt"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.judicial_meeting') }}</div>
                </a>
            </li>
            <li
                class="{{ CheckRouteAdminService::isActive('admin.ejalas.complaint_registrations.*', RouteName::General) ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.complaint_registrations.index', ['from' => RouteName::General]) }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-edit-alt"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.complaint_entry') }}</div>
                </a>
            </li>

            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.dispute_registration_courts.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.dispute_registration_courts.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.dispute_registration') }}</div>
                </a>
            </li>

            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.dispute_deadlines.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.dispute_deadlines.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-time-five"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.dispute_deadline') }}</div>
                </a>
            </li>

            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.court_notices.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.court_notices.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-time-five"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.court_notice') }}</div>
                </a>
            </li>

            <li
                class="{{ CheckRouteAdminService::isActive('admin.ejalas.hearing_schedules.*', RouteName::General) ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.hearing_schedules.index', ['from' => RouteName::General]) }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.hearing_schedule') }}</div>
                </a>
            </li>
            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.written_response_registrations.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.written_response_registrations.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.response_registration') }}</div>
                </a>
            </li>
            <li
                class="{{ CheckRouteAdminService::isActive('admin.ejalas.mediator_selections.*', RouteName::General) ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.mediator_selections.index', ['from' => RouteName::General]) }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-user-check"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.mediator_selection') }}</div>
                </a>
            </li>

            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.witnesses_representatives.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.witnesses_representatives.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.witness_representative') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.legal_documents.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.legal_documents.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.legal_document') }}</div>
                </a>
            </li>

            <li
                class="{{ CheckRouteAdminService::isActive('admin.ejalas.settlements.*', RouteName::General) ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.settlements.index', ['from' => RouteName::General]) }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.settlement') }}</div>
                </a>
            </li>
            <li
                class="{{ CheckRouteAdminService::isActive('admin.ejalas.fulfilled_conditions.*', RouteName::General) ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.fulfilled_conditions.index', ['from' => RouteName::General]) }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.fulfilled_conditions') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.case_records.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.case_records.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.case_records') }}</div>
                </a>
            </li>
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.court_submissions.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.court_submissions.index') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.court_submission') }}</div>
                </a>
            </li>
        </ul>
    </li>
@endperm

{{-- 'admin.ejalas.report.hearing_schedules.*', 'admin.ejalas.report.settlements.*', 'admin.ejalas.report.dispute_deadlines.*', 'admin.ejalas.report.fulfilled_conditions.*', 'admin.ejalas.report.case_records.*', 'admin.ejalas.report.court_submissions.*', 'admin.ejalas.fiscal_years.report' --}}

@perm('jms_reconciliation_center access')
    <li class="menu-item has-sub {{ request('from') == RouteName::ReconciliationCenter->value ? 'active open' : '' }}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Ejalas Management">{{ __('ejalas::ejalas.reconciliation_center') }}</div>
        </a>
        <ul class="menu-sub">
            <li
                class="{{ CheckRouteAdminService::isActive('admin.ejalas.complaint_registrations.*', RouteName::ReconciliationCenter) ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.complaint_registrations.index', ['from' => RouteName::ReconciliationCenter]) }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-edit-alt"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.complaint_registration') }}</div>
                </a>
            </li>
            <li
                class="{{ CheckRouteAdminService::isActive('admin.ejalas.mediator_selections.*', RouteName::ReconciliationCenter) ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.mediator_selections.index', ['from' => RouteName::ReconciliationCenter]) }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-user-check"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.mediator_selection') }}</div>
                </a>
            </li>
            <li
                class="{{ CheckRouteAdminService::isActive('admin.ejalas.hearing_schedules.*', RouteName::ReconciliationCenter) ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.hearing_schedules.index', ['from' => RouteName::ReconciliationCenter]) }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.hearing_schedule') }}</div>
                </a>
            </li>

            <li
                class="{{ CheckRouteAdminService::isActive('admin.ejalas.settlements.*', RouteName::ReconciliationCenter) ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.settlements.index', ['from' => RouteName::ReconciliationCenter]) }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.settlement') }}</div>
                </a>
            </li>

            <li
                class="{{ CheckRouteAdminService::isActive('admin.ejalas.fulfilled_conditions.*', RouteName::ReconciliationCenter) ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.fulfilled_conditions.index', ['from' => RouteName::ReconciliationCenter]) }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.fulfilled_conditions') }}</div>
                </a>
            </li>

        </ul>
    </li>
@endperm


@perm('jms_report access')
    <li
        class="menu-item has-sub {{ request()->routeIs('admin.ejalas.report.complaint_registrations.*', 'admin.ejalas.report.hearing_schedules.*', 'admin.ejalas.report.settlements.*', 'admin.ejalas.report.dispute_deadlines.*', 'admin.ejalas.report.fulfilled_conditions.*', 'admin.ejalas.report.case_records.*', 'admin.ejalas.report.court_submissions.*', 'admin.ejalas.fiscal_years.report') ? 'active open' : '' }}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Ejalas Management">{{ __('ejalas::ejalas.report') }}</div>
        </a>
        <ul class="menu-sub">
            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.report.complaint_registrations.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.report.complaint_registrations.report') }}"
                    class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-edit-alt"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.complaint_registration') }}</div>
                </a>
            </li>
            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.report.hearing_schedules.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.report.hearing_schedules.report') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.hearing_schedule') }}</div>
                </a>
            </li>
            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.report.settlements.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.report.settlements.report') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.settlement') }}</div>
                </a>
            </li>
            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.report.dispute_deadlines.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.report.dispute_deadlines.report') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-time-five"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.dispute_deadline') }}</div>
                </a>
            </li>

            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.report.fulfilled_conditions.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.report.fulfilled_conditions.report') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.fulfilled_conditions') }}</div>
                </a>
            </li>
            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.report.case_records.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.report.case_records.report') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.case_records') }}</div>
                </a>
            </li>
            <li
                class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.report.court_submissions.report') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.report.court_submissions.report') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.court_submission') }}</div>
                </a>
            </li>

            {{-- find this route in complaint_registrations --}}
            <li class=" {{ \Illuminate\Support\Facades\Route::is('admin.ejalas.fiscal_years.report') ? 'active' : '' }}">
                <a href="{{ route('admin.ejalas.fiscal_years.report') }}" class="menu-link ps-4 gap-2">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Tasks">{{ __('ejalas::ejalas.fiscal_year') }}</div>
                </a>
            </li>
        </ul>
    </li>
@endperm

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('ejalas::ejalas.system_setting') }}</span>
</li>
<li class="menu-item has-sub {{ request()->routeIs('admin.ejalas.form-template.index.*') ? 'active open' : '' }}">
    <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Ejalas Management">{{ __('ejalas::ejalas.forms') }}</div>
    </a>
    <ul class="menu-sub">
        <li
            class="{{ \Illuminate\Support\Facades\Route::is('admin.ejalas.form-template.index.*') ? 'active' : '' }}">
            <a href="{{ route('admin.ejalas.form-template.index') }}" class="menu-link ps-4 gap-2">
                <i class="menu-icon tf-icons bx bx-shield"></i>
                <div data-i18n="Tasks">{{ __('ejalas::ejalas.ejalas_form') }}</div>
            </a>
        </li>
    </ul>
</li>
