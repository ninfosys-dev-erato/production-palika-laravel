<x-layout.app header="{{ __('Settlement ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.settlements.index', ['from' => $from]) }}">{{ __('ejalas::ejalas.settlement') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($settlement))
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
                    @if (!isset($settlement))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($settlement) ? __('ejalas::ejalas.create_settlement') : __('ejalas::ejalas.update_settlement') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.settlements.index', ['from' => $from]) }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.settlement_list') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @if (isset($settlement))
        <livewire:ejalas.settlement_form :$action :$settlement :$from />
    @else
        <livewire:ejalas.settlement_form :$action :$from />
    @endif
    </div>
</x-layout.app>
