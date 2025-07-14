<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kailari TV</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/nepali-date-picker@2.0.2/dist/nepaliDatePicker.min.css"
          crossorigin="anonymous" />
    @livewireStyles
</head>
<body>

<header class="app-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand"href="{{route('pwa.kiosk.index', ['ward' => $ward]) }}">
                <img src="https://kiosk.ninjainfosys.com.np/_next/image?url=%2F_next%2Fstatic%2Fmedia%2Flogo.a9c96e4f.png&w=3840&q=75"
                     alt="Logo" class="header-logo">
            </a>

            <div class="location-indicator" style="display: flex;flex-direction: column;">

                <div>{{getSetting('palika-name')}}</div>
                <div>{{getSetting('palika-district')}}</div>

            </div>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Location (visible on mobile) -->
                <div class="location-indicator d-flex d-lg-none mb-3">
                    <div class="location-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <span>नेपाल, नेपाल</span>
                </div>

                <!-- Navigation Menu -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pwa.kiosk.index') ? 'active' : '' }}"
                           href="{{route('pwa.kiosk.index', ['ward' => $ward]) }}">
                            <span>गृह पृष्ठ</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pwa.kiosk.notice') ? 'active' : '' }}"
                           href="{{ route('pwa.kiosk.notice', ['ward' => $ward]) }}">
                            <span>सूचनाहरु</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pwa.kiosk.program') ? 'active' : '' }}"
                           href="{{route('pwa.kiosk.program', ['ward' => $ward]) }}">
                            <span>कार्यक्रमहरु</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pwa.kiosk.citizen-charter') ? 'active' : '' }}"
                           href="{{route('pwa.kiosk.citizen-charter', ['ward' => $ward]) }}">
                            <span>नागरिक वडापत्र</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pwa.kiosk.video') ? 'active' : '' }}"
                           href="{{route('pwa.kiosk.video', ['ward' => $ward] )}}">
                            <span>भिडियोहरु</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <style>
        /* Header styling */
        .app-header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar {
            padding: 0.75rem 0;
        }

        .header-logo {
            height: 40px;
            width: auto;
        }

        /* Location indicator */
        .location-indicator {
            display: flex;
            align-items: center;
            color: #6c757d;
            font-size: 0.9rem;
            margin-left: 1.5rem;
        }

        .location-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0d6efd;
            margin-right: 0.5rem;
        }

        /* Navigation links */
        .navbar-nav {
            gap: 0.5rem;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
        }

        .nav-link.active {
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 3px;
            background-color: #0d6efd;
            border-radius: 3px;
        }

        /* Mobile navbar toggle */
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            color: #495057;
            background-color: transparent;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: white;
                padding: 1rem;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                position: absolute;
                top: 100%;
                right: 1rem;
                left: 1rem;
                z-index: 1000;
            }

            .nav-link.active::after {
                display: none;
            }

            .nav-link.active {
                color: white;
                background-color: #0d6efd;
            }
        }
    </style>
</header>
    <body class="container">
    <livewire:pwa.pwa_kiosk.pwa_video :$ward/>
    <script src="https://unpkg.com/nepali-date-picker@2.0.2/dist/nepaliDatePicker.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    </body>
