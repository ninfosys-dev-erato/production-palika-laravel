<x-layout.app header="{{ __('Budget Source ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.budget_sources.index') }}">{{ __('yojana::yojana.budget_source') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($budgetSource))
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
                    @if (!isset($budgetSource))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($budgetSource) ? __('yojana::yojana.create_budget_source') : __('yojana::yojana.update_budget_source') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.budget_sources.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.budget_source_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($budgetSource))
                    <livewire:yojana.budget_source_form :$action :$budgetSource />
                @else
                    <livewire:yojana.budget_source_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
