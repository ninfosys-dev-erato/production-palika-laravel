<x-layout.app header="{{ __('Priotity ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.priotities.index') }}">{{ __('ejalas::ejalas.priotity') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($priotity))
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
                    @if (!isset($priotity))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($priotity) ? __('ejalas::ejalas.create_priotity') : __('ejalas::ejalas.update_priotity') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.priotities.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.priotity_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($priotity))
                    <livewire:ejalas.priotity_form :$action :$priotity />
                @else
                    <livewire:ejalas.priotity_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
