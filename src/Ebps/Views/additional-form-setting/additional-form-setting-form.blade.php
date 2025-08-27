<x-layout.app header="AdditionalFormSetting {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.additional_form_settings') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($additionalForm))
                    {{ __('ebps::ebps.edit') }}
                @else
                    {{ __('ebps::ebps.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($additionalForm))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($additionalForm) ? __('ebps::ebps.create_additional_form_setting') : __('ebps::ebps.edit_additional_form_setting') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.additional_form_settings.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.additional_form_settings') }}
                        </a>
                    </div>
                </div>
                @if (isset($additionalForm))
                    <livewire:ebps.additional_form_setting_form :$action :$additionalForm />
                @else
                    <livewire:ebps.additional_form_setting_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
