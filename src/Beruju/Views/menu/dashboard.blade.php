<x-layout.app header="{{ __('beruju::beruju.beruju_management') }}">
    <div class="row mb-4">
        <div class="col-12">
            <div class="row g-3">
                <!-- Total Beruju Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-border-shadow-primary h-100 rounded-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-file bx-lg"></i>
                                </span>
                            </div>
                            <div>
                                <h3 class="card-title mb-1">
                                    {{ replaceNumbersWithLocale($resolvedCount + $unresolvedCount, true) }}
                                </h3>
                                <p class="mb-0 text-muted">
                                    {{ __('beruju::beruju.total_beruju') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Amount Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-border-shadow-success h-100 rounded-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-money bx-lg"></i>
                                </span>
                            </div>
                            <div>
                                <h3 class="card-title mb-1">
                                    {{ __('beruju::beruju.npr') }}
                                    {{ replaceNumbersWithLocale($berujuCategoryAmount->sum('total_amount'), true) }}
                                </h3>
                                <p class="mb-0 text-muted">
                                    {{ __('beruju::beruju.total_amount') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Overdue Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-border-shadow-warning h-100 rounded-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-time bx-lg"></i>
                                </span>
                            </div>
                            <div>
                                <h3 class="card-title mb-1">
                                    {{ replaceNumbersWithLocale($totalOverdue, true) }}
                                </h3>
                                <p class="mb-0 text-muted">
                                    {{ __('beruju::beruju.total_overdue') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Multi-Year Outstanding Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-border-shadow-danger h-100 rounded-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="bx bx-calendar-x bx-lg"></i>
                                </span>
                            </div>
                            <div>
                                <h3 class="card-title mb-1">
                                    {{ replaceNumbersWithLocale($totalMultiYearOutStanding, true) }}
                                </h3>
                                <p class="mb-0 text-muted">
                                    {{ __('beruju::beruju.multi_year_outstanding') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="row">

            <div class="col-md-7 d-flex flex-column">
                <div class="card flex-fill mb-3 rounded-0">

                    <div class="card-header d-flex justify-content-between align-items-center m-1 p-3">
                        <h5 class="card-title mb-0">{{ __('beruju::beruju.beruju_status_distribution') }}</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary me-2">
                                {{ $currentFiscalYear }}
                            </span>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <canvas id="berujuPieChart" width="400" height="300"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="w-3 h-3 rounded-circle bg-success me-2"></div>
                                        <span class="text-muted">{{ __('beruju::beruju.resolved') }}</span>
                                        <span class="ms-auto fw-bold">{{ $resolvedCount }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="w-3 h-3 rounded-circle bg-warning me-2"></div>
                                        <span class="text-muted">{{ __('beruju::beruju.unresolved') }}</span>
                                        <span class="ms-auto fw-bold">{{ $unresolvedCount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card flex-fill mb-3 rounded-0">

                    <div class="card-header d-flex justify-content-between align-items-center m-1 p-3">
                        <h5 class="card-title mb-0">{{ __('beruju::beruju.beruju_by_department') }}</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary me-2">
                                {{ $currentFiscalYear }}
                            </span>

                        </div>
                    </div>


                    <div class="card-body">
                        <canvas id="departmentBarChart" width="400" height="300"></canvas>
                    </div>
                </div>

            </div>


            <div class="col-md-5 d-flex flex-column">
                <div class="card flex-fill mb-3 rounded-0">
                    <div
                        class="card-header d-flex justify-content-between align-items-center border-card-topic m-1 p-3">
                        <h5 class="card-title mb-0">{{ __('beruju::beruju.recent_beruju_entries') }}</h5>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.beruju.registration.index') }}" class="btn btn-success me-1">
                                {{ __('beruju::beruju.show_all') }}
                            </a>
                            <a href="{{ route('admin.beruju.registration.create') }}" class="btn btn-primary">
                                {{ __('beruju::beruju.add_beruju') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body m-0 p-2 table-container">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('beruju::beruju.beruju_category') }}</th>
                                        <th>{{ __('beruju::beruju.fiscal_year_id') }}</th>
                                        <th>{{ __('beruju::beruju.status') }}</th>
                                        <th>{{ __('beruju::beruju.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allBeruju as $beruju)
                                        <tr>
                                            <td>{{ $beruju->beruju_category?->label() }}</td>
                                            <td>{{ $beruju->fiscalYear?->year }}</td>
                                            <td>{{ $beruju->status?->label() }}</td>
                                            <td>{{ replaceNumbersWithLocale($beruju->amount, true) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                {{ __('beruju::beruju.no_beruju_entries_found') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card flex-fill mb-3 rounded-0">
                    <div
                        class="card-header border-card-topic d-flex justify-content-between align-items-center m-1 p-3">
                        <h5 class="card-title mb-0">{{ __('beruju::beruju.category_amount_summary') }}</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary me-2">
                                {{ __('beruju::beruju.total') }}: {{ __('beruju::beruju.npr') }}
                                {{ replaceNumbersWithLocale($berujuCategoryAmount->sum('total_amount'), true) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body m-0 p-2">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Total Count</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($berujuCategoryAmount as $item)
                                        <tr>
                                            <td>{{ $item['category'] }}</td>
                                            <td>{{ replaceNumbersWithLocale($item['total_count'], true) }}</td>
                                            <td>{{ replaceNumbersWithLocale($item['total_amount'], true) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No entries found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="card flex-fill mb-3 rounded-0">
                    <div class="card-header border-card-topic d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ __('beruju::beruju.fiscal_year_summary') }}</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary me-2">
                                {{ __('beruju::beruju.total_registration') }}:
                                {{ replaceNumbersWithLocale($berujuByFiscalYear->sum('total_count'), true) }}
                            </span>

                        </div>
                    </div>
                    <div class="card-body m-0 p-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('beruju::beruju.fiscal_year') }}</th>
                                        <th>{{ __('beruju::beruju.total') }}</th>
                                        <th>{{ __('beruju::beruju.resolved') }}</th>
                                        <th>{{ __('beruju::beruju.archived') }}</th>
                                        <th>{{ __('beruju::beruju.rejected') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($berujuByFiscalYear as $item)
                                        <tr>
                                            <td>{{ $item['fiscal_year'] }}</td>
                                            <td>{{ replaceNumbersWithLocale($item['total_count'], true) }}</td>
                                            <td class="text-success">
                                                {{ replaceNumbersWithLocale($item['resolved_count'], true) }}</td>
                                            <td class="text-secondary">
                                                {{ replaceNumbersWithLocale($item['archived_count'], true) }}</td>
                                            <td class="text-danger">
                                                {{ replaceNumbersWithLocale($item['rejected_count'], true) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                {{ __('beruju::beruju.no_fiscal_year_data_found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .table-container {
                max-height: 300px;

                overflow-y: auto;
                overflow-x: hidden;
            }

            .table-container::-webkit-scrollbar {
                width: 0px;
                background: transparent;
            }

            .table-container {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .border-card-topic {
                border-bottom: 1px solid black;
            }
        </style>
    @endpush


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Pie Chart
                const ctx = document.getElementById('berujuPieChart').getContext('2d');

                const berujuPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['{{ __('beruju::beruju.resolved') }}',
                            '{{ __('beruju::beruju.unresolved') }}'
                        ],
                        datasets: [{
                            data: [{{ $resolvedCount }}, {{ $unresolvedCount }}],
                            backgroundColor: [
                                '#1565c0', // Success green for resolved
                                '#f44336' // Warning yellow for unresolved
                            ],

                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });

                // Simple Bar Chart for Department/Branch
                const barCtx = document.getElementById('departmentBarChart').getContext('2d');

                const departmentData = @json($departmentBeruju);
                const labels = Object.values(departmentData).map(item => item.branch_name);
                const counts = Object.values(departmentData).map(item => item.count);

                const departmentBarChart = new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: '{{ __('beruju::beruju.total_beruju') }}',
                            data: counts,
                            backgroundColor: '#007bff',
                            borderColor: '#0056b3',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `{{ __('beruju::beruju.total_beruju') }}: ${context.parsed.y}`;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

</x-layout.app>
