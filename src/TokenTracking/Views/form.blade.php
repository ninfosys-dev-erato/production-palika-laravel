<x-layout.app header="{{ __('Register Token ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.register_tokens.index') }}">{{ __('tokentracking::tokentracking.register_token') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($registerToken))
                    {{ __('tokentracking::tokentracking.edit') }}
                @else
                    {{ __('tokentracking::tokentracking.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (isset($registerToken))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($registerToken) ? __('tokentracking::tokentracking.create_register_token') : __('tokentracking::tokentracking.update_register_token') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.register_tokens.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('tokentracking::tokentracking.register_token_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($registerToken))
                    <livewire:token_tracking.register_token_form :$action :$registerToken />
                @else
                    <livewire:token_tracking.register_token_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
