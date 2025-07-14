<x-layout.app header="BenefitedMemberDetail  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">BenefitedMemberDetail</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($benefitedMemberDetail))
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
                            @if (!isset($benefitedMemberDetail))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($benefitedMemberDetail) ? __('yojana::yojana.create_benefitedmemberdetail') : __('yojana::yojana.update_benefitedmemberdetail') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.benefited_member_details.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.benefitedmemberdetail_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($benefitedMemberDetail))
            <livewire:benefited_member_details.benefited_member_detail_form  :$action :$benefitedMemberDetail />
        @else
            <livewire:benefited_member_details.benefited_member_detail_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
