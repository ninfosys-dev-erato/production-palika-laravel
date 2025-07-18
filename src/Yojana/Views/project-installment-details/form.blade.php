<x-layout.app header="ProjectInstallmentDetail  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">ProjectInstallmentDetail</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($projectInstallmentDetail))
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
                            @if (!isset($projectInstallmentDetail))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($projectInstallmentDetail) ? __('yojana::yojana.create_projectinstallmentdetail') : __('yojana::yojana.update_projectinstallmentdetail') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.project_installment_details.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.projectinstallmentdetail_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($projectInstallmentDetail))
            <livewire:project_installment_details.project_installment_detail_form  :$action :$projectInstallmentDetail />
        @else
            <livewire:project_installment_details.project_installment_detail_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
