<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('yojana::yojana.plan_settings') }}</span>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan.index') ? 'active' : '' }}">
    <a href="{{ route('admin.plan.index') }}" class="menu-link">
        {{--        <i class="menu-icon tf-icons bx bx-home"></i> --}}
        <i class="menu-icon tf-icons bx bx-line-chart"></i>
        <div data-i18n="">{{ __('yojana::yojana.dashboard') }}</div>
    </a>
</li>

<li
    class="menu-item  {{ \Illuminate\Support\Facades\Route::is([
        'admin.committee_types.*',
        'admin.consumer_committees.*',
        'admin.consumer_committee_members.*',
        'admin.organizations.*',
        'admin.applications.*',
    ])
        ? 'open active'
        : '' }}">
    <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Account Settings">{{ __('yojana::yojana.consumer_committee_settings') }}</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.committee_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.committee_types.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div data-i18n="">{{ __('yojana::yojana.committee_types') }}</div>
            </a>
        </li>

        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.consumer_committees.*') ? 'active' : '' }}">
            <a href="{{ route('admin.consumer_committees.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="">{{ __('yojana::yojana.consumer_committee') }}</div>
            </a>
        </li>

        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.consumer_committee_members.*') ? 'active' : '' }}">
            <a href="{{ route('admin.consumer_committee_members.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-check"></i>
                <div data-i18n="">{{ __('yojana::yojana.consumer_committee_member') }}</div>
            </a>
        </li>

        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.organizations.*') ? 'active' : '' }}">
            <a href="{{ route('admin.organizations.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-buildings"></i>
                <div data-i18n="">{{ __('yojana::yojana.organizations') }}</div>
            </a>
        </li>

        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.applications.*') ? 'active' : '' }}">
            <a href="{{ route('admin.applications.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="">{{ __('yojana::yojana.application') }}</div>
            </a>
        </li>

    </ul>
</li>

