<x-layout.app header="{{ __('Implementation Level ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.implementation_levels.index') }}">{{ __('yojana::yojana.implementation_level') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($implementationLevel))
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
                    @if (!isset($implementationLevel))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($implementationLevel) ? __('yojana::yojana.create_implementation_level') : __('yojana::yojana.update_implementation_level') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.implementation_levels.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.implementation_level_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($implementationLevel))
                    <livewire:yojana.implementation_level_form :$action :$implementationLevel />
                @else
                    <livewire:yojana.implementation_level_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
