<x-layout.app header="{{__('grievance::grievance.grievance_list')}}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.grievance_detail') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('grievance::grievance.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('grievance::grievance.grievance_detail_list') }}
                    </h5>
                    <div>
                        <a href="{{ route('admin.grievance.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                            {{ __('grievance::grievance.add_grievance') }}</a>

                    </div>
                </div>
                <div class="card-body">
                    <livewire:grievance.grievance_detail_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
