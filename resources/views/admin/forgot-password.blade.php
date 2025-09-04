<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
      data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Forgot Password</title>
    <meta name="description" content=""/>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon/favicon.ico')}}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
          rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/theme-default.css')}}"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}"/>
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('assets/js/config.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireStyles

</head>
@livewireScripts

<body>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <div class="app-brand justify-content-center">
                        <a href="/" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">

                            </span>
                            <span class="app-brand-text demo text-body fw-bolder mt-3 text-primary">ई-पालिका</span>
                        </a>
                    </div>
                    
               <!-- Content wrapper -->
               <div class="content-wrapper">
                <!-- Content -->

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



                    <!-- Livewire componet form -->
                    <livewire:forgot-password/>

                    <div class="text-center">
                        <a href="{{ route('login') }}">
                            <i class="bx bx-chevron-left"></i> Back to Login
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/vendor/js/menu.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
<x-livewire-alert::flash />
</body>
</html>
