<x-layout.app header="{{ __('Source Type ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.source_types.index') }}">{{ __('yojana::yojana.source_type') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($sourceType))
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
                    @if (!isset($sourceType))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($sourceType) ? __('yojana::yojana.create_source_type') : __('yojana::yojana.update_source_type') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.source_types.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.source_type_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($sourceType))
                    <livewire:yojana.source_type_form :$action :$sourceType />
                @else
                    <livewire:yojana.source_type_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
