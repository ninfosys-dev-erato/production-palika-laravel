<x-layout.app header="{{ __('Work Order ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.plans.work_orders.index') }}">{{ __('yojana::yojana.work_order') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($workOrder))
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
                    @if (!isset($workOrder))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($workOrder) ? __('yojana::yojana.create_work_order') : __('yojana::yojana.update_work_order') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.plans.work_orders.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.work_order_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($workOrder))
                    <livewire:yojana.work_order_form :$action :$workOrder />
                @else
                    <livewire:yojana.work_order_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
