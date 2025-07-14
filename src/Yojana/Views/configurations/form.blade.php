<x-layout.app header="{{ __('Configuration ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.configurations.index') }}">{{ __('yojana::yojana.configuration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($configuration))
                    {{ __('yojana::yojana.edit') }}
                @else
                    {{ __('yojana::yojana.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($configuration))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($configuration) ? __('yojana::yojana.create_configuration') : __('yojana::yojana.update_configuration') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.configurations.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.configuration_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($configuration))
                    <livewire:yojana.configuration_form :$action :$configuration />
                @else
                    <livewire:yojana.configuration_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
