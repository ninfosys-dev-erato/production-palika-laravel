<x-layout.app header="Fiscal Year List">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('fiscalyears::fiscalyears.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('fiscalyears::fiscalyears.fiscal_year') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('fiscalyears::fiscalyears.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('fiscalyears::fiscalyears.fiscal_year_list') }}
                    <div>
                        @perm('fiscal_year_create')
                            <a href="{{ route('admin.setting.fiscal-years.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i>{{ __('fiscalyears::fiscalyears.add_fiscal_year') }}</a>
                        @endperm
                    </div>

                </div>
                <div class="card-body">
                    <livewire:fiscal_years.fiscal_year_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
