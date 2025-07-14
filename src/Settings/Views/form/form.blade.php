<x-layout.app header="{{ __(ucfirst(strtolower($action->value)) .' Form Template') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('settings::settings.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('settings::settings.form') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (!isset($form))
                    {{ __('settings::settings.create') }}
                @else
                    {{ __('settings::settings.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('settings::settings.form') }} @if (!isset($form))
                        {{ __('settings::settings.create') }}
                    @else
                        {{ __('settings::settings.edit') }}
                    @endif
                    <div>
                        <a href="{{ url()->previous() }}" class="btn btn-info"><i class="bx bx-list-ol">
                            </i>{{ __('settings::settings.form_list') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($form))
                        <livewire:settings.form_form :$action :$form :$modules />
                    @else
                        <livewire:settings.form_form :$action :$modules />
                    @endif

                </div>
            </div>
        </div>
</x-layout.app>
