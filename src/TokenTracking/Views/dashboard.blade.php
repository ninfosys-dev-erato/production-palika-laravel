<x-layout.app header="{{ __('tokentracking::tokentracking.register_token_list') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row">

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-receipt bx-lg"></i></span>
                        </div>
                        <h3 class="card-title mb-2">{{ $totalCount }}</h3>
                    </div>
                    <p class="mb-2">{{ __('tokentracking::tokentracking.total_token') }}</p>
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
                        <h3 class="card-title mb-2">{{ $totalEntry }}</h3>
                    </div>
                    <p class="mb-2">{{ __('tokentracking::tokentracking.entered_token') }}</p>
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
                        <h3 class="card-title mb-2">{{ $totalExit }}</h3>
                    </div>
                    <p class="mb-2">{{ __('tokentracking::tokentracking.completed_token') }}</p>
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
                        <h3 class="card-title mb-2">{{ $totalRejected }}</h3>
                    </div>
                    <p class="mb-2">{{ __('tokentracking::tokentracking.rejected_token') }}</p>
                </div>
            </div>
        </div>

        <!-- Token Status Chart -->
        <div class="col-lg-6" style="height: 400px;">
            <div class="card">
                <h5 class="card-header">{{ __('tokentracking::tokentracking.citizen_satisfaction_feedback') }}</h5>
                <div class="card-body">
                    <canvas id="tokenStatusPieChart" max-width="400px" max-height="200px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6" style="height: 400px;">
            <div class="card">
                <h5 class="card-header">{{ __('tokentracking::tokentracking.top_branches_by_token_count') }}</h5>
                <div class="card-body">
                    <canvas id="branchChartCanvas" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-2" style="height: 400px;">
            <div class="card">
                <h5 class="card-header">{{ __('tokentracking::tokentracking.token_type_statistics') }}</h5>
                <div class="card-body">
                    <canvas id="tokenTypeBarChart" max-width="400px" max-height="200px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-4" style="height: 400px;">
            <div class="card">
                <h5 class="card-header">{{ __('tokentracking::tokentracking.token_stage_statistics') }}</h5>
                <div class="card-body">
                    <canvas id="tokenStagePieChart" max-width="400px" max-height="200px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Token Status Pie Chart
        const ctx = document.getElementById('tokenStatusPieChart').getContext('2d');
        const tokenFeedbackLabels = @json(array_keys($feedback));
        const tokenFeedbackData = @json(array_values($feedback));
        const tokenStatusChartData = {
            labels: tokenFeedbackLabels,
            datasets: [{
                label: 'Citizen Satisfaction Feedback',
                data: tokenFeedbackData,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)', // Blue
                    'rgba(75, 192, 192, 0.6)', // Green
                    'rgba(255, 99, 132, 0.6)' // Red
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        };
        new Chart(ctx, {
            type: 'pie',
            data: tokenStatusChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        // Token Stage Pie Chart
        const ctxStage = document.getElementById('tokenStagePieChart').getContext('2d');
        const tokenStageLabels = @json(array_keys($tokenStatStage));
        const tokenStageData = @json(array_values($tokenStatStage));
        const tokenStageChartData = {
            labels: tokenStageLabels,
            datasets: [{
                label: 'Token Stage Distribution',
                data: tokenStageData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)', // Red
                    'rgba(54, 162, 235, 0.6)', // Blue
                    'rgba(75, 192, 192, 0.6)', // Green
                    'rgba(255, 206, 86, 0.6)', // Yellow
                    'rgba(153, 102, 255, 0.6)' // Purple
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };
        new Chart(ctxStage, {
            type: 'pie',
            data: tokenStageChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        // Branch Bar Chart
        const branchCtx = document.getElementById('branchChartCanvas').getContext('2d');
        const branchLabels = @json($tokenBranchCounts->map(fn($b) => $b->currentBranch?->title));
        const branchData = @json($tokenBranchCounts->pluck('total'));
        new Chart(branchCtx, {
            type: 'bar',
            data: {
                labels: branchLabels,
                datasets: [{
                    label: 'Token Count',
                    data: branchData,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Token Type Bar Chart
        const typeCtx = document.getElementById('tokenTypeBarChart').getContext('2d');
        const purposeLabels = @json(array_keys($purpose));
        const purposeData = @json(array_values($purpose));
        new Chart(typeCtx, {
            type: 'bar',
            data: {
                labels: purposeLabels,
                datasets: [{
                    label: 'Token Count',
                    data: purposeData,
                    backgroundColor: 'rgba(10, 220, 255, 0.6)',
                    borderColor: 'rgba(10, 220, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-layout.app>
