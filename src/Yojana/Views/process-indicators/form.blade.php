<x-layout.app header="{{ __('Process Indicator ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.process_indicators.index') }}">{{ __('yojana::yojana.process_indicator') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($processIndicator))
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
                    @if (!isset($processIndicator))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($processIndicator) ? __('yojana::yojana.create_process_indicator') : __('yojana::yojana.update_process_indicator') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.process_indicators.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.process_indicator_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($processIndicator))
                    <livewire:yojana.process_indicator_form :$action :$processIndicator />
                @else
                    <livewire:yojana.process_indicator_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
