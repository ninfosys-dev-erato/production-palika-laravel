<x-layout.app header="PlanTemplate List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">PlanTemplate</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('plan_basic_settings create')
                        <a href="{{ route('admin.plan_templates.create') }}" class="btn btn-info"><i class="fa fa-plus"></i>
                            Add PlanTemplate</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:plan_templates.plan_template_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
