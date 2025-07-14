<x-layout.app header="{{ __('yojana::yojana.plan_details') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.plan.index') }}">
                    {{ __('yojana::yojana.plan_management') }}</a>
                @if ($category == 'plan')
            <li class="breadcrumb-item active" aria-current="page"> {{ __('yojana::yojana.view_plan') }}</li>
        @elseif($category != 'Program')
            <li class="breadcrumb-item active" aria-current="page"> {{ __('yojana::yojana.view_program') }}</li>
            @endif
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-md-12">
            <livewire:yojana.plan_profile :$plan />
        </div>
        <div class="col-md-12">
            {{-- Tab Navigation --}}
            <div class=" mt-4 mb-3">
                <ul class="nav nav-pills primary" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#plan-detail" aria-controls="plan-detail" aria-selected="false">
                            {{ __('yojana::yojana.plan_detail') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#project-incharge" aria-controls="project-incharge" aria-selected="false">
                            {{ __('yojana::yojana.project_incharge') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#cost-estimation" aria-controls="cost-estimation" aria-selected="false">
                            {{ __('yojana::yojana.cost_estimation') }}
                        </button>
                    </li>
                    @if ($plan->costEstimation()->exists())
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#target_entry" aria-controls="target_entry" aria-selected="false">
                                {{ __('yojana::yojana.target_entry') }}
                            </button>
                        </li>
                    @endif
                    @if ($plan?->costEstimation?->status === 'Approved')
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#implementation_bodies" aria-controls="implementation_bodies"
                                aria-selected="false">
                                {{ __('yojana::yojana.implementation_bodies') }}
                            </button>
                        </li>
                        @if ($plan->implementationAgencies()->exists())
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#agreement" aria-controls="agreement" aria-selected="false">
                                    {{ __('yojana::yojana.agreement') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#work-order" aria-controls="work-order" aria-selected="false">
                                    {{ __('yojana::yojana.work_order') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#advance-payment" aria-controls="advance-payment"
                                    aria-selected="false">
                                    {{ __('yojana::yojana.advance_payment') }}
                                </button>
                            </li>
                            @if ($category != 'program')
                                <li class="nav-item active show" role="presentation">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#evaluation" aria-controls="evaluation" aria-selected="false">
                                        {{ __('yojana::yojana.evaluation') }}
                                    </button>
                                </li>
                            @endif

                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#target-completion" aria-controls="target-completion" aria-selected="false">
                                    {{ __('yojana::yojana.target_completion') }}
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#document-upload" aria-controls="document-upload"
                                    aria-selected="false">
                                    {{ __('yojana::yojana.documents') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#payment-tab" aria-controls="payment-tab" aria-selected="false">
                                    {{ __('yojana::yojana.payment') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#extension-tab" aria-controls="extension-tab"
                                    aria-selected="false">
                                    {{ __('yojana::yojana.plan_extension') }}
                                </button>
                            </li>
                            @if( $plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByContract ||
                                            $plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByNGO )
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#collateral-tab" aria-controls="collateral-tab"
                                    aria-selected="false">
                                    {{ __('yojana::yojana.collaterals') }}
                                </button>
                            </li>
                            @endif
                        @endif
                    @endif
                </ul>
            </div>

            {{-- Tabs --}}
            <div class="tab-content p-0">
                <div class="tab-pane fade  show active" id="plan-detail" role="tabpanel">
                    <!--Basic Details-->
                    <div class="card shadow-sm border-0">
                        <div
                            class="card-header bg-opacity-10 d-flex justify-content-between align-items-center py-3 mt-4">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-folder-open text-white fs-4"></i>
                                <h4 class="mb-0 font-weight-bold text-primary">{{ __('yojana::yojana.plan_details') }}
                                </h4>
                            </div>
                            <div>
                                @php
                                    $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
                                @endphp

                                @if($routeName === 'admin.plans.show')
                                    <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-danger">
                                        <i class="bx bx-edit me-1"></i>{{ __('yojana::yojana.edit') }}
                                    </a>
                                @elseif($routeName === 'admin.programs.show')
                                    <a href="{{ route('admin.programs.edit', $plan->id) }}" class="btn btn-danger">
                                        <i class="bx bx-edit me-1"></i>{{ __('yojana::yojana.edit') }}
                                    </a>
                                @endif
                                <a href="{{ route('admin.plans.print', $plan->id) }}" class="btn btn-primary  ">
                                    <i class="bx bx-printer me-1"></i>{{ __('yojana::yojana.print') }}
                                </a>
                                <a href="{{ route('admin.plans.index') }}" class="btn  btn-outline-secondary ms-2">
                                    <i class="bx bx-arrow-back me-1"></i>{{ __('yojana::yojana.back') }}
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="row">
                                <!-- Basic Details Section -->
                                <div class="col-12">
                                    <div class="divider divider-primary text-start text-primary">
                                        <div class="divider-text  fw-bold  mb-3">
                                            {{ __('yojana::yojana.basic_details') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-buildings text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">{{ __('yojana::yojana.project_name') }}</span>
                                            <span class="fw-medium">{{ $plan->project_name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-line-chart text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold small">{{ __('yojana::yojana.project_status') }}</span>
                                            <span class="fw-medium">{{ $plan->status->label() }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-cog text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold small">{{ __('yojana::yojana.implementation_method') }}</span>
                                            <span
                                                class="fw-medium">{{ $plan->implementationMethod->title ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-map-pin text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">{{ __('yojana::yojana.location') }}</span>
                                            <span class="fw-medium">{{ $plan->location }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-map text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">{{ __('yojana::yojana.ward') }}</span>
                                            <span class="fw-medium">{{ app()->getLocale() === "en" ? ($plan->ward->ward_name_en ?? $plan->ward->ward_name_ne) : ($plan->ward->ward_name_ne ?? $plan->ward->ward_name_en) ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-calendar text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold small">{{ __('yojana::yojana.start_fiscal_year') }}</span>
                                            <span class="fw-medium">{{ $plan->startFiscalYear->year ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-calendar-check text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold small">{{ __('yojana::yojana.operate_fiscal_year') }}</span>
                                            <span class="fw-medium">{{ $plan->operateFiscalYear->year ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-area text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">{{ __('yojana::yojana.area') }}</span>
                                            <span class="fw-medium">{{ $plan->planArea->area_name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-map-alt text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">{{ __('yojana::yojana.sub_region') }}</span>
                                            <span class="fw-medium">{{ $plan->subRegion->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-target-lock text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">{{ __('yojana::yojana.target') }}</span>
                                            <span class="fw-medium">{{ $plan->target->title ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-layer text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold small">{{ __('yojana::yojana.implementation_level') }}</span>
                                            <span
                                                class="fw-medium">{{ $plan->implementationLevel->title ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-category text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">{{ __('yojana::yojana.plan_type') }}</span>
                                            <span class="fw-medium">{{ $plan->plan_type->label() }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-cube text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">{{ __('yojana::yojana.nature') }}</span>
                                            <span class="fw-medium">{{ $plan->nature->label() }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-group text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold small">{{ __('yojana::yojana.project_group') }}</span>
                                            <span class="fw-medium">{{ $plan->projectGroup->title ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-bulb text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">{{ __('yojana::yojana.purpose') }}</span>
                                            <span class="fw-medium">{{ $plan->purpose }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="bx bx-book text-primary me-2 mt-1"></i>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold small">{{ __('yojana::yojana.red_book_detail') }}</span>
                                            <span class="fw-medium">{{ replaceNumbersWithLocale($plan->red_book_detail ?? '-', true) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Budget Description Section -->
                                <div class="col-12">
                                    <div class="divider divider-primary text-start text-primary">
                                        <div class="divider-text  fw-bold ">
                                            {{ __('yojana::yojana.budget_description') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card bg-light border-0 h-100 shadow-sm hover-shadow transition-all">
                                        <div class="card-body text-center p-4">
                                            <h6 class="text-primary mb-2">
                                                <i class="bx bx-wallet text-primary fs-1 mb-2"></i>
                                                {{ __('yojana::yojana.allocated_budget') }}
                                            </h6>
                                            <h5 class="mb-0">
                                                {{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($plan->allocated_budget ?? 0), true) }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card bg-light border-0 h-100 shadow-sm hover-shadow transition-all">
                                        <div class="card-body text-center p-4">
                                            <h6 class="text-primary mb-2">
                                                <i class="bx bx-transfer text-primary fs-1 mb-2"></i>
                                                {{ __('yojana::yojana.amount_transferred') }}
                                            </h6>
                                            <h5 class="mb-0">
                                                {{ __('yojana::yojana.rs').replaceNumbersWithLocale(replaceNumbers($plan->totalTransferAmount), true) }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>

{{--                                <div class="col-md-3 mb-4">--}}
{{--                                    <div class="card bg-light border-0 h-100 shadow-sm hover-shadow transition-all">--}}
{{--                                        <div class="card-body text-center p-4">--}}
{{--                                            <h6 class="text-primary mb-2">--}}
{{--                                                <i class='bx  bx-arrow-in-down-left-square text-primary'></i>--}}
{{--                                                <i class="bx bx-transfer text-primary fs-1 mb-2"></i>--}}
{{--                                                {{ __('yojana::yojana.received_amount') }}--}}
{{--                                            </h6>--}}
{{--                                            <h5 class="mb-0">--}}
{{--                                                {{ replaceNumbersWithLocale($plan->receivedAmount ?? 0, true) }}--}}
{{--                                            </h5>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="col-md-4 mb-4">
                                    <div class="card bg-light border-0 h-100 shadow-sm hover-shadow transition-all">
                                        <div class="card-body text-center p-4">
                                            <h6 class="text-primary mb-2">
                                                <i class="bx bx-dollar-circle text-primary fs-1 mb-2"></i>
                                                {{ __('yojana::yojana.final_budget') }}
                                            </h6>
                                            <h5 class="mb-0">
                                                {{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($plan->remaining_amount ?? 0), true) }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                                <!-- Budget Source Details Section -->
                                <div class="col-12">
                                    <div class="divider divider-primary text-start text-primary">
                                        <div class="divider-text  fw-bold ">
                                            {{ __('yojana::yojana.budget_source_details') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('yojana::yojana.source_type') }}</th>
                                                    <th>{{ __('yojana::yojana.program') }}</th>
                                                    <th>{{ __('yojana::yojana.budget_head') }}</th>
                                                    <th>{{ __('yojana::yojana.expense_head') }}</th>
                                                    <th>{{ __('yojana::yojana.fiscal_year') }}</th>
                                                    <th>{{ __('yojana::yojana.amount') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($plan->budgetSources as $index => $source)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $source->sourceType->title ?? '-' }}</td>
                                                        <td>{{ $source->budgetDetail->program ?? '-' }}</td>
                                                        <td>{{ $source->budgetHead->title ?? '-' }}</td>
                                                        <td>{{ $source->expenseHead->title ?? '-' }}</td>
                                                        <td>{{ $source->fiscalYear->year ?? '-' }}</td>
                                                        <td class="text-end">
                                                            {{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($source->amount ?? 0), true) }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">
                                                            <i
                                                                class="bx bx-info-circle me-1"></i>{{ __('yojana::yojana.no_budget_sources_found') }}
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                @if ($plan->budgetSources->count() > 0)
                                                    <tr class="table-light">
                                                        <td colspan="6" class="text-end fw-bold">
                                                            {{ __('yojana::yojana.total') }}
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            {{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($plan->budgetSources->sum('amount') ?? 0), true) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small">
                                        <i class="bx bx-time-five me-1"></i>{{ __('yojana::yojana.created_at') }}:
                                        {{ $plan->created_at->format('d M Y, h:i A') }}
                                    </span>
                                    @if ($plan->updated_at)
                                        <span class="text-muted small ms-3">
                                            <i
                                                class="bx bx-revision me-1"></i>{{ __('yojana::yojana.last_updated') }}:
                                            {{ $plan->updated_at->format('d M Y, h:i A') }}
                                        </span>
                                    @endif
                                </div>
                                <div>

                                    <a href="{{ route('admin.plans.index') }}"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="bx bx-arrow-back me-1"></i>{{ __('yojana::yojana.back_to_list') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="project-incharge" role="tabpanel">
                    <div class="card p-4">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="text-primary fw-bold mb-0">
                                {{ __('yojana::yojana.project_incharge') }}
                            </h5>
                            <div>
                                <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#projectInchargeModal"
                                    onclick="resetForm()">
                                    <i class="bx bx-plus"></i>{{ __('yojana::yojana.add_project_incharge') }}
                                </a>
                            </div>
                        </div>
                        <livewire:yojana.project_incharge_table theme="bootstrap-4" :$plan />

                        <div class="modal fade" id="projectInchargeModal" tabindex="-1"
                            aria-labelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary" id="ModalLabel">
                                            {{ __('yojana::yojana.project_incharge_detail_form') }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            onclick="resetForm()" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <livewire:yojana.project_incharge_form :action="App\Enums\Action::CREATE" :$plan />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="cost-estimation" role="tabpanel">
                    <div class="card p-4 mb-4">
                        <div class="card-body d-flex justify-content-between">
                            <h5 class="text-primary fw-bold mb-0">
                                {{ __('yojana::yojana.cost_estimation') }}
                            </h5>
                            @if ($plan->targetEntries()->exists() && $plan?->costEstimation?->status !== 'Approved')
                                <div>
                                    <a class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#costEstimationForwardModal" onclick="resetForm()">
                                        <i class="bx bx-send"></i> {{ __('yojana::yojana.forward') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="">
                            <livewire:yojana.cost_estimation_form :action="App\Enums\Action::CREATE" :$plan />
                        </div>
                    </div>

                    <div class="modal fade" id="costEstimationForwardModal" tabindex="-1"
                        aria-labelledby="ModalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-primary" id="ModalLabel">
                                        {{ __('yojana::yojana.forward') }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        onclick="resetForm()" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <livewire:yojana.cost_estimation_status_change_form :action="App\Enums\Action::CREATE" :$plan />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($plan->costEstimation()->exists())
                    <div class="tab-pane fade" id="target_entry" role="tabpanel">
                        <div class="card p-4 mb-4">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs mb-3" id="targetEntryTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="target-entry-table-tab" data-bs-toggle="tab"
                                        data-bs-target="#targetEntryTablePane" type="button" role="tab" onclick="resetTargetEntryForm()">
                                        {{ __('yojana::yojana.target_entry_table') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " id="target-entry-form-tab" data-bs-toggle="tab"
                                        data-bs-target="#targetEntryFormPane" type="button" role="tab">
                                        {{ __('yojana::yojana.target_entry_form') }}
                                    </button>
                                </li>

                            </ul>
                            <!-- Tab content -->
                            <div class="tab-content" id="targetEntryTabContent">
                                <div class="tab-pane fade show active" id="targetEntryTablePane" role="tabpanel">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="text-primary fw-bold mb-0">
                                            {{ __('yojana::yojana.target_entry') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <livewire:yojana.target_entry_table :$plan theme="bootstrap-4" />
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="targetEntryFormPane" role="tabpanel">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="text-primary fw-bold mb-0">
                                            {{ __('yojana::yojana.target_entry_form') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <livewire:yojana.target_entry_form :$plan />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($plan?->costEstimation?->status === 'Approved')
                        <div class="tab-pane fade" id="implementation_bodies" role="tabpanel">
                            <div class="card p-4">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="text-primary fw-bold mb-0">
                                        {{ __('yojana::yojana.implementation_bodies') }}
                                    </h5>
                                    <div>
                                        @if (!$plan->implementationAgencies()->exists())
                                            <a class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#implementationBodyModal" onclick="resetForm()">
                                                <i
                                                    class="bx bx-plus"></i>{{ __('yojana::yojana.add_implementation_body') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <livewire:yojana.implementation_agency_table theme="bootstrap-4" :$plan />
                                </div>

                            </div>
                            <div class="modal fade" id="implementationBodyModal" tabindex="-1"
                                aria-labelledby="ModalLabel" aria-hidden="true" data-bs-backdrop="static">
                                <div
                                    class="modal-dialog {{ $plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByQuotation ? 'modal-xl' : 'modal-lg' }} modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-primary" id="ModalLabel">
                                                {{ __('yojana::yojana.implementation_body_form') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                onclick="resetForm()" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <livewire:yojana.implementation_agency_form :action="App\Enums\Action::CREATE" :$plan />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if ($plan->implementationAgencies()->exists())
                            <div class="tab-pane fade" id="agreement" role="tabpanel">
                                <div class="card p-4 mb-4">
                                    <ul class="nav nav-tabs mb-3" id="agreementTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="agreement-table-tab"
                                                data-bs-toggle="tab" data-bs-target="#agreementTablePane"
                                                type="button" role="tab" onclick="resetAgreementForm()">
                                                {{ __('yojana::yojana.agreement_table') }}
                                            </button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="agreement-form-tab" data-bs-toggle="tab"
                                                data-bs-target="#agreementFormPane" type="button" role="tab">
                                                {{ __('yojana::yojana.add_agreement') }}
                                            </button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="agreement-cost-tab" data-bs-toggle="tab"
                                                data-bs-target="#agreementCostPane" type="button" role="tab">
                                                {{ __('yojana::yojana.agreement_cost') }}
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="agreementTabContent">
                                        <div class="tab-pane fade show active" id="agreementTablePane"
                                            role="tabpanel">
                                            <div class="card-header d-flex justify-content-between">
                                                <h5 class="text-primary fw-bold mb-0">
                                                    {{ __('yojana::yojana.agreement_list') }}
                                                </h5>

                                            </div>
                                            <div class="card-body">
                                                <livewire:yojana.agreement_table theme="bootstrap-4" :$plan />
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="agreementFormPane" role="tabpanel">
                                            <div class="card-header d-flex justify-content-between">
                                                <h5 class="text-primary fw-bold mb-0">
                                                    {{ __('yojana::yojana.agreement_form') }}
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <livewire:yojana.agreement_form :action="App\Enums\Action::CREATE" :$plan />
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="agreementCostPane" role="tabpanel">
                                            <div class="card-header d-flex justify-content-between">
                                                <h5 class="text-primary fw-bold mb-0">
                                                    {{ __('yojana::yojana.agreement_cost') }}
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <livewire:yojana.agreement_cost_form :action="App\Enums\Action::CREATE" :$plan />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="work-order" role="tabpanel">
                                <div class="card p-4">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="text-primary fw-bold mb-0">
                                            {{ __('yojana::yojana.work_order') }}
                                        </h5>
                                        <div>
                                            <a class="btn btn-info" target="_blank"
                                                href="{{ route('admin.plans.work_orders.create', ['plan_id' => $plan->id]) }}">
                                                <i class="bx bx-plus"></i>{{ __('yojana::yojana.add_work_order') }}
                                            </a>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <livewire:yojana.work_order_table theme="bootstrap-4" :planId="$plan->id" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="advance-payment" role="tabpanel">
                                <div class="card p-4">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="text-primary fw-bold mb-0">
                                            {{ __('yojana::yojana.advance_payment') }}
                                        </h5>
                                        <div>
                                            <a class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#indexModal3" onclick="resetForm()">
                                                <i class="bx bx-plus"></i>{{ __('yojana::yojana.add_payment') }}
                                            </a>
                                        </div>
                                    </div>
                                    <livewire:yojana.advance_payment_table theme="bootstrap-4" :$plan />
                                </div>
                                <div class="modal fade" id="indexModal3" tabindex="-1" aria-labelledby="ModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary" id="ModalLabel">
                                                    {{ __('yojana::yojana.advance_payment_form') }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    onclick="resetForm()" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <livewire:yojana.advance_payment_form :$plan :action="App\Enums\Action::CREATE" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @if ($category != 'program')
                                <div class="tab-pane fade" id="evaluation" role="tabpanel">
                                    <div class="card p-4">
                                        <div class="card-header d-flex justify-content-between">
                                            <h5 class="text-primary fw-bold mb-0">
                                                {{ __('yojana::yojana.evaluation') }}
                                            </h5>
                                            <div>
                                                {{-- <a href="{{ route('admin.evaluations.create') }}" class="btn btn-primary">
                                                <i class="bx bx-plus"></i> {{ __('yojana::yojana.add_evaluation') }}
                                            </a> --}}
                                                <ul class="nav nav-tabs mb-3" id="evaluationTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="table-tab"
                                                            data-bs-toggle="tab" data-bs-target="#evaluationTablePane"
                                                            type="button" role="tab"
                                                            onclick="resetEvaluationForm()">
                                                            {{ __('yojana::yojana.evaluation_table') }}
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="form-tab" data-bs-toggle="tab"
                                                            data-bs-target="#evaluationFormPane" type="button"
                                                            role="tab">
                                                            {{ __('yojana::yojana.add_evaluation') }}
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-content" id="evaluationTabContent">
                                            <div class="tab-pane fade show active" id="evaluationTablePane"
                                                role="tabpanel">
                                                <livewire:yojana.evaluation_table theme="bootstrap-4" :$plan />
                                            </div>

                                            <div class="tab-pane fade" id="evaluationFormPane" role="tabpanel">
                                                <livewire:yojana.evaluation_form :action="App\Enums\Action::CREATE" :$plan />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endif
                            <div class="tab-pane fade" id="target-completion" role="tabpanel">
                                <div class="card p-4">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="text-primary fw-bold mb-0">
                                            {{ __('yojana::yojana.target_completion') }}
                                        </h5>
                                        <div>
                                            {{-- <a href="{{ route('admin.evaluations.create') }}" class="btn btn-primary">
                                            <i class="bx bx-plus"></i> {{ __('yojana::yojana.add_evaluation') }}
                                        </a> --}}
                                            <ul class="nav nav-tabs mb-3" id="targetCompletionTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="target-completion-table-tab"
                                                            data-bs-toggle="tab" data-bs-target="#targetCompletionTablePane"
                                                            type="button" role="tab"
                                                            onclick="resetEvaluationForm()">
                                                        {{ __('yojana::yojana.target_completion_table') }}
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="target-completion-form-tab" data-bs-toggle="tab"
                                                            data-bs-target="#targetCompletionFormPane" type="button"
                                                            role="tab">
                                                        {{ __('yojana::yojana.add_target_completion') }}
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content" id="targetCompletionTabContent">
                                        <div class="tab-pane fade show active" id="targetCompletionTablePane"
                                             role="tabpanel">
                                            <livewire:yojana.target_completion_table theme="bootstrap-4" :$plan />
                                        </div>

                                        <div class="tab-pane fade" id="targetCompletionFormPane" role="tabpanel">
                                            <livewire:yojana.target_completion_form :action="App\Enums\Action::CREATE" :$plan />
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="document-upload" role="tabpanel">
                                <div class="card p-4">
                                    <div class="card-header">
                                        <h5 class="text-primary fw-bold mb-0">
                                            {{ __('yojana::yojana.document_upload') }}
                                        </h5>
                                    </div>
                                    <div class="card-body mx-3" wire:poll.1s>
                                        <livewire:yojana.document_upload_form :$plan />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="payment-tab" role="tabpanel">
                                <div class="card p-4">
                                    @if ($plan->payments->isNotEmpty())
                                        <livewire:yojana.payments_table :$plan />
                                    @else
                                        <div class="card-header d-flex justify-content-between">
                                            <h5 class="text-primary fw-bold mb-0">
                                                {{ __('yojana::yojana.payment') }}
                                            </h5>
                                        </div>
                                    @endif
                                        <livewire:yojana.payment_form :$plan :$category :action="App\Enums\Action::CREATE" />

                                </div>
                            </div>
                            <div class="tab-pane fade" id="extension-tab" role="tabpanel">
                                <div class="card p-4">
                                    <div class="card-header">
                                        <h5 class="text-primary fw-bold mb-0">
                                            {{ __('yojana::yojana.extend_date') }}
                                        </h5>
                                    </div>
                                    <div class="card-body mx-3" wire:poll.1s>
                                        <livewire:yojana.plan_extension_record_form :$plan />
                                    </div>
                                </div>

                                <div class="card p-4 mt-3">
                                    <div class="card-header">
                                        <h5 class="text-primary fw-bold mb-0">
                                            {{ __('yojana::yojana.extension_log') }}
                                        </h5>
                                    </div>
                                    <div class="card-body mx-3" wire:poll.1s>
                                        <livewire:yojana.plan_extension_record_table theme="bootstrap-4" :$plan />
                                    </div>
                                </div>
                            </div>


                            @if( $plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByContract ||
                                          $plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByNGO )

                                <div class="tab-pane fade" id="collateral-tab" role="tabpanel">
                                    <div class="card p-4 mb-4">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs mb-3" id="collateralTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="collateral-table-tab" data-bs-toggle="tab"
                                                        data-bs-target="#collateralTablePane" type="button" role="tab">
                                                    {{ __('yojana::yojana.collateral_table') }}
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link " id="collateral-form-tab" data-bs-toggle="tab"
                                                        data-bs-target="#collateralFormPane" type="button" role="tab">
                                                    {{ __('yojana::yojana.collateral_form') }}
                                                </button>
                                            </li>

                                        </ul>


                                        <!-- Tab content -->
                                        <div class="tab-content" id="collateralTabContent">
                                            <div class="tab-pane fade show active" id="collateralTablePane" role="tabpanel">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h5 class="text-primary fw-bold mb-0">
                                                        {{ __('yojana::yojana.collaterals') }}
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <livewire:yojana.collateral_table :$plan theme="bootstrap-4" />
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="collateralFormPane" role="tabpanel">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h5 class="text-primary fw-bold mb-0">
                                                        {{ __('yojana::yojana.collateral_form') }}
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <livewire:yojana.collateral_form :$plan :action="App\Enums\Action::CREATE"/>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                            </div>
                            @endif
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-layout.app>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabContainer = document.querySelector('.nav.nav-pills.primary');
        if (!tabContainer) return;
        function activateTabFromHash() {
            const hash = window.location.hash || '#plan-detail';
            const tabTrigger = tabContainer.querySelector('[data-bs-target="' + hash + '"]');
            if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        }

        // Update URL hash on tab shown
        tabContainer.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(tabBtn) {
            tabBtn.addEventListener('shown.bs.tab', function(e) {
                const target = e.target.getAttribute('data-bs-target');
                if (history.replaceState) {
                    history.replaceState(null, null, target);
                } else {
                    window.location.hash = target;
                }
            });
        });
        activateTabFromHash();
        window.addEventListener('hashchange', activateTabFromHash);
    });

    //Open Dynamic Modal
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', (data) => {
            $('#' + data.id).modal('hide');
            $('.modal-backdrop').remove();
            $('.modal').on('hidden.bs.modal', function() {
                $('body').removeClass('modal-open').css({
                    'overflow': '',
                    'padding-right': ''
                });
            });
        });
    });

    //Close Dynamic modal
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-modal', (data) => {
            const modalElement = document.getElementById(data.id);
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        });
    });

    Livewire.on('reload_page', () => {
        window.location.reload();
    });

    Livewire.on('open-editEvaluation', () => {
        let evaluationMainTab = document.querySelector('[data-bs-target="#evaluation"]');
        if (evaluationMainTab) {
            let tab = new bootstrap.Tab(evaluationMainTab);
            tab.show();
        }
        let evaluationFormTab = document.querySelector('#form-tab');

        if (evaluationFormTab) {
            let innerTab = new bootstrap.Tab(evaluationFormTab);
            innerTab.show();
        }

    });

    Livewire.on('open-editAgreement', () => {
        let agreementMainTab = document.querySelector('[data-bs-target="#agreement"]');
        if (agreementMainTab) {
            let tab = new bootstrap.Tab(agreementMainTab);
            tab.show();
        }
        let agreementFormTab = document.querySelector('#agreement-form-tab');

        if (agreementFormTab) {
            let innerTab = new bootstrap.Tab(agreementFormTab);
            innerTab.show();
        }
    });

    Livewire.on('open-evaluationTable', () => {

        let evaluationMainTab = document.querySelector('[data-bs-target="#evaluation"]');
        if (evaluationMainTab) {
            let tab = new bootstrap.Tab(evaluationMainTab);
            tab.show();
        }
        let tableTab = document.querySelector('#table-tab');
        if (tableTab) {
            let tab = new bootstrap.Tab(tableTab);
            tab.show();
        }
    });

    Livewire.on('open-agreementTable', () => {

        let agreementMainTab = document.querySelector('[data-bs-target="#agreement"]');
        if (agreementMainTab) {
            let tab = new bootstrap.Tab(agreementMainTab);
            tab.show();
        }
        let tableTab = document.querySelector('#agreement-table-tab');
        if (tableTab) {
            let tab = new bootstrap.Tab(tableTab);
            tab.show();
        }
    });

    // Open Dynamic tab
    function activateTab(selector) {
        const tabTrigger = document.querySelector(selector);
        if (tabTrigger) {
            new bootstrap.Tab(tabTrigger).show();
        }
    }

    Livewire.on('open-targetEntryForm', () => {
        activateTab('[data-bs-target="#target_entry"]');
        activateTab('#target-entry-form-tab');
    });
    Livewire.on('open-targetEntryTable', () => {
        activateTab('[data-bs-target="#target_entry"]');
        activateTab('#target-entry-table-tab');
    });
    Livewire.on('open-targetCompletionForm', () => {
        activateTab('[data-bs-target="#target_completion"]');
        activateTab('#target-completion-form-tab');
    });
    Livewire.on('open-targetCompletionTable', () => {
        activateTab('[data-bs-target="#target_completion"]');
        activateTab('#target-completion-table-tab');
    });
    Livewire.on('open-payment-tab', () => {
        activateTab('[data-bs-target="#payment-tab"]');
        activateTab('#payment-tab');
    });
    Livewire.on('open-collateral-form', () => {
        activateTab('[data-bs-target="#collateralFormPane"]');
        activateTab('#collateral-form-tab');
    });


    function resetAgreementForm() {
        Livewire.dispatch('reset-form-agreement');
    }
    function resetTargetEntryForm() {
        Livewire.dispatch('reset-target-entry-form');
    }
    function resetForm() {
        Livewire.dispatch('reset-form');
    }
</script>
@push('styles')
    <style>
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .divider::before {
            margin-right: 1rem;
        }

        .divider::after {
            margin-left: 1rem;
        }

        .divider-primary::before,
        .divider-primary::after {
            border-color: rgba(var(--bs-primary-rgb), 0.2);
        }

        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            background-color: #0d6efd;
            /* Bootstrap primary color */
            color: #fff;
        }
    </style>
@endpush
