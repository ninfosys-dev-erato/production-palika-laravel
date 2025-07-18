<x-layout.app header="BudgetHead  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">BudgetHead</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($budgetHead))
                    Create
                @else
                    Edit
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($budgetHead))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($budgetHead) ? __('yojana::yojana.create_budgethead') : __('yojana::yojana.update_budgethead') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.budget_heads.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.budgethead_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($budgetHead))
                    <livewire:yojana.budget_head_form :$action :$budgetHead />
                @else
                    <livewire:yojana.budget_head_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
