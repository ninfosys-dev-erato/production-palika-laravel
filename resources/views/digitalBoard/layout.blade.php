<!DOCTYPE html>
<html lang="en">

<head>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/nepali-date-picker@2.0.2/dist/nepaliDatePicker.min.css"
        crossorigin="anonymous" />


    @livewireStyles <!-- Add this line -->
</head>

<body>

    @include('.digitalBoard.partials.header')
    <div>
        @yield('hero')
    </div>
    <div>
        @yield('content')
    </div>
    <div>
        @yield('scripts')
    </div>

    @include('.digitalBoard.partials.footer')
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://unpkg.com/nepali-date-picker@2.0.2/dist/nepaliDatePicker.min.js" crossorigin="anonymous"></script>


    @livewireScripts <!-- Add this line before </body> -->
</body>

</html>
