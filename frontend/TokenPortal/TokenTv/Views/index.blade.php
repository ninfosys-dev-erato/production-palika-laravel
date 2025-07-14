<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>सेवा अनुगमन प्रणाली</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Other Dependencies -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" href="https://unpkg.com/nepali-date-picker@2.0.2/dist/nepaliDatePicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/nepali-date-converter@3.3.4/dist/nepali-date-converter.umd.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom CSS Variables -->
    <style>
        :root {
            --primary: #01399a;
            --primary-light: #1a4ca3;
            --primary-lighter: #e6eeff;
            --primary-lightest: #f5f8ff;
        }

        body{
            max-height: 100vh;
            max-width: 100vw;
                }
    </style>

    @livewireStyles
</head>

<body class="d-flex flex-column min-vh-100 bg-light w-100">
    <!-- Header with date and time -->
    <header class="w-100" style="background-color: var(--primary)">
        <div class="container-fluid px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <h1 class="fs-4 fw-bold text-white mb-0">सेवा अनुगमन प्रणाली</h1>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="fs-5 text-white" id="current-date"></div>
                    <div class="fs-5 ms-3 text-white font-monospace" id="current-time"></div>
                </div>
            </div>
        </div>
    </header>

    <livewire:token_portal.token_tv.register_token_table />

    @livewireScripts
    @stack('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const dateElement = document.getElementById("current-date");
            const timeElement = document.getElementById("current-time");

            const updateDateTime = () => {
                const now = new Date();
                const nepaliDate = new NepaliDate(now);
                const formattedNepaliDate = nepaliDate.format("DD MMMM YYYY ddd", "np");
                const nepaliTime = new Intl.DateTimeFormat("ne-NP", {
                    timeStyle: "medium",
                    numberingSystem: "deva",
                    hour12: false,
                }).format(now);

                dateElement.textContent = formattedNepaliDate;
                timeElement.textContent = nepaliTime;
            };

            updateDateTime();
            const interval = setInterval(updateDateTime, 1000);
            window.addEventListener("beforeunload", () => clearInterval(interval));
        });

        // Initialize Lucide icons
        lucide.createIcons();
    </script>

</body>
</html>