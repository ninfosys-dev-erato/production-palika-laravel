<x-layout.app header="{{ __('recommendation::recommendation.recommendation_dashboard') }}">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-category-alt bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($recommendationCount,true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('recommendation::recommendation.total_recommendation_categories') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="bx bx-file bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($appliedRecommendationCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('recommendation::recommendation.total_applied_recommendation') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-hourglass bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($pendingCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('recommendation::recommendation.pending_recommendation') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-money bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($sentForPaymentCount,true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('recommendation::recommendation.sent_for_payment_recommendation') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-secondary">
                                <i class="bx bx-upload bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($billUploadedCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('recommendation::recommendation.bill_uploaded_recommendation') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-send bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($sentForApprovalCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('recommendation::recommendation.sent_for_approval_recommendation') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bx-x-circle bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($rejectedCount,true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('recommendation::recommendation.rejected_recommendation') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-check-circle bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($acceptedCount,true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('recommendation::recommendation.accepted_recommendation') }}</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <h5 class="card-header">{{ __('recommendation::recommendation.recommendations_distribution') }}</h5>
                <div id="totalRecommendationChart" class="px-4 py-3"></div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var recommendationOptions = {
                    series: [{
                        name: '{{ __('recommendation::recommendation.recommendations') }}',
                        data: [
                            @foreach ($recommendationChart as $recommendationData)
                                '{{ $recommendationData }}'
                                {{ $loop->last ? '' : ',' }}
                            @endforeach
                        ]
                    }],
                    chart: {
                        height: 350,
                        type: 'bar',
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 10,
                            dataLabels: {
                                position: 'top',
                            },
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return val;
                        },
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: ["#304758"]
                        }
                    },
                    xaxis: {
                        categories: [
                            @foreach ($recommendationChart as $title => $count)
                                '{{ $title }}'
                                {{ $loop->last ? '' : ',' }}
                            @endforeach
                        ],
                        position: 'top',
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        tooltip: {
                            enabled: true,
                        }
                    },
                    yaxis: {
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false,
                        },
                        labels: {
                            show: false,
                            formatter: function(val) {
                                return val;
                            }
                        }
                    },
                    title: {
                        text: '{{ __('recommendation::recommendation.recommendation_taken') }}',
                        floating: true,
                        offsetY: 330,
                        align: 'center',
                        style: {
                            color: '#444'
                        }
                    }
                };

                var recommendationChart = new ApexCharts(document.querySelector("#totalRecommendationChart"),
                    recommendationOptions);
                recommendationChart.render();
            });
        </script>
    @endpush
</x-layout.app>
