<x-layout.app header="{{ __('Dashboard') }}">

    <div class="row">

        <!-- Total Meetings Card -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bxs-user bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($commiteeMember, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('Total Commitee Memeber') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bxs-message-detail bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($meetingCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('Total Meetings') }}</p>
                </div>
            </div>
        </div>

        <!-- Upcoming Meetings Card -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bxs-message-detail bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($upcomingMeetings, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('Upcoming Meetings') }}</p>
                </div>
            </div>
        </div>

        <!-- Completed Meetings Card -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bxs-group bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($completedMeetings, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('Completed Meetings') }}</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Meeting Chart -->
    <div class="col-lg-12">
        <div class="card">
            <h5 class="card-header">{{ __('Total Meetings by Committee Types') }}</h5>
            <div id="totalMeetingChart" class="px-4 py-3"></div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var meetingOptions = {
                    series: [{
                        name: "{{ __('Meetings') }}",
                        data: [
                            @foreach ($meetingChart as $meetingData)
                                {{ $meetingData }} {{ $loop->last ? '' : ',' }}
                            @endforeach
                        ]
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    title: {
                        text: '{{ __('Meetings by Committee Types') }}',
                        align: 'left'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [
                            @foreach ($meetingChart as $meetingName => $meetingCountData)
                                '{{ $meetingName }}'
                                {{ $loop->last ? '' : ',' }}
                            @endforeach
                        ],
                    }
                };

                var meetingChart = new ApexCharts(
                    document.querySelector("#totalMeetingChart"),
                    meetingOptions
                );

                meetingChart.render();
            });
        </script>
    @endpush
</x-layout.app>
