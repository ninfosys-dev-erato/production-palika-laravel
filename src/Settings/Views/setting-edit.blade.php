<x-layout.app header="{{ __('settings::settings.setting') }}">
    {{-- {{ dd($setting) }} --}}
    {{-- <livewire:settings.setting_form :action="\App\Enums\Action::UPDATE" :$setting /> --}}

    {{-- <div style="width: 60%; margin: 0px auto; padding: 10px; border: 5px double red ;">


        <header class="header"
            style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; width: 100%; border-bottom: 2px solid black; text-align: center;">

            <!-- Logo Container (Left) -->
            <div class="logo-container" style="width: 100px; text-align: center;">
                <a href="{{ route('customer.home.index') }}" aria-label="Go to homepage">
                    <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="National Emblem of Nepal"
                        class="primary-logo" style="width: 80px; height: auto; display: block; margin: 0 auto;" />
                </a>
            </div>

            <!-- Text Container (Center) -->
            <div class="text-container" style="flex: 1; text-align: center;">
                <h3 style="margin: 0; font-size: 18px; font-weight: bold;">Lalitpur Nagarpalika</h3>
                <p style="margin: 2px 0; font-size: 14px;">Lalitpur Palika</p>
                <p style="margin: 2px 0; font-size: 14px;">Nagar Karyalako Karyala</p>
                <p style="margin: 2px 0; font-size: 14px;">Office of the Municipal Office</p>
                <p style="margin: 2px 0; font-size: 14px;">Lalitpur, Kathmandu, Nepal</p>
            </div>

            <!-- Logo Container (Right) -->
            <div class="logo-container" style="width: 100px; text-align: center;">
                <a href="{{ route('customer.home.index') }}" aria-label="Go to homepage">
                    <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="National Emblem of Nepal"
                        class="primary-logo" style="width: 80px; height: auto; display: block; margin: 0 auto;" />
                </a>
            </div>

        </header>

        <div style="
        position: relative;
        background: transparent;
        z-index: 1;
    ">
            <!-- Add this pseudo-element for background -->
            <div
                style="
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            height: 50%;
            background-image: url('{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: contain;
            opacity: 0.2;
            z-index: -1;
        ">
            </div>

            <div style="margin:10px 0px; text-align: center; font-size: 14px; border-top: 2px solid black;">
                <p style="display: inline-block; margin: 5px 10px;">कार्यालय कोड नं: 019128912</p>
                <p style="display: inline-block; margin: 5px 10px;">स्थायी लेखा नं: 2109218</p>
                <p style="display: inline-block; margin: 5px 10px;">सम्पर्क नं: 7189821</p>
                <div>
                    <p style="display: inline-block; margin: 5px 10px;">इमेल: something@gov.np</p>
                    <p style="display: inline-block; margin: 5px 10px;">फेसबुक: facebook.com</p>
                </div>
                <p style="margin: 5px 10px;">वेबसाइट: nepal.com.np</p>
            </div>

        </div>
    </div> --}}



    <form>
        <style>
            .letter-container {
                width: 60%;
                margin: 0 auto;
                padding: 10px;
                border: 5px double red;
                min-height: 900px;
                display: flex;
                flex-direction: column;
            }

            .letter-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                border-bottom: 2px solid black;
                text-align: center;
            }

            .logo-container {
                text-align: center;
                width: 100px;
            }

            .logo-container img {
                width: 80px;
                height: auto;
                display: block;
                margin: 0 auto;
            }

            .letter-content {
                flex-grow: 1;
                position: relative;
            }

            .position-absolute-bg {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 50%;
                height: 50%;
                background: url('{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}') no-repeat center center;
                background-size: contain;
                opacity: 0.2;
                z-index: -1;
            }

            .letter-footer {
                border-top: 2px solid black;
                text-align: center;
                font-size: 14px;
                padding-top: 10px;
            }
        </style>

        <div class="letter-container">
            <!-- Header -->
            <header class="letter-header">
                <!-- Left Logo -->
                <div class="logo-container">
                    @if ($logo && $logo->value)
                        <img src="{{ $logo->value }}" alt="Palika Logo" style="max-width: 200px; height: auto;">
                    @else
                        <p>{{__('settings::settings.no_logo_available')}}</p>
                    @endif
                </div>

                <!-- Editable Office Information with Toggle Tabs -->
                <div class="flex-grow-1">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs justify-content-center mb-1" id="languageTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="nepali-tab" data-bs-toggle="tab"
                                data-bs-target="#nepali" type="button" role="tab" aria-controls="nepali"
                                aria-selected="true">
                                {{__('settings::settings.nepali')}}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="english-tab" data-bs-toggle="tab" data-bs-target="#english"
                                type="button" role="tab" aria-controls="english" aria-selected="false">
                                {{__('settings::settings.english')}}
                            </button>
                        </li>
                    </ul>
                    <!-- Tab Content -->
                    <div class="tab-content p-0" id="languageTabContent">

                        <!-- Nepali Fields -->
                        <div class="tab-pane fade show active" id="nepali" role="tabpanel"
                            aria-labelledby="nepali-tab">
                            <livewire:settings.setting_item_form setting_key="palika-name" />
                            <livewire:settings.setting_item_form setting_key="palika-address" />
                            <div class="mb-1">

                                <livewire:settings.setting_item_form setting_key="palika-slogan" />
                            </div>
                            <livewire:settings.setting_item_form setting_key="palika-ward" />
                            <livewire:settings.setting_item_form setting_key="palika-province" />
                            <livewire:settings.setting_item_form setting_key="fiscal-year" />
                        </div>
                        <!-- English Fields -->
                        <div class="tab-pane fade" id="english" role="tabpanel" aria-labelledby="english-tab">
                            <livewire:settings.setting_item_form setting_key="palika-name-english" />
                            <livewire:settings.setting_item_form setting_key="palika-address-eng" />
                            <livewire:settings.setting_item_form setting_key="palika-slogan" />
                            <livewire:settings.setting_item_form setting_key="palika-ward-eng" />
                            <livewire:settings.setting_item_form setting_key="palika-province-eng" />
                            <livewire:settings.setting_item_form setting_key="fiscal-year" />
                        </div>
                    </div>


                </div>


                <!-- Right Logo -->
                <div class="logo-container">
                    @if ($palikaCampaginLogo && $palikaCampaginLogo->value)
                        <img src="{{ $palikaCampaginLogo->value }}" alt="Palika Campagin Logo"
                            style="max-width: 200px; height: auto;">
                    @else
                        <p>{{__('settings::settings.no_logo_available')}}</p>
                    @endif
                </div>

            </header>

            <!-- Empty Middle Section -->
            <div class="letter-content">
                <div class="position-absolute-bg"></div>
            </div>

            <!-- Footer -->
            <footer class="letter-footer">
                <div class="mb-1">

                    <livewire:settings.setting_item_form setting_key="office_phone" />
                </div>
                <livewire:settings.setting_item_form setting_key="office_email" />
            </footer>
        </div>
    </form>




</x-layout.app>
