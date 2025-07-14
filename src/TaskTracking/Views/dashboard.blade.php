<x-layout.app header="{{ __('tasktracking::tasktracking.task_tracking_dashboard') }}">
    <div class="row">
        <!-- Total Tasks -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-folder bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($totalProjectCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('tasktracking::tasktracking.total_projects') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-briefcase bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($totalTaskType, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('tasktracking::tasktracking.total_task_type') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-task bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{replaceNumbersWithLocale($totalTaskCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('tasktracking::tasktracking.total_task') }}</p>
                </div>
            </div>
        </div>

        <!-- Total Todo Tasks -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-list-ul bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{replaceNumbersWithLocale($taskTodoCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('tasktracking::tasktracking.total_todo_task') }}</p>
                </div>
            </div>
        </div>

        <!-- Total In Progress Tasks -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-loader bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{replaceNumbersWithLocale($taskInProgressCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('tasktracking::tasktracking.total_inprogress_task') }}</p>
                </div>
            </div>
        </div>
        <!-- Total Completed Tasks -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-check-circle bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{replaceNumbersWithLocale($taskCompletedCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('tasktracking::tasktracking.total_completed_task') }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="row row-bordered g-0">
                <div class="col-md-12">
                    <h5 class="card-header m-0 me-2 pb-3">{{ __('tasktracking::tasktracking.total_project') }}</h5>
                    <div id="projectTaskChart" class="px-2"></div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                var projectOptions = {
                    series: [{
                        name: '{{ __('tasktracking::tasktracking.tasks') }}',
                        data: [
                            @foreach ($projectChart as $count)
                                {{ $count }},
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
                                position: 'top', // top, center, bottom
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
                            @foreach ($projectChart as $projectTitle => $count)
                                '{{ $projectTitle }}',
                            @endforeach
                        ],
                        position: 'top',
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        crosshairs: {
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    colorFrom: '#D8E3F0',
                                    colorTo: '#BED1E6',
                                    stops: [0, 100],
                                    opacityFrom: 0.4,
                                    opacityTo: 0.5,
                                }
                            }
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
                            show: true,
                            formatter: function(val) {
                                return val;
                            }
                        }
                    },
                    title: {
                        text: '{{ __('tasktracking::tasktracking.tasks_per_project') }}',
                        floating: true,
                        offsetY: 330,
                        align: 'center',
                        style: {
                            color: '#444'
                        }
                    }
                };

                var projectChart = new ApexCharts(document.querySelector("#projectTaskChart"), projectOptions);
                projectChart.render();
            </script>
        @endpush

    </div>
</x-layout.app>
