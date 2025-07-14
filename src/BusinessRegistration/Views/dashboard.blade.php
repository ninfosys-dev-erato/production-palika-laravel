<x-layout.app header="{{ __('businessregistration::businessregistration.business_registration') }}">
    <div class="row">
        <!-- Total Registration Applications Card -->
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-file bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($registrationApplicationCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('businessregistration::businessregistration.total_registration_applications') }}</p>
                </div>
            </div>
        </div>

        <!-- Registered Businesses Card -->
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-check-circle bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($registeredBusinessCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('businessregistration::businessregistration.total_registered_businesses') }}</p>
                </div>
            </div>
        </div>

        <!-- Total Renewal Applications Card -->
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-check-circle bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($renewalApplicationCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('businessregistration::businessregistration.total_renewal_application') }}</p>
                </div>
            </div>
        </div>

        <!-- Renewed Businesses Card -->
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-refresh bx-lg"></i>
                            </span>
                        </div>
                        <h3 class="card-title mb-2">{{ replaceNumbersWithLocale($renewedBusinessCount, true) }}</h3>
                    </div>
                    <p class="mb-2">{{ __('businessregistration::businessregistration.total_renewed_businesses') }}</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Optional Chart -->
    <div class="d-flex gap-2" style="height:67vh;">
        <div class="col-lg-7 h-100">
            <div class="card">
                <h5 class="card-header">{{ __('businessregistration::businessregistration.business_registration_overview') }}</h5>
                <div id="businessRegistrationChart" class="px-4 py-3"></div>
            </div>
        </div>

        <div class="col-lg-5 px-3 py-1 h-100 ">
            <p class="fs-4 fw-bolder text-dark">{{__('businessregistration::businessregistration.counts_of_applied_business')}}</p>
            <div class="d-flex flex-column mt-3 w-100 gap-2 pe-2" style="height: 95%; overflow-y: auto;">
                @foreach ($registrationTypes as $type)
                    <div class="bg-light w-100 px-1 py-2 d-flex justify-content-between align-items-center rounded-1">
                        <div class="d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 23 23"
                                 style="fill: rgb(95, 95, 95);transform: ;msFilter:;">
                                <path d="M20 2H10a2 2 0 0 0-2 2v2h8a2 2 0 0 1 2 2v8h2a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z">
                                </path>
                                <path
                                        d="M4 22h10c1.103 0 2-.897 2-2V10c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2zm2-10h6v2H6v-2zm0 4h6v2H6v-2z">
                                </path>
                            </svg>
                            <p class="fs-5 fw-bold m-0">{{ $type->title }}</p>
                        </div>
                        <div class="d-flex justify-content-center bg-primary  align-items-center rounded-circle"
                             style="height: 35px; width: 35px;">
                            <span class="text-white fs-6 fw-bold">
                                {{ $type->business_registrations_count }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var options = {
                    series: [
                        {{ $registrationApplicationCount }},
                        {{ $registeredBusinessCount }},
                        {{ $renewedBusinessCount }}
                    ],
                    chart: {
                        type: 'pie',
                        width: '100%'
                    },
                    labels: [
                        '{{ __('businessregistration::businessregistration.applications') }}',
                        '{{ __('businessregistration::businessregistration.registered_businesses') }}',
                        '{{ __('businessregistration::businessregistration.renewed_businesses') }}'
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

                var chart = new ApexCharts(document.querySelector("#businessRegistrationChart"), options);
                chart.render();
            });
        </script>
    @endpush
</x-layout.app>