<li
    class="menu-item  {{ \Illuminate\Support\Facades\Route::is([
        'admin.plan_areas.*',
        'admin.budget_heads.*',
        'admin.budget_details.*',
        'admin.budget_sources.*',
        'admin.expense_heads.*',
        'admin.plan_levels.*',
        'admin.types.*',
        'admin.measurement_units.*',
        'admin.unit_types.*',
        'admin.units.*',
        'admin.item_types.*',
        'admin.items.*',
        'admin.configurations.*',
        'admin.targets.*',
        'admin.sub_regions.*',
        'admin.implementation_levels.*',
        'admin.bank_details.*',
        'admin.implementation_methods.*',
        'admin.project_groups.*',
        'admin.project_activity_groups.*',
        'admin.activities.*',
        'admin.process_indicators.*',
        'admin.agreement_formats.*',
        'admin.letter_samples.*',
        'admin.norm_types.*',
        'admin.letter_types.*',
        'admin.source_types.*',
        'admin.test_lists.*',
        'admin.benefited_members.*',
        'admin.project_incharge',
    ])
        ? 'open active'
        : '' }}">
    <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Account Settings">{{ __('yojana::yojana.basic_settings') }}</div>
    </a>

    <ul class="menu-sub">
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_areas.*') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_areas.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-area"></i>
                <div data-i18n="">{{ __('yojana::yojana.plan_area') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.budget_heads.*') ? 'active' : '' }}">
            <a href="{{ route('admin.budget_heads.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wallet"></i>
                <div data-i18n="">{{ __('yojana::yojana.budget_heads') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.budget_details.*') ? 'active' : '' }}">
            <a href="{{ route('admin.budget_details.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                <div data-i18n="">{{ __('yojana::yojana.budget_details') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.budget_sources.*') ? 'active' : '' }}">
            <a href="{{ route('admin.budget_sources.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wallet"></i>
                <div data-i18n="">{{ __('yojana::yojana.budget_source') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.expense_heads.*') ? 'active' : '' }}">
            <a href="{{ route('admin.expense_heads.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>

                <div data-i18n="">{{ __('yojana::yojana.expense_heads') }}</div>
            </a>
        </li>
        {{--        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_levels.*') ? 'active' : '' }}"> --}}
        {{--            <a href="{{ route('admin.plan_levels.index') }}" class="menu-link"> --}}
        {{--                <i class="menu-icon tf-icons bx bx-layer"></i> --}}
        {{--                <div data-i18n="">{{ __('yojana::yojana.plan_levels') }}</div> --}}
        {{--            </a> --}}
        {{--        </li> --}}
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.types.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-ruler"></i>
                <div data-i18n="">{{ __('yojana::yojana.types') }}</div>
            </a>
        </li>
        {{--        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.measurement_units.*') ? 'active' : '' }}"> --}}
        {{--            <a href="{{ route('admin.measurement_units.index') }}" class="menu-link"> --}}
        {{--                <i class="menu-icon tf-icons bx bx-calculator"></i> --}}
        {{--                <div data-i18n="">{{ __('yojana::yojana.measurement_units') }}</div> --}}
        {{--            </a> --}}
        {{--        </li> --}}
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.unit_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.unit_types.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid-alt"></i>
                <div data-i18n="">{{ __('yojana::yojana.unit_types') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.units.*') ? 'active' : '' }}">
            <a href="{{ route('admin.units.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid"></i>
                <div data-i18n="">{{ __('yojana::yojana.units') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.item_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.item_types.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div data-i18n="">{{ __('yojana::yojana.item_types') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.items.*') ? 'active' : '' }}">
            <a href="{{ route('admin.items.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="">{{ __('yojana::yojana.items') }}</div>
            </a>
        </li>

        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.configurations.*') ? 'active' : '' }}">
            <a href="{{ route('admin.configurations.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="">{{ __('yojana::yojana.configuration') }}</div>
            </a>
        </li>

        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.targets.*') ? 'active' : '' }}">
            <a href="{{ route('admin.targets.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bullseye"></i>
                <div data-i18n="">{{ __('yojana::yojana.targets') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.sub_regions.*') ? 'active' : '' }}">
            <a href="{{ route('admin.sub_regions.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-map"></i>
                <div data-i18n="">{{ __('yojana::yojana.sub_region') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.implementation_levels.*') ? 'active' : '' }}">
            <a href="{{ route('admin.implementation_levels.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layer"></i>
                <div data-i18n="">{{ __('yojana::yojana.implementation_level') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.bank_details.*') ? 'active' : '' }}">
            <a href="{{ route('admin.bank_details.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-bank"></i>
                <div data-i18n="">{{ __('yojana::yojana.bank_details') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.implementation_methods.*') ? 'active' : '' }}">
            <a href="{{ route('admin.implementation_methods.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="">{{ __('yojana::yojana.implementation_methods') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.project_groups.*') ? 'active' : '' }}">
            <a href="{{ route('admin.project_groups.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-briefcase"></i>
                <div data-i18n="">{{ __('yojana::yojana.project_groups') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.project_activity_groups.*') ? 'active' : '' }}">
            <a href="{{ route('admin.project_activity_groups.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-layer"></i>
                <div data-i18n="">{{ __('yojana::yojana.activity_groups') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.activities.*') ? 'active' : '' }}">
            <a href="{{ route('admin.activities.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-task"></i>
                <div data-i18n="">{{ __('yojana::yojana.activity') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.process_indicators.*') ? 'active' : '' }}">
            <a href="{{ route('admin.process_indicators.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                <div data-i18n="">{{ __('yojana::yojana.process_indicator') }}</div>
            </a>
        </li>
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.agreement_formats.*') ? 'active' : '' }}">
            <a href="{{ route('admin.agreement_formats.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-file"></i>
                <div data-i18n="">{{ __('yojana::yojana.agreement_formats') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.letter_samples.*') ? 'active' : '' }}">
            <a href="{{ route('admin.letter_samples.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file-blank"></i>
                <div data-i18n="">{{ __('yojana::yojana.letter_sample') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.norm_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.norm_types.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-book"></i>
                <div data-i18n="">{{ __('yojana::yojana.norm_types') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.letter_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.letter_types.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div data-i18n="">{{ __('yojana::yojana.letter_types') }}</div>
            </a>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.source_types.*') ? 'active' : '' }}">
            <a href="{{ route('admin.source_types.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-wallet"></i>
                <div data-i18n="">{{ __('yojana::yojana.source_types') }}</div>
            </a>
        </li>
        {{--        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.test_lists.*') ? 'active' : '' }}"> --}}
        {{--            <a href="{{ route('admin.test_lists.index') }}" class="menu-link"> --}}
        {{--                <i class="menu-icon tf-icons bx bx-list-check"></i> --}}
        {{--                <div data-i18n="">{{ __('yojana::yojana.test_list') }}</div> --}}
        {{--            </a> --}}
        {{--        </li> --}}
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.benefited_members.*') ? 'active' : '' }}">
            <a href="{{ route('admin.benefited_members.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user"></i>
                <div data-i18n="">{{ __('yojana::yojana.benefited_members') }}</div>
            </a>
        </li>
        {{--        <li --}}
        {{--            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plans.work_order.*') ? 'active' : '' }}"> --}}
        {{--            <a href="{{ route('admin.plans.work_orders.index') }}" class="menu-link"> --}}
        {{--                <i class="menu-icon tf-icons bx bxs-user"></i> --}}
        {{--                <div data-i18n="">{{ __('yojana::yojana.work_orders') }}</div> --}}
        {{--            </a> --}}
        {{--        </li> --}}
    </ul>
</li>


<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plans.*') ? 'active' : '' }}">
    <a href="{{ route('admin.plans.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-pencil"></i>
        <div data-i18n="">{{ __('yojana::yojana.plans') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.budget_transfer.*') ? 'active' : '' }}">
    <a href="{{ route('admin.budget_transfer.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-transfer-alt"></i>
        <div data-i18n="">{{ __('yojana::yojana.budget_transfer') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.agreedPlans') ? 'active' : '' }}">
    <a href="{{ route('admin.plan_reports.agreedPlans') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar-check"></i>
        <div data-i18n="">{{ __('yojana::yojana.agreed_plans') }}</div>
    </a>
</li>

{{-- <li class="menu-item"> --}}
{{--    <a href="" class="menu-link"> --}}
{{--        <i class="menu-icon tf-icons bx bx-credit-card"></i> --}}
{{--        <div data-i18n="">{{ __('yojana::yojana.plan_payments') }}</div> --}}
{{--    </a> --}}
{{-- </li> --}}

<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.extendedPlans') ? 'active' : '' }}">
    <a href="{{ route('admin.plan_reports.extendedPlans') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-timer"></i>
        <div data-i18n="">{{ __('yojana::yojana.extended_plans') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.programs.*') ? 'active' : '' }}">
    <a href="{{ route('admin.programs.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-task"></i>
        <div data-i18n="">{{ __('yojana::yojana.programs') }}</div>
    </a>
</li>

<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is([
        // 'admin.plan_reports.agreedPlans',
    ])
        ? 'open active'
        : '' }}">
    <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
        <div data-i18n="">{{ __('yojana::yojana.reports') }}</div>
    </a>
    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.planReport') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.planReport') }}" class="menu-link">
                <div data-i18n="">{{ __('yojana::yojana.plan_report') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.programReport') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.programReport') }}" class="menu-link">
                <div data-i18n="">{{ __('yojana::yojana.program_report') }}</div>
            </a>
        </li>
    </ul>
    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.plansByAllocatedBudget') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.plansByAllocatedBudget') }}" class="menu-link">
                <div data-i18n="">{{ __('yojana::yojana.report_according_to_allocated_budget') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item
            {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.planGoalsReport') ? 'active' : '' }} ">
            <a href="{{ route('admin.plan_reports.planGoalsReport') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.plan_goals_summary_report') }}</div>
            </a>
        </li>
    </ul>
    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.costEstimationByArea') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.costEstimationByArea') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.cost_estimation_and_payment_report_according_to_area') }}
                </div>
            </a>
        </li>
    </ul>
    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.planByCompletion') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.planByCompletion') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.plan_by_completion') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.activePlan') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.activePlan') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.active_plan') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.costEstimationByBudgetSource') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.costEstimationByBudgetSource') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">
                    {{ __('yojana::yojana.cost_estimation_and_payment_report_according_to_budget_source') }}</div>
            </a>
        </li>
    </ul>
    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.costEstimationByDepartment') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.costEstimationByDepartment') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">
                    {{ __('yojana::yojana.cost_estimation_and_payment_report_according_to_branch_or_department') }}
                </div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.costEstimationByExpenseHead') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.costEstimationByExpenseHead') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">
                    {{ __('yojana::yojana.cost_estimation_and_payment_report_according_to_expense_heading') }}</div>
            </a>
        </li>
    </ul>
    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.taxDeductionReport') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.taxDeductionReport') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.tax_deduction_report') }}</div>
            </a>
        </li>
    </ul>
    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.wardPlansByArea') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.wardPlansByArea') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.ward_level_plans_according_to_region') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.wardPlansByBudget') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.wardPlansByBudget') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.ward_level_plans_according_to_budget') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.wardPlansByDepartment') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.wardPlansByDepartment') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.ward_level_plans_according_to_department') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.MunicipalityPlansByBudget') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.MunicipalityPlansByBudget') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.municipality_level_plans_according_to_budget') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.plansByConsumerCommittee') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.plansByConsumerCommittee') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.plan_report_according_to_consumer_committee') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.plansByOrganization') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.plansByOrganization') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.plan_report_according_to_organization') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.paidPlans') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.paidPlans') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">{{ __('yojana::yojana.paid_plans_report') }}</div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.overDuePlanReport') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.overDuePlanReport') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">
                    {{ __('yojana::yojana.overdue_plan_report') }}
                </div>
            </a>
        </li>
    </ul>

    <ul class="menu-sub">
        <li
            class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.planNearDeadline') ? 'active' : '' }}">
            <a href="{{ route('admin.plan_reports.planNearDeadline') }}" class="menu-link">
                <i class=></i>
                <div data-i18n="">
                    {{ __('yojana::yojana.report_of_plan_with_less_than_15_days_for_deadline') }}
                </div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.log_books.*') ? 'active' : '' }}">
    <a href="{{ route('admin.log_books.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book"></i>
        <div data-i18n="">{{ __('yojana::yojana.log_books') }}</div>
    </a>
</li>

{{-- <li --}}
{{--    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_management_system.templates.*') ? 'active' : '' }}"> --}}
{{--    <a href="{{ route('admin.plan_management_system.form-template.index') }}" class="menu-link"> --}}
{{--        <i class="menu-icon tf-icons bx bx-lock"></i> --}}
{{--        <div data-i18n="">{{ __('yojana::yojana.form_templates') }}</div> --}}
{{--    </a> --}}
{{-- </li> --}}

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.plan_reports.closedPlans') ? 'active' : '' }}">
    <a href="{{ route('admin.plan_reports.closedPlans') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-lock"></i>
        <div data-i18n="">{{ __('yojana::yojana.closing') }}</div>
    </a>
</li>
