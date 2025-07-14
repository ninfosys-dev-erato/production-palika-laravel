<x-layout.app header="{{ __('grievance::grievance.grievance_dashboard') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row">
        <!-- Welcome Section -->

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-receipt bx-lg"></i></span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($grievanceCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('grievance::grievance.total_grievances') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-receipt bx-lg"></i></span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($grievancesUnseenCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('grievance::grievance.total_unseen_grievance') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-receipt bx-lg"></i></span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($grievancesInvestigatingCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('grievance::grievance.investigating_grievance') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-receipt bx-lg"></i></span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($grievancesClosedCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('grievance::grievance.total_closed_grievance') }}</p>
                </div>
            </div>
        </div>

        <!-- Grievance Status Chart -->
        <div class="col-lg-5">
            <div class="card">
                <h5 class="card-header">{{ __('grievance::grievance.grievance_status_distribution') }}</h5>
                <div id="grievanceStatusChart" class="px-4 py-3"></div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <h5 class="card-header">{{ __('grievance::grievance.weekly_grievance_status_chart') }}</h5>
                <canvas id="weeklyGrievanceStatusChart" class="px-4 py-3" style="margin-top:-50px"></canvas>

            </div>
        </div>

    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Grievance Status Chart Configuration
                var grievanceStatusOptions = {
                    series: [
                        @foreach ($grievanceChart as $statusCount)
                            {{ $statusCount }}{{ $loop->last ? '' : ',' }}
                        @endforeach
                    ],
                    chart: {
                        type: 'pie',
                        width: '100%'
                    },
                    labels: [
                        @foreach ($grievanceChart as $status => $count)
                            '{{ \Src\Grievance\Enums\GrievanceStatusEnum::tryFrom($status)->label() }}'
                            {{ $loop->last ? '' : ',' }}
                        @endforeach
                    ],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }]
                };

                var grievanceStatusChart = new ApexCharts(
                    document.querySelector("#grievanceStatusChart"),
                    grievanceStatusOptions
                );

                grievanceStatusChart.render();
            });

            document.addEventListener("DOMContentLoaded", function () {
                const canvasElement = document.getElementById('weeklyGrievanceStatusChart');
                const ctx = canvasElement.getContext('2d');

                const config = {
                    type: 'bar',
                    data: @json($data),
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                            }
                        }
                    }
                };
                new Chart(ctx, config);
            });

        </script>
    @endpush


</x-layout.app>
