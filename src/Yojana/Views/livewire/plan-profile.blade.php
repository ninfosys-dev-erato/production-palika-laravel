<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex align-items-start p-4">
        <!-- Icon -->
        <div class="me-4">
            <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle shadow-sm"
                 style="width: 64px; height: 64px;">
                <i class="bx bx-bar-chart fs-3"></i>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-grow-1 p-2 w-100">
            <div class="d-flex justify-content-between align-items-start mb-4" wire:key="status-{{ $statusKey }}">
                <h4 class="fw-bold text-primary mb-0">
                    {{ $plan->project_name ?? 'N/A' }}
                </h4>
                <span class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill text-white"
                      style="background-color: {{ $color}}; font-size: 0.9rem;">
                    <i class="bx {{ $icon }} fs-5"></i>
                    {{ $label }}
                </span>
            </div>

            <!-- Project Details -->
            <div class="row g-3 mb-3">
                <div class="col-md-6 d-flex align-items-center">
                    <i class="bx bx-map-pin text-primary me-2"></i>
                    <span class="text-gray me-1">{{ __('yojana::yojana.address') }}:</span>
                    <strong class="text-black">{{ $plan->location ?? 'N/A' }}</strong>
                </div>

                <div class="col-md-6 d-flex align-items-center">
                    <i class="bx bx-buildings text-primary me-2"></i>
                    <span class="text-gray me-1">{{ __('yojana::yojana.ward_no') }} :</span>
                    <strong class="text-black">{{ app()->getLocale() === "en" ? ($plan->ward->ward_name_en ?? $plan->ward->ward_name_ne) : ($plan->ward->ward_name_ne ?? $plan->ward->ward_name_en) ?? 'N/A' }}</strong>
                </div>

                <div class="col-md-6 d-flex align-items-center">
                    <i class="bx bx-cog text-primary me-2"></i>
                    <span class="text-gray me-1">{{ __('yojana::yojana.implementation_method') }}:</span>
                    <strong class="text-black">{{ $plan->implementationMethod->title ?? 'N/A' }}</strong>
                </div>

                <div class="col-md-6 d-flex align-items-center">
                    <i class="bx bx-target-lock text-primary me-2"></i>
                    <span class="text-gray me-1">{{ __('yojana::yojana.targeted') }}:</span>
                    <strong class="text-black">{{ $plan->target->title ?? 'N/A' }}</strong>
                </div>
            </div>

            <hr class="my-3">

            <!-- Budget and Reference -->
            <div class="row g-3">
                <div class="col-md-6 d-flex align-items-center">
                    <i class="bx bx-wallet text-primary me-2"></i>
                    <span class="text-gray me-1">{{ __('yojana::yojana.allocated_budget') }}:</span>
                    <strong class="text-black">
                        {{ $plan->allocated_budget ? __('yojana::yojana.npr') . replaceNumbersWithLocale(number_format($plan->allocated_budget, 2),true) : 'N/A' }}
                    </strong>
                </div>

                <div class="col-md-6 d-flex align-items-center">
                    <i class="bx bx-file text-primary me-2"></i>
                    <span class="text-gray me-1">{{ __('yojana::yojana.red_book_detail') }}:</span>
                    <strong class="text-black">{{ replaceNumbersWithLocale($plan->red_book_detail, true) ?? 'N/A' }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
