<x-layout.app header="{{ __('Grant Type ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.grant_types.index') }}">{{ __('grantmanagement::grantmanagement.grant_type') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($grantType))
                    {{ __('grantmanagement::grantmanagement.edit') }}
                @else
                    {{ __('grantmanagement::grantmanagement.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($grantType))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($grantType) ? __('grantmanagement::grantmanagement.create_grant_type') : __('grantmanagement::grantmanagement.update_grant_type') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.grant_types.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.grant_type_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($grantType))
                    <livewire:grant_management.grant_type_form :$action :$grantType />
                @else
                    <livewire:grant_management.grant_type_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
