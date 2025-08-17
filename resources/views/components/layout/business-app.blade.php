<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ $header ?? '' }} - {{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap');
    </style>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('vendor/nepali.datepicker.v4.0.8.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('vendor/rappasoft/livewire-tables/css/laravel-livewire-tables.min.css') }}" />
    @stack('styles')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo" style="height: 130px">
                    <a href="{{ route('organization.dashboard') }}"
                        class="app-brand-link d-flex flex-column align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="Logo"
                                class="app-brand-logo" style="height: 40px; width: auto;">
                            <span class="app-brand-text demo menu-text fw-bolder ms-4">ई-पालिका</span>
                        </div>
                        <div style="border-top: 1px solid #ccc; width: 100%; margin: 10px 0;"></div>
                        <div class="app-brand-text demo menu-text fw-bolder"
                            style="font-size: 20px; margin-top: 15px; text-align: center;">
                            @if (app()->getLocale() === 'en')
                                {{ getSetting('palika-name-english') }}
                            @else
                                {{ getSetting('palika-name') }}
                            @endif
                        </div>
                        <div style="border-top: 1px solid #ccc; width: 100%; margin: 10px 0;"></div>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <!-- Add space before menu items start -->
                <div style="margin-top: 20px;"></div>

                @include('business-portal.business-sidebar')
            </aside>

            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('business-portal.business-nav')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        @if (session()->has('alert'))
                            <div class="alert alert m-2 bg bg-{{ session()->get('alert')['type'] }} p-4 text-white rounded alert-dismissible"
                                role="alert">
                                <h4 class="alert-heading d-flex align-items-center">
                                    <span class="alert-icon rounded-circle"
                                        style="border: 2px solid white; padding: 8px; display: inline-flex; align-items: center; justify-content: center;">
                                        @if (session()->get('alert')['type'] === 'success')
                                            <i class="bx bx-coffee"></i>
                                        @elseif(session()->get('alert')['type'] === 'danger')
                                            <i class="bx bx-error"></i>
                                        @else
                                            <i class="bx bx-show"></i>
                                        @endif
                                    </span>
                                    &nbsp;
                                    {{ session()->get('alert')['title'] }}
                                </h4>
                                <hr>
                                <p class="mb-0">{{ session()->get('alert')['message'] }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                        @endif
                        {{ $slot }}
                    </div>

                    <!-- / Content -->
                    @include('admin.partials.footer')

                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>


    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>

    <script src="{{ asset('vendor/nepali.datepicker.v4.0.8.min.js') }}" type="text/javascript"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.nepali-date').forEach(function(input) {
                input.nepaliDatePicker({
                    language: "ne",
                    ndpYear: true,
                    ndpMonth: true,
                    unicodeDate: true,
                    onChange: function() {
                        input.dispatchEvent(new Event('input', {
                            bubbles: true
                        }));
                    }
                });
            });
        });
    </script>


    @livewireScripts
    @stack('scripts')
    <x-livewire-alert::flash />
</body>

</html>
