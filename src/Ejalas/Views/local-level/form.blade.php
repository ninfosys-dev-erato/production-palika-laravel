<x-layout.app header="{{ __('Local Level ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.local_levels.index') }}">{{ __('ejalas::ejalas.local_level') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($localLevel))
                    {{ __('ejalas::ejalas.edit') }}
                @else
                    {{ __('ejalas::ejalas.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($localLevel))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($localLevel) ? __('ejalas::ejalas.create_local_level') : __('ejalas::ejalas.update_local_level') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.local_levels.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.local_level_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($localLevel))
                    <livewire:ejalas.local_level_form :$action :$localLevel />
                @else
                    <livewire:ejalas.local_level_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
