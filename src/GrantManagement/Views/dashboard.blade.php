<x-layout.app header="{{ __('grantmanagement::grantmanagement.dashboard') }}">

    <div class="d-flex flex-row flex-wrap justify-content-start gap-4">

        <!-- Card 1 -->
        <div class="card card-border-shadow-primary flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="bx bxs-truck fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{__('grantmanagement::grantmanagement.total_farmers')}}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{ $TotalFarmers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-border-shadow-primary flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="bx bxs-building fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{__('grantmanagement::grantmanagement.total_cooperatives')}}
                        </h6>
                        <h3 class="mb-0 text-dark fw-bold">{{  $TotalCooperatives }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-border-shadow-primary flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="bx bxs-group fs-1"></i>

                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{__('grantmanagement::grantmanagement.total_groups')}}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{ $TotalGroups }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-border-shadow-primary flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="bx bxs-car fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{__('grantmanagement::grantmanagement.total_enterprises')}}
                        </h6>
                        <h3 class="mb-0 text-dark fw-bold">{{ $TotalEnterprises }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-12">
            <div class="card">
                <h5 class="card-header">
                    {{ __('Current financial ' . $currentFiscalYear->year . ' and ongoing grants by ward') }}</h5>
                <div id="wardCashChart" class="px-4 py-3"></div>
            </div>
        </div> -->

        <div class="col-12">
            <div class="card">
                <h5 class="card-header">
                    {{ __('grantmanagement::grantmanagement.grants_continue_as_per_the_current_fiscal_year') . ' (' . $currentFiscalYear->year . ')' }}
                </h5>
                <div id="grantContinueChart" class="px-4 py-3"></div>
            </div>
        </div>
    </div>

    <!-- @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var grantChartOptions = {
                    series: [{
                        name: '{{ __('grantmanagement::grantmanagement.cash') }}',
                        data: [
                            @foreach ($totalCashGrantsByWard as $item)
                                {{ $item['total_cash'] }}
                                {{ !$loop->last ? ',' : '' }}
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
                        formatter: function (val) {
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
                            @foreach ($totalCashGrantsByWard as $item)
                                '{{ $item['ward_name'] }}'
                                {{ !$loop->last ? ',' : '' }}
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
                            formatter: function (val) {
                                return val;
                            }
                        }
                    },
                    title: {
                        text: '{{ __('grantmanagement::grantmanagement.grant_management_overview') }}',
                        floating: true,
                        offsetY: 330,
                        align: 'center',
                        style: {
                            color: '#444'
                        }
                    }
                };

                var grantChart = new ApexCharts(document.querySelector("#wardCashChart"), grantChartOptions);
                grantChart.render();
            });
        </script>
    @endpush -->



    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var grantChartOptions = {
                    series: [{
                        name: '{{ __('grantmanagement::grantmanagement.entities') }}',
                        data: [
                                                                                                    {{ $TotalFarmers }},
                                                                                                    {{ $TotalCooperatives }},
                                                                                                    {{ $TotalGroups }},
                            {{ $TotalEnterprises }}
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
                        formatter: function (val) {
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
                            '{{ __('grantmanagement::grantmanagement.farmers') }}',
                            '{{ __('grantmanagement::grantmanagement.cooperatives') }}',
                            '{{ __('grantmanagement::grantmanagement.groups') }}',
                            '{{ __('grantmanagement::grantmanagement.enterprises') }}'
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
                            formatter: function (val) {
                                return val;
                            }
                        }
                    },
                    title: {
                        text: '{{ __('grantmanagement::grantmanagement.grant_management_overview') }}',
                        floating: true,
                        offsetY: 330,
                        align: 'center',
                        style: {
                            color: '#444'
                        }
                    }
                };

                var grantChart = new ApexCharts(document.querySelector("#grantContinueChart"), grantChartOptions);
                grantChart.render();
            });
        </script>
    @endpush

</x-layout.app>