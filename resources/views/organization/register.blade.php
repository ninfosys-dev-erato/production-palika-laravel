<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/nepali-date-picker@2.0.2/dist/nepaliDatePicker.min.css"
        crossorigin="anonymous" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('{{ asset('assets/img/mountain_photo.jpg') }}');
            /* background-image: url('{{ asset('assets/img/mountain_photo.jpg') }}'); */
            /* Background image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 800px;
            overflow: hidden;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 100px;
        }

        .nav-link {
            background-color: #f5f5f5 !important;
            color: #555 !important;
        }

        .nav-link.active {
            background-color: #007bff !important;
            /* Change this */
            color: white !important;
        }
    </style>
</head>

<body>
    <div class="form-container m-3">
        <div class="w-full flex justify-center">
            <img src="{{ asset('assets/img/np.png') }}" class="h-20" alt="Logo">
        </div>
        <div class="text-center font-bold mb-2">
            <h5>विधुतीय घरनक्सा प्रमाणीकरण प्राणली </h5>
            <p>ई-नक्सा पास सेवा प्रदान गर्नको लागि तलको फारम भरि
                सुचिकृतको लागि पठाउनुहोस् </p>
        </div>

        <livewire:business_portal.ebps.organization_form />

            <div class="text-center mt-3">
                <a href="{{ route('organization-login') }}">पहिले नै खाता छ? लगइन गर्नुहोस्</a>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/nepali-date-picker@2.0.2/dist/nepaliDatePicker.min.js" crossorigin="anonymous"></script>
    @livewireScripts
    @stack('scripts')
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::flash />
</body>

</html>
