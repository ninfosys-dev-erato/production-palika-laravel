<x-layout.app header="{{ __('settings::settings.setting') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('settings::settings.setting') }}</li>
        </ol>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-lg border-0" style="transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <!-- Card Header -->
                    <div class="card-header text-center bg-primary text-white py-3">
                        <h1 class="h4 mb-0 font-weight-bold text-white">
                            {{ __('settings::settings.settings') }}
                        </h1>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <div class="d-flex flex-column align-items-center">
                            <!-- National Emblem -->
                            <div class="mb-4">
                                <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}"
                                    alt="{{ __('settings::settings.national_emblem_of_nepal') }}" class="img-fluid rounded-circle"
                                    style="width: 120px; height: auto; border: 2px solid #f8f9fa; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                            </div>

                            <!-- Office Information -->
                            <h2 class="h5 text-dark mb-2 font-weight-bold">
                                {{ getSetting('palika-name') }}
                            </h2>
                            <h5 class="mb-3 text-center font-weight-bold">
                                {{ getSetting('palika-address') }}
                            </h5>
                            <h5 class="d-block mt-1 text-center font-weight-bold">
                                {{ getSetting('palika-slogan') }}
                            </h5>
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2" style="color: #007bff;">📞</span>
                                <p class="text-dark mb-0 font-weight-bold">
                                    {{ getSetting('office_phone') }}
                                </p>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="me-2" style="color: #007bff;">✉️</span>
                                <p class="text-dark mb-0 font-weight-bold">
                                    {{ getSetting('office_email') }}
                                </p>
                            </div>

                            <div class="mt-3">
                                <a href= "{{ route('admin.setting.editsetting') }}"
                                    class="btn btn-primary px-4 py-2 rounded-pill">
                                    {{ __('settings::settings.edit_settings') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="card">

        {{-- <div class="d-flex flex-column align-items-center justify-content-center card-header">
            <h5>{{ __('settings::settings.setting') }}</h5>
            <div>
                <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="National Emblem of Nepal"
                    class="primary-logo" style="width: 170px; height: auto;" />
            </div>
            <h5>
                {{ $setting->office_name }}
            </h5>
            <h5>
                {{ $setting->office_address }}
            </h5>
            <h5>
                {{ $setting->office_phone }}
            </h5>
            <h5>
                {{ ' सुन्दर, हरियाली र सफा सहर, समृद्द र समुन्नत बाँसगढी नगर' }}
            </h5>
            <h5>
                {{ $setting->office_email }}
            </h5>
            <h5>
                ward {{ $setting->ward }}
            </h5>
            <button class="btn btn-primary">
                edit
            </button>
        </div> --}}



        {{-- <div class="card-body">
                    @if (isset($setting))
                        <livewire:settings.setting_form :action="\App\Enums\Action::UPDATE" :$setting />
                    @else
                        <livewire:settings.setting_form :action="\App\Enums\Action::CREATE" />
                    @endif
                </div> --}}

    </div>
</x-layout.app>
