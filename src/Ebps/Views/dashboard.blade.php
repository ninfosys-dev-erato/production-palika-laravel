<x-layout.app header="{{ __('ebps::ebps.dashboard') }}">
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
                        <h3 class="card-title mb-2">{{ $OrganizationCount }}</h3>
                    </div>
                    <p class="mb-2">{{ __('ebps::ebps.total_organization') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-category-alt bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ $MapApply }}</h3>
                    </div>
                    <p class="mb-2">{{ __('ebps::ebps.total_map_applied') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-category-alt bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ $ProcessingMapApply }}</h3>
                    </div>
                    <p class="mb-2">{{ __('ebps::ebps.total_processing_map_applied') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-category-alt bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ $CompletedMapApply }}</h3>
                    </div>
                    <p class="mb-2">{{ __('ebps::ebps.total_map_applied_completed') }}</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <h5 class="card-header">{{ __('ebps::ebps.total_ebps_charts') }}</h5>
                <div id="ebpsChart" class="px-4 py-3"></div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ebpsChartOptions = {
                    series: [{
                        name: '{{ __('ebps::ebps.recommendations') }}',
                        data: [
                            @foreach ($EbpsChart as $EbpsData)
                                '{{ $EbpsData }}'
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
                            @foreach ($EbpsChart as $title => $count)
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
                        text: '{{ __('ebps::ebps.ebps_chart_taken') }}',
                        floating: true,
                        offsetY: 330,
                        align: 'center',
                        style: {
                            color: '#444'
                        }
                    }
                };

                var ebpsChart = new ApexCharts(document.querySelector("#ebpsChart"),
                    ebpsChartOptions);
                ebpsChart.render();
            });
        </script>
    @endpush



</x-layout.app>