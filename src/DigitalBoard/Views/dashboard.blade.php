<x-layout.app header="{{ __('digitalboard::digitalboard.digital_board_distribution') }}">
    <div class="row">

        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-notification bx-lg"></i></span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($noticeCount,true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('digitalboard::digitalboard.total') }} {{ __('digitalboard::digitalboard.notices') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-video bx-lg"></i></span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($videoCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('digitalboard::digitalboard.total') }} {{ __('digitalboard::digitalboard.videos') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-calendar-event bx-lg"></i></span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($programCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('digitalboard::digitalboard.total') }} {{ __('digitalboard::digitalboard.programs') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-message-dots bx-lg"></i></span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($popUpCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('digitalboard::digitalboard.total') }} {{ __('digitalboard::digitalboard.popups') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-book-content bx-lg"></i></span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($citizenCharterCount,true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('digitalboard::digitalboard.total') }} {{ __('digitalboard::digitalboard.citizen_charters') }}</p>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header">{{ __('digitalboard::digitalboard.digital_board_distribution') }}</h5>
            <div id="digitalBoardChart" class="px-4 py-3"></div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Digital Board Chart Configuration
                var digitalBoardOptions = {
                    series: [
                        {{ $noticeCount }},
                        {{ $videoCount }},
                        {{ $programCount }},
                        {{ $popUpCount }},
                        {{ $citizenCharterCount }}
                    ],
                    chart: {
                        type: 'pie',
                        width: '100%'
                    },
                    labels: [
                        '{{ __('digitalboard::digitalboard.notices') }}',
                        '{{ __('digitalboard::digitalboard.videos') }}',
                        '{{ __('digitalboard::digitalboard.programs') }}',
                        '{{ __('digitalboard::digitalboard.popups') }}',
                        '{{ __('digitalboard::digitalboard.citizen_charter') }}'
                    ],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var digitalBoardChart = new ApexCharts(
                    document.querySelector("#digitalBoardChart"),
                    digitalBoardOptions
                );

                digitalBoardChart.render();
            });
        </script>
    @endpush
</x-layout.app>
