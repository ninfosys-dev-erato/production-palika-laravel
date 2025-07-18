<x-layout.app header="Fiscal Year {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('fiscalyears::fiscalyears.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('fiscalyears::fiscalyears.fiscal_year') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (!isset($fiscalYear))
                    {{ __('fiscalyears::fiscalyears.create') }}
                @else
                    {{ __('fiscalyears::fiscalyears.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('fiscalyears::fiscalyears.fiscal_year') }} @if (!isset($fiscalYear))
                        {{ __('fiscalyears::fiscalyears.create') }}
                    @else
                        {{ __('fiscalyears::fiscalyears.edit') }}
                    @endif
                    <div>
                        @perm('fiscal_years access')
                            <a href="{{ route('admin.setting.fiscal-years.index') }}" class="btn btn-info"><i
                                    class="bx bx-list-ol"></i>{{ __('fiscalyears::fiscalyears.fiscal_year_list') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($fiscalYear))
                        <livewire:fiscal_years.fiscal_year_form :$action :$fiscalYear />
                    @else
                        <livewire:fiscal_years.fiscal_year_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
