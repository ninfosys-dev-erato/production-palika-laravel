<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ getSetting('palika-name') }}{{ $ward != 0 ? ' - ' . replaceNumbers($ward, true) : '' }}
    </title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        :root {
            --primary: #264F8B;
            --secondary: #2460B9;
            --text-primary: #FFFFFF;
            --text-secondary: #EDEDED;
            --table-row: #F5F5F5;
            --border: #D9D9D9;
        }
    </style>
</head>

<body style="overflow: hidden">

    <div>
        <header class="d-flex align-items-center justify-content-between px-4"
            style="height: 8vh; background: var(--primary); color: var(--text-primary);">
            <div>
                <img src="{{ getSetting('palika-logo') }}" alt="Logo" height="50" width="50">
            </div>
            <div class="text-center ms-5">
                <h3 class="fw-bold m-0 mb-1" style="font-size: 1rem;">{{ getSetting('palika-name') }}</h3>
                <h4 class="fw-bold m-0 mb-1" style="font-size: 0.7rem;">
                    {{ $ward == 0 ? getSetting('office-name') : 'वडा नं ' . replaceNumbers($ward, true) . ' को कार्यालय' }}
                </h4>
                <h5 class="fw-semibold m-0" style="font-size: 0.6rem;">
                    {{ $ward === 0
    ? getSetting('palika-province') . ', ' . getSetting('palika-district') . ', नेपाल'
    : Src\Wards\Models\Ward::where('id', $ward)->value('address_ne') ??
    getSetting('palika-province') . ', ' . getSetting('palika-district') . ', नेपाल' }}
                </h5>

            </div>
            <div class="d-flex align-items-center">
                <img src="{{ getSetting('palika-campaign-logo') }}" alt="Campaign Logo" height="50" width="50">
                <div class="ms-1 " style="font-size: 0.6rem; color: rgba(255, 255, 255, 0.822);">
                    <div class="me-2">{{ getSetting('office_phone') }}</div>
                    <div class="me-2">{{ getSetting('office_email') }}</div>
                    <div class="me-2">समृद्ध {{ getSetting('palika-name') }}, सभ्य समाज</div>
                </div>
            </div>
        </header>

        <main>
            <!-- notices section -->
            <livewire:pwa.pwa_tv.pwa_tv :ward="$ward" />
            <!-- Content Section -->
        </main>

        <footer style="height: 3vh; background: var(--secondary); color: var(--text-primary);">
            <div class="text-center text-light py-2">
                <p class="mb-0" style="font-size: 0.7rem;">{{ date('Y') }} © Design and Developed by Ninja
                    Infosys
                </p>
            </div>
        </footer>
    </div>

    <script>
        function updateTime() {
            const options = {
                weekday: 'short',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            document.getElementById('live-time').textContent = new Date().toLocaleDateString('en-US', options);
        } <
        script >
            function updateTime() {
                const options = {
                weekday: 'short',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
                };
            const currentDate = new Date().toLocaleDateString('en-US', options);
            document.getElementById('live-time').textContent = currentDate;
            }

            setInterval(updateTime, 1000); // Update every second
            updateTime(); // Call once immediately
    </script>

</body>

</html>