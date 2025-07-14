<x-layout.app header="{{ __('filetracking::filetracking.darta_chalani_dashboard') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <canvas id="dartaChalaniChart" height="600rem"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="col-lg-12 col-md-12 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="bx bxs-receipt bx-lg"></i></span>
                            </div>
                            <h3 class="card-title mb-2">{{ $totalChalani }}</h3>
                        </div>
                        <p class="mb-2">{{ __('filetracking::filetracking.total_chalani') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="bx bxs-receipt bx-lg"></i></span>
                            </div>
                            <h3 class="card-title mb-2">{{ $totalDarta }}</h3>
                        </div>
                        <p class="mb-2">{{ __('filetracking::filetracking.total_darta') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const ctx = document.getElementById('dartaChalaniChart').getContext('2d');

            const monthLabels = @json(array_column($monthlyData, 'nepali_month'));
            const dartaData = @json(array_column($monthlyData, 'not_chalani_count'));
            const chalaniData = @json(array_column($monthlyData, 'chalani_count'));

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {{ __('monthLabels') }},
                    datasets: [{
                            label: '{{ __('filetracking::filetracking.darta') }}',
                            data: dartaData,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)', // Red
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: '{{ __('filetracking::filetracking.chalani') }}',
                            data: chalaniData,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)', // Blue
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '{{ __('filetracking::filetracking.count') }}'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: '{{ __('filetracking::filetracking.months') }}'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-layout.app>
