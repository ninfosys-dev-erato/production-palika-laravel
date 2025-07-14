{{-- <form wire:submit.prevent="save">
    <div class="row">
        <x-form.select-input label="{{ __('settings::settings.choose_fiscal_year') }}" id="fiscal_year_id" name="setting.fiscal_year_id"
            :options="getFiscalYears()->pluck('year', 'id')->toArray()" placeholder="{{ __('settings::settings.choose_fiscal_year') }}" />

        <div class="col-md-6">
            <x-form.text-input label="{{ __('settings::settings.office_name') }}" id="office_name" name="setting.office_name" />
        </div>

        <div class="col-md-6">
            <x-form.text-input label="{{ __('settings::settings.office_name_en') }}" id="office_name_en" name="setting.office_name_en" />
        </div>

        <div class="col-md-6">
            <x-form.text-input label="{{ __('settings::settings.office_address') }}" id="office_address" name="setting.office_address" />
        </div>
        <div class="col-md-6">
            <x-form.text-input label="{{ __('settings::settings.office_address_en') }}" id="office_address_en"
                name="setting.office_address_en" />
        </div>
        <div class="col-md-6">
            <x-form.text-input label="{{ __('settings::settings.office_phone') }}" id="office_phone" name="setting.office_phone" />
        </div>
        <div class="col-md-6">
            <x-form.text-input label="{{ __('settings::settings.office_email') }}" id="office_email" name="setting.office_email" />
        </div>
        <div class="col-md-6">
            <x-form.select-input label="{{ __('settings::settings.province') }}" id="province_id" name="setting.province_id"
                :options="getProvinces()->pluck('title', 'id')->toArray()" placeholder="Choose Province" wireChange="loadDistricts()" />
        </div>
        <div class="col-md-6">
            <x-form.select-input label="{{ __('settings::settings.district') }}" id="district_id" name="setting.district_id"
                :options="$districts" placeholder="Choose District" wire-change="loadLocalBodies()" />

        </div>
        <div class="col-md-6">
            <x-form.select-input label="{{ __('settings::settings.local_body') }}" id="local_body_id" name="setting.local_body_id"
                :options="$localBodies" placeholder="Choose Local Body" wire-change="loadWards" />
        </div>
        <div class="col-md-6">
            <x-form.select-input label="{{ __('settings::settings.ward') }}" id="ward" name="setting.ward" :options="$wards"
                placeholder="Choose Ward" />
        </div>
        <div class="col-md-6 mt-3">
            <x-form.text-input label="{{ __('settings::settings.facebook_link') }}" id="facebook_link" name="setting.facebook_link" />
        </div>
        <div class="col-md-6 mt-3">
            <x-form.text-input label="{{ __('settings::settings.youtube_link') }}" id="youtube_link" name="setting.youtube_link" />
        </div>
    </div>

    <div class="d-flex mt-3 gap-2">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('settings::settings.save') }}</button>
        <a href="{{ route('admin.setting.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('settings::settings.back') }}</a>
    </div>
</form> --}}



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
            <x-form.text-input label="{{ __('settings::settings.office_name') }}" id="office_name" name="setting.office_name" />
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




<form wire:submit.prevent="save">
    <style>
        .letter-container {
            width: 60%;
            margin: 0 auto;
            padding: 10px;
            border: 5px double red;
            min-height: 800px;
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
                <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="National Emblem of Nepal"
                    class="img-fluid">
                <!-- Optionally, you can add an upload field here -->
                <!-- <input type="file" wire:model="leftLogo" class="form-control mt-2" accept="image/*"> -->
            </div>

            <!-- Editable Office Information with Toggle Tabs -->
            <div class="flex-grow-1">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs justify-content-center mb-1" id="languageTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nepali-tab" data-bs-toggle="tab" data-bs-target="#nepali"
                            type="button" role="tab" aria-controls="nepali" aria-selected="true">
                            Nepali
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="english-tab" data-bs-toggle="tab" data-bs-target="#english"
                            type="button" role="tab" aria-controls="english" aria-selected="false">
                            English
                        </button>
                    </li>
                </ul>
                <!-- Tab Content -->
                <div class="tab-content p-0" id="languageTabContent">
                    <!-- Nepali Fields -->
                    <div class="tab-pane fade show active" id="nepali" role="tabpanel" aria-labelledby="nepali-tab">

                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-2 col-form-label" for="office_name">Palika Name</label>
                            <div class="col-sm-8">
                                <input type="text" wire:model.live="setting.office_name" id="office_name"
                                    class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn rounded-pill btn-icon btn-outline-success" wire:click="save">
                                    <span class="tf-icons bx bx-check bx-30px"></span>
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-2 col-form-label" for="office_address">Palika Address</label>
                            <div class="col-sm-8">
                                <input type="text" wire:model.live="setting.office_address" id="office_address"
                                    class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn rounded-pill btn-icon btn-outline-success" wire:click="save">
                                    <span class="tf-icons bx bx-check bx-30px"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- English Fields -->
                    <div class="tab-pane fade" id="english" role="tabpanel" aria-labelledby="english-tab">
                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-2 col-form-label" for="office_name_en">Palika Name</label>
                            <div class="col-sm-8">
                                <input type="text" wire:model.live="setting.office_name_en" id="office_name_en"
                                    class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn rounded-pill btn-icon btn-outline-success" wire:click="save">
                                    <span class="tf-icons bx bx-check bx-30px"></span>
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-2 col-form-label" for="office_address_en">Palika Address</label>
                            <div class="col-sm-8">
                                <input type="text" wire:model.live="setting.office_address_en" id="office_address_en"
                                    class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn rounded-pill btn-icon btn-outline-success" wire:click="save">
                                    <span class="tf-icons bx bx-check bx-30px"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Logo -->
            <div class="logo-container">
                <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="National Emblem of Nepal"
                    class="img-fluid">
                <!-- Optionally, add an upload field here -->
                <!-- <input type="file" wire:model="rightLogo" class="form-control mt-2" accept="image/*"> -->
            </div>
        </header>

        <!-- Empty Middle Section -->
        <div class="letter-content">
            <div class="position-absolute-bg"></div>
        </div>

        <!-- Footer -->
        <footer class="letter-footer">
            <div class="row mb-2 align-items-center">
                <label class="col-sm-3 col-form-label" for="office_phone">Palika Phone</label>
                <div class="col-sm-6">
                    <input type="text" wire:model.live="setting.office_phone" id="office_phone"
                        class="form-control">
                </div>
                <div class="col-sm-3">
                    <button class="btn rounded-pill btn-icon btn-outline-success" wire:click="save">
                        <span class="tf-icons bx bx-check bx-30px"></span>
                    </button>
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <label class="col-sm-3 col-form-label" for="office_email">Palika Email</label>
                <div class="col-sm-6">
                    <input type="text" wire:model.live="setting.office_email" id="office_email"
                        class="form-control">
                </div>
                <div class="col-sm-3">
                    <button class="btn rounded-pill btn-icon btn-outline-success" wire:click="save">
                        <span class="tf-icons bx bx-check bx-30px"></span>
                    </button>
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <label class="col-sm-3 col-form-label" for="facebook_link">Palika Facebook</label>
                <div class="col-sm-6">
                    <input type="text" wire:model.live="setting.facebook_link" id="facebook_link"
                        class="form-control">
                </div>
                <div class="col-sm-3">
                    <button class="btn rounded-pill btn-icon btn-outline-success" wire:click="save">
                        <span class="tf-icons bx bx-check bx-30px"></span>
                    </button>
                </div>
            </div>
        </footer>
    </div>
</form>
