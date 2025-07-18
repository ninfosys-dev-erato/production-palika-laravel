<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        @auth
            <div class="me-3">
                <div class="fw-bold navbar-brand row" style="font-size: 16px; color: #495057;">
                    {{ auth()->user()->name }}
                    @foreach (auth()->user()->getRoleNames() as $roleName)
                        ({{ ucfirst(str_replace('_', ' ', $roleName)) }})
                    @endforeach
                </div>
            </div>
            <livewire:ward-switcher />&nbsp;
            <livewire:department-switcher />
        @endauth


        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <div class="flex-column me-3">
                <span class="navbar-text small fw-semibold text-danger"
                    style="font-size: 14px;">{{ __('Fiscal Year') }}: {{ fiscalYear()['year'] }}</span><br>

                <span class="navbar-text small fw-bold text-danger" style="font-size: 14px;">
                    {{ __('Today`s Date') }}: <span id="current-date"></span>
                </span>
                <br>

            </div>

            <livewire:language-switcher />

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt
                            class="w-px-40 h-auto rounded-circle" style="border: 2px solid #dee2e6;" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle" style="border: 2px solid #dee2e6;" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">

                                    @if (auth()->check())
                                        <span class="fw-semibold d-block"
                                            style="font-size: 15px;">{{ auth()->user()->name }}</span>
                                        <small class="text-muted">{{ auth()->user()->email }}</small>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    @if (auth()->check())
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">{{ __('Profile') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile.password-index') }}">
                                <i class="bx bx-key me-2"></i>
                                <span class="align-middle">{{ __('Change Password') }}</span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <span class="dropdown-item" onclick="document.getElementById('logout-form').submit()"
                            style="cursor: pointer;">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">{{ __('Log Out') }}</span>
                        </span>
                    </li>

                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/nepali-date-converter@3.3.4/dist/nepali-date-converter.umd.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const dateElement = document.getElementById("current-date");
            const timeElement = document.getElementById("current-time");

            const updateDateTime = () => {
                const now = new Date();
                const nepaliDate = new NepaliDate(now);
                const formattedNepaliDate = nepaliDate.format("MMMM,DD, YYYY | ddd", "np");

                const nepaliTime = new Intl.DateTimeFormat("ne-NP", {
                    timeStyle: "medium",
                    numberingSystem: "deva",
                    hour12: false,
                }).format(now);

                dateElement.textContent = formattedNepaliDate;
                timeElement.textContent = nepaliTime;
            };

            // Initial call
            updateDateTime();
            // Update every second
            setInterval(updateDateTime, 1000);
        });
    </script>

</nav>
