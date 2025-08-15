@php
    use Src\BusinessRegistration\Enums\BusinessRegistrationType;
@endphp
<x-layout.app header="{{ __('businessregistration::businessregistration.business_registration') }}">

    <!-- Quick Actions Section -->
    <div class="row mb-4">
        <div class="col-12">

            <div class="divider divider-primary text-start text-primary mb-3 mt-0">
                <div class="divider-text fw-bold fs-6">
                    {{ __('businessregistration::businessregistration.quick_actions') }}
                </div>
            </div>

            <div class="row g-3">
                <!-- Business Registration Create -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{ route('admin.business-registration.business-registration.create', ['type' => BusinessRegistrationType::REGISTRATION]) }}"
                        class="text-decoration-none">
                        <div class="card card-border-shadow-primary h-100">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icon -->
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-plus-circle bx-lg"></i>
                                    </span>
                                </div>
                                <!-- Text -->
                                <div>
                                    <h5 class="card-title mb-1">
                                        {{ __('businessregistration::businessregistration.new_registration') }}
                                    </h5>
                                    <p class="card-text small text-muted mb-0">
                                        {{ __('businessregistration::businessregistration.create_new_business_registration') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Business Deregistration Create -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{ route('admin.business-deregistration.create', ['type' => BusinessRegistrationType::DEREGISTRATION]) }}"
                        class="text-decoration-none">
                        <div class="card card-border-shadow-warning h-100">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icon -->
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-warning">
                                        <i class="bx bx-minus-circle bx-lg"></i>
                                    </span>
                                </div>
                                <!-- Text -->
                                <div>
                                    <h5 class="card-title mb-1">
                                        {{ __('businessregistration::businessregistration.new_deregistration') }}
                                    </h5>
                                    <p class="card-text small text-muted mb-0">
                                        {{ __('businessregistration::businessregistration.create_new_business_deregistration') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Business Renewal -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{ route('admin.business-registration.renewals.create') }}" class="text-decoration-none">
                        <div class="card card-border-shadow-success h-100">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icon -->
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-refresh bx-lg"></i>
                                    </span>
                                </div>
                                <!-- Text -->
                                <div>
                                    <h5 class="card-title mb-1">
                                        {{ __('businessregistration::businessregistration.business_renewal') }}
                                    </h5>
                                    <p class="card-text small text-muted mb-0">
                                        {{ __('businessregistration::businessregistration.manage_business_renewals') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Business Report -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{ route('admin.business-registration.report') }}" class="text-decoration-none">
                        <div class="card card-border-shadow-info h-100">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icon -->
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="tf-icons bx bx-file bx-lg"></i>
                                    </span>
                                </div>
                                <!-- Text -->
                                <div>
                                    <h5 class="card-title mb-1">
                                        {{ __('businessregistration::businessregistration.business_report') }}
                                    </h5>
                                    <p class="card-text small text-muted mb-0">
                                        {{ __('businessregistration::businessregistration.view_business_reports') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">

            <div class="divider divider-primary text-start text-primary mb-3 mt-0">
                <div class="divider-text fw-bold fs-6">
                    {{ __('businessregistration::businessregistration.summarized_records') }}
                </div>
            </div>
            <div class="row g-3">
                <!-- Total Registration Applications Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body d-flex align-items-center">
                            <!-- Icon -->
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-file bx-lg"></i>
                                </span>
                            </div>
                            <!-- Text Content -->
                            <div>
                                <h3 class="card-title mb-1">
                                    {{ replaceNumbersWithLocale($registrationApplicationCount, true) }}</h3>
                                <p class="mb-0 text-muted">
                                    {{ __('businessregistration::businessregistration.total_registration_applications') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registered Businesses Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-check-circle bx-lg"></i>
                                </span>
                            </div>
                            <div>
                                <h3 class="card-title mb-1">
                                    {{ replaceNumbersWithLocale($registeredBusinessCount, true) }}</h3>
                                <p class="mb-0 text-muted">
                                    {{ __('businessregistration::businessregistration.total_registered_businesses') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Renewal Applications Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-check-circle bx-lg"></i>
                                </span>
                            </div>
                            <div>
                                <h3 class="card-title mb-1">
                                    {{ replaceNumbersWithLocale($renewalApplicationCount, true) }}</h3>
                                <p class="mb-0 text-muted">
                                    {{ __('businessregistration::businessregistration.total_renewal_application') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Renewed Businesses Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-refresh bx-lg"></i>
                                </span>
                            </div>
                            <div>
                                <h3 class="card-title mb-1">{{ replaceNumbersWithLocale($renewedBusinessCount, true) }}
                                </h3>
                                <p class="mb-0 text-muted">
                                    {{ __('businessregistration::businessregistration.total_renewed_businesses') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Optional Chart -->
    <div class="d-flex gap-2" style="height:67vh;">
        <div class="col-lg-7 h-100">
            <div class="card">
                <h5 class="card-header">
                    {{ __('businessregistration::businessregistration.business_registration_overview') }}</h5>
                <div id="businessRegistrationChart" class="px-4 py-3"></div>
            </div>
        </div>

        <div class="col-lg-5 px-3 py-1 h-100 ">
            <p class="fs-4 fw-bolder text-dark">
                {{ __('businessregistration::businessregistration.counts_of_applied_business') }}</p>
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
            document.addEventListener('DOMContentLoaded', function() {
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
