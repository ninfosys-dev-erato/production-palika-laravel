<x-layout.app>

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('settings::settings.app_setting') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">

                <div class="d-flex justify-content-between card-header">
                    <h5>{{ __('settings::settings.app_setting') }}</h5>
                </div>
                <div class="card-body">
                    @if (isset($appSetting))
                        <livewire:settings.app_setting_form :action="\App\Enums\Action::UPDATE" :$appSetting />
                    @else
                        <livewire:settings.app_setting_form :action="\App\Enums\Action::CREATE" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
