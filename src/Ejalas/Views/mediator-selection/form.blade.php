<x-layout.app header="{{ __('Mediator Selection ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.mediator_selections.index', ['from' => $from]) }}">{{ __('ejalas::ejalas.mediator_selection') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($mediatorSelection))
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
                    @if (!isset($mediatorSelection))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($mediatorSelection) ? __('ejalas::ejalas.create_mediator_selection') : __('ejalas::ejalas.update_mediator_selection') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.mediator_selections.index', ['from' => $from]) }}"
                            class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.mediator_selection_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($mediatorSelection))
                    <livewire:ejalas.mediator_selection_form :$action :$mediatorSelection :$from />
                @else
                    <livewire:ejalas.mediator_selection_form :$action :$from />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
