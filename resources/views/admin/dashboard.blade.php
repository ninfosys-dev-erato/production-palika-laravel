<x-layout.app header="{{ __('Dashboard') }}">

    <style>
        /* Base styles */
        .services-card {
            flex: 1 0 67%;
        }

        .info-card {
            flex: 1 0 33%;
        }

        .service-card-title {
            font-size: 1rem;
            font-weight: 500;
        }

        .icon-style {
            font-size: 2rem;
            color: #01399a;
            margin-bottom: 0.5rem;
        }

        .service-item {
            max-width: 11rem;
            min-width: 11rem;
        }

        .disabled-card {
            pointer-events: none;
            opacity: 0.6;
            cursor: not-allowed;
        }


        @media (max-width: 770px) {

            .services-card,
            .info-card {
                flex: 1 0 100%;
            }

            .container-wrapper {
                flex-direction: column;
            }
        }

        /* Media query for very small devices */
        @media (max-width: 320px) {
            .services-card {
                flex: 1 0 50%;
            }

            .service-item {
                max-width: 7rem !important;
                min-width: 7rem !important;
            }

            .service-card-title {
                font-size: 0.8rem;
            }
        }
    </style>




    <div class="card text-center mb-3">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
            <h5 class="card-title text-primary">
                {{ __('Welcome') }} {{ auth()->user()->name }}
            </h5>
            <p class="card-text">
                {{ __('Welcome to digital e-palika system.') }}
            </p>
        </div>
    </div>
    <div class="text-center">
        <h3>{{ __('Services in Digital Palika') }}</h3>
        <p> {{ app()->getLocale() === 'ne' ? getSetting('palika-name') . 'मा कार्यान्वयन गरिएका मोड्युलहरूको विस्तृत जानकारी' : __('Detailed information of the modules implemented in Digital ') . getSetting('palika-name-english') }}
        </p>
    </div>
    <hr />

    <div class="d-flex align-items-start container-wrapper">
        <!-- Left Container: takes 66% width -->


        <div class="d-flex flex-wrap services-card ">
            @foreach (config('module_menu') as $card)
                @if (!isset($card['module']) || isModuleEnabled($card['module']))
                    @if (!empty($card['route']))
                        <a href="{{ route($card['route']) }}" class="flex-grow-1 mb-3 mx-2 service-item">
                            <div class="card text-center h-100">
                                <div class="d-flex align-items-center justify-content-center py-4 h-100 w-100">
                                    <div class="text-center">
                                        <img src="{{ asset('assets/icons/' . $card['logo']) }}"
                                            alt="{{ $card['label'] }} Icon" class="img-fluid mb-2 mx-auto"
                                            style="max-width: 55px;">
                                        <p class="service-card-title text-capitalize mb-0 text-wrap">
                                            {{ __($card['label']) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @else
                        <div class="disabled-card flex-grow-1 mb-3 mx-2 service-item">
                            <div class="card text-center h-100">
                                <div class="d-flex align-items-center justify-content-center py-4 h-100 w-100">
                                    <div class="text-center">
                                        <img src="{{ asset('assets/icons/' . $card['icon']) }}"
                                            alt="{{ $card['label'] }} (disabled)" class="img-fluid mb-2 mx-auto"
                                            style="max-width: 55px;">
                                        <p class="service-card-title text-capitalize mb-0 text-wrap">
                                            {{ $card['label'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>

        <!-- Right Container: takes 33% width -->
        <div class="d-flex flex-wrap info-card">
            <div class="card text-center mx-2 mb-3" style="flex: 0 0 calc(50% - 1rem);">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bx bx-user icon-style"></i>
                    <h5 class="card-title">{{ __('Total User') }}</h5>
                    <p class="card-text">{{ replaceNumbersWithLocale($userCount, true) }}</p>
                </div>
            </div>
            <div class="card text-center mx-2 mb-3" style="flex: 0 0 calc(50% - 1rem);">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bx bx-group icon-style"></i>
                    <h5 class="card-title">{{ __('Total Customer') }}</h5>
                    <p class="card-text">{{ replaceNumbersWithLocale($customerCount, true) }}</p>
                </div>
            </div>
            <div class="card text-center mx-2 mb-3" style="flex: 0 0 calc(50% - 1rem);">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bx bx-task icon-style"></i>
                    <h5 class="card-title">{{ __('Running Task') }}</h5>
                    <p class="card-text">{{ replaceNumbersWithLocale($runningTaskCount, true) }}</p>
                </div>
            </div>
            <div class="card text-center mx-2 mb-3" style="flex: 0 0 calc(50% - 1rem);">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bx bx-credit-card icon-style"></i>
                    <h5 class="card-title">{{ __('Total Credit') }}</h5>
                    <p class="card-text">{{ replaceNumbersWithLocale($availableCredits, true) }}</p>
                </div>
            </div>
            <div class="card text-center mx-2 mb-3" style="flex: 0 0 calc(50% - 1rem);">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bx bx-send icon-style"></i>
                    <h5 class="card-title">{{ __('Total Chalani') }}</h5>
                    <p class="card-text">{{ replaceNumbersWithLocale($chalaniCount, true) }}</p>
                </div>
            </div>
            <div class="card text-center mx-2 mb-3" style="flex: 0 0 calc(50% - 1rem);">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bx bx-file icon-style"></i>
                    <h5 class="card-title">{{ __('Total Darta') }}</h5>
                    <p class="card-text">{{ replaceNumbersWithLocale($dartaCount, true) }}</p>
                </div>
            </div>
            <div class="card text-center mx-2 mb-3" style="flex: 0 0 calc(50% - 1rem);">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bx bx-building icon-style"></i>
                    <h5 class="card-title">{{ __('Total Ward') }}</h5>
                    <p class="card-text">{{ replaceNumbersWithLocale($wardCount, true) }}</p>
                </div>
            </div>
            <div class="card text-center mx-2 mb-3" style="flex: 0 0 calc(50% - 1rem);">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="bx bx-map icon-style"></i>
                    <h5 class="card-title">{{ __('Total Branch') }}</h5>
                    <p class="card-text">{{ replaceNumbersWithLocale($branchCount, true) }}</p>
                </div>
            </div>
            <div class="card text-center mx-2 mb-3" style="flex: 0 0  calc(100% - 1rem);">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">

                    <h5 class="card-title">{{ __('For Technical Support') }}</h5>
                    <p class="card-text">{{ replaceNumbersWithLocale('01-5922361', true) }}</p>
                    <p class="card-text">{{ replaceNumbersWithLocale('9851343348', true) }}</p>
                </div>
            </div>
        </div>

    </div>

    <hr />

</x-layout.app>
