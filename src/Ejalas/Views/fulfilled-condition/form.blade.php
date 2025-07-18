<x-layout.app header="{{ __('Fulfilled Condition ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.fulfilled_conditions.index', ['from' => $from]) }}">{{ __('ejalas::ejalas.fulfilled_condition') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($fulfilledCondition))
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
                    @if (!isset($fulfilledCondition))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($fulfilledCondition) ? __('ejalas::ejalas.create_fulfilled_condition') : __('ejalas::ejalas.update_fulfilled_condition') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.fulfilled_conditions.index', ['from' => $from]) }}"
                            class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.fulfilled_condition_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($fulfilledCondition))
                    <livewire:ejalas.fulfilled_condition_form :$action :$fulfilledCondition :$from />
                @else
                    <livewire:ejalas.fulfilled_condition_form :$action :$from />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
