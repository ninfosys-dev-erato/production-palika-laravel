<x-layout.app header="ExpenseHead  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">ExpenseHead</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($expenseHead))
                {{__('yojana::yojana.edit')}}
                @else
                {{__('yojana::yojana.create')}}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($expenseHead))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($expenseHead) ? __('yojana::yojana.create_expensehead') : __('yojana::yojana.update_expensehead') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.expense_heads.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.expensehead_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($expenseHead))
                    <livewire:yojana.expense_head_form :$action :$expenseHead />
                @else
                    <livewire:yojana.expense_head_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
