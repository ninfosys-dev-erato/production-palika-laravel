@php
    function getTextColor($status)
    {
        switch (strtolower($status)) {
            case 'pending':
                return ' text-warning';
            case 'rejected':
                return ' text-danger';
            case 'sent for payment':
                return ' text-primary';
            case 'bill uploaded':
                return ' text-primary';
            case 'sent for approval':
                return ' text-success';
            case 'accepted':
                return ' text-success fw-bold';
            default:
                return ' text-dark';
        }
    }
@endphp

<x-layout.customer-app header="{{ __('recommendation::recommendation.recommendation_details') }}">
    <div class="container">
        <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a
                        href="#">{{ __('recommendation::recommendation.apply_recommendation_detail') }}</a>
                </li>
            </ol>
        </nav>
        <div class="col-md-12">
            <div class="">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('recommendation::recommendation.recommendation_details') }}</h5>
                    <a href="{{ route('customer.recommendations.apply-recommendation.index') }}" class="btn btn-info"><i
                            class="bx bx-list-ul"></i>{{ __('recommendation::recommendation.apply_recommendation_list') }}</a>
                </div>
                <div class="col-12">
                    <div class="card mb-5 shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <div class="row gy-3">
                                <div class="col-md-4 col-12">
                                    <i class="bx bx-user text-secondary me-2"></i>
                                    <span class="fw-medium">{{ __('recommendation::recommendation.name') }}:</span>
                                    <span class="text-dark">{{ $applyRecommendation->customer?->name }}</span>
                                </div>
                                <div class="col-md-4 col-12">
                                    <i class="bx bx-user text-secondary me-2"></i>
                                    <span class="fw-medium">{{ __('recommendation::recommendation.email') }}:</span>
                                    <a href="mailto:{{ $applyRecommendation->customer?->email }}"
                                        class="text-decoration-underline text-dark">
                                        {{ $applyRecommendation->customer?->email ?? 'Not Provided' }}
                                    </a>
                                </div>
                                <div class="col-md-4 col-12">
                                    <i class="bx bx-user text-secondary me-2"></i>
                                    <span
                                        class="fw-medium">{{ __('recommendation::recommendation.phone_number') }}:</span>
                                    <a href="tel:{{ $applyRecommendation->customer?->mobile_no }}" class="text-dark">
                                        {{ $applyRecommendation->customer?->mobile_no }}
                                    </a>
                                </div>

                                <div class="col-md-4 col-12">
                                    <i class="bx bx-category text-secondary me-2"></i>
                                    <span
                                        class="fw-medium">{{ __('recommendation::recommendation.recommendation') }}:</span>
                                    <span
                                        class="text-primary">{{ $applyRecommendation->recommendation?->title }}</span>
                                </div>

                                <div class="col-md-4 col-12">
                                    <i class="bx bx-code text-secondary me-2"></i>
                                    <span
                                        class="fw-medium">{{ __('recommendation::recommendation.ltax_ebp_code') }}:</span>
                                    <span class="text-dark">{{ $applyRecommendation->ltax_ebp_code }}</span>
                                </div>

                                <div class="col-md-4 col-12">
                                    <i class="bx bx-comment-detail text-secondary me-2"></i>
                                    <span class="fw-medium">{{ __('recommendation::recommendation.remarks') }}:</span>
                                    <span class="text-dark">{{ $applyRecommendation->remarks }}</span>
                                </div>

                                <div class="col-md-4 col-12">
                                    <i class="bx bx-calendar-check text-secondary me-2"></i>
                                    <span class="fw-medium">{{ __('recommendation::recommendation.status') }}:</span>
                                    <span class="{{ getTextColor($applyRecommendation->status->value) }} fw-bold">
                                        {{ $applyRecommendation->status->label() }}
                                    </span>
                                </div>

                                @if ($applyRecommendation->status == Src\Recommendation\Enums\RecommendationStatusEnum::REJECTED)
                                    <div class="col-md-4 col-12">
                                        <i class="bx bx-error text-danger me-2"></i>
                                        <span
                                            class="fw-medium">{{ __('recommendation::recommendation.reason') }}:</span>
                                        <span class="text-danger">{{ $applyRecommendation->rejected_reason }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-grievance-detail"
                                aria-controls="navs-pills-recommendation-detail" aria-selected="false">
                                {{ __('recommendation::recommendation.recommendation_detail') }}
                            </button>
                        </li>
                        @if (
                            $applyRecommendation->status != Src\Recommendation\Enums\RecommendationStatusEnum::PENDING &&
                                $applyRecommendation->recommendation->revenue > 0)
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-bill" aria-controls="navs-pills-nill"
                                    aria-selected="false">
                                    {{ __('recommendation::recommendation.payment') }}
                                </button>
                            </li>
                        @endif

                        @if ($applyRecommendation->status === Src\Recommendation\Enums\RecommendationStatusEnum::ACCEPTED)
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-letter" aria-controls="navs-pills-letter"
                                    aria-selected="false">
                                    {{ __('recommendation::recommendation.recommendation_letter') }}
                                </button>
                            </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-logs" aria-controls="navs-pills-logs" aria-selected="false">
                                {{ __('recommendation::recommendation.recommendation_logs') }}
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card" style="position: relative;">
                    @if ($applyRecommendation->status === Src\Recommendation\Enums\RecommendationStatusEnum::ACCEPTED)
                        <div class="position-absolute top-0 end-0 m-3 d-flex gap-2">
                            <div class="btn-group" role="group" aria-label="Recommendation Actions">
                                <button type="button" class="btn btn-info"
                                    onclick="Livewire.dispatch('print-customer-recommendation')"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="{{ __('recommendation::recommendation.print_recommendation') }}">
                                    <i class="bx bx-printer"></i> {{ __('recommendation::recommendation.print') }}
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-pills-grievance-detail" role="tabpanel">
                                <livewire:customer_portal.recommendation.apply_recommendation_show
                                    :$applyRecommendation />
                            </div>

                            <div class="tab-pane fade" id="navs-pills-bill" role="tabpanel">
                                <livewire:customer_portal.recommendation.apply_recommendation_upload_bill
                                    :$applyRecommendation />
                            </div>

                            <div class="tab-pane fade" id="navs-pills-letter" role="tabpanel">
                                <div class="col-md-12">
                                    <div style="border-radius: 10px; text-align: center;">
                                        <div id="printContent" style="width: 210mm; display: inline-block;">
                                            <livewire:customer_portal.recommendation.customer_apply_recommendation_print
                                                :$applyRecommendation />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="navs-pills-logs" role="tabpanel">
                                <div class="col-md-12">
                                    <livewire:recommendation.apply_recommendation_assign :apply-recommendation="$applyRecommendation->id" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout.customer-app>
@push('scripts')
    <script>
        Livewire.on('showRejectModal', () => {
            $('#rejectModal').modal('show');
        });
    </script>
    <script>
        function printDiv() {
            const printContents = document.getElementById('printContent').innerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();

            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endpush
