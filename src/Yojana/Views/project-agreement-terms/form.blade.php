<x-layout.app header="ProjectAgreementTerm  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">ProjectAgreementTerm</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($projectAgreementTerm))
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
                            @if (!isset($projectAgreementTerm))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($projectAgreementTerm) ? __('yojana::yojana.create_projectagreementterm') : __('yojana::yojana.update_projectagreementterm') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.project_agreement_terms.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.projectagreementterm_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($projectAgreementTerm))
            <livewire:project_agreement_terms.project_agreement_term_form  :$action :$projectAgreementTerm />
        @else
            <livewire:project_agreement_terms.project_agreement_term_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
