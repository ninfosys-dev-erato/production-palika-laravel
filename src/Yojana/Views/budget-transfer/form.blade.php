<x-layout.app header="{{ __('Budget Transfer ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.budget_transfer.index') }}">{{ __('yojana::yojana.budget_transfer') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($budgetTransfer))
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
                    @if (!isset($budgetTransfer))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($budgetTransfer) ? __('yojana::yojana.create_budget_transfer') : __('yojana::yojana.update_budget_transfer') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.budget_transfer.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.budget_transfer_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($budgetTransfer))
                    <livewire:yojana.budget_transfer_form :$action :$budgetTransfer />
                @else
                    <livewire:yojana.budget_transfer_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
