<x-layout.app header="{{ __('Action Type ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-start">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.beruju.action-types.index') }}">{{ __('beruju::beruju.action_types') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($actionType))
                    {{ __('beruju::beruju.edit') }}
                @else
                    {{ __('beruju::beruju.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($actionType))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($actionType) ? __('beruju::beruju.create_action_type') : __('beruju::beruju.edit_action_type') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.beruju.action-types.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('beruju::beruju.back_to_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($actionType))
                    <livewire:beruju.action_type_form :$action :$actionType />
                @else
                    <livewire:beruju.action_type_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
