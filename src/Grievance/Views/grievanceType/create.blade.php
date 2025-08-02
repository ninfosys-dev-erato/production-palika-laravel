<x-layout.app header="{{ __('grievance::grievance.grievance_type_form') }}">


    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.grievance') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.grievance_type') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __(ucfirst(strtolower($action->value))) }}
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ $action->value === 'create' ? __('grievance::grievance.add_grievance_type') : __('grievance::grievance.update_grievance_type') }}
                    </h5>
                    <div>
                        @perm('grievance_setting access')
                            <a href="{{ route('admin.grievance.grievanceType.index') }}" class="btn btn-info"><i
                                    class="bx bx-list-ol"></i>{{ __('grievance::grievance.grievance_type_list') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($grievanceType))
                        <livewire:grievance.grievance_type_form :$action :$grievanceType />
                    @else
                        <livewire:grievance.grievance_type_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
