<x-layout.app header="{{__('Consumer Committee Member '.ucfirst(strtolower($action->value)) .' Form')}} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{route('admin.consumer_committee_members.index')}}">{{__('yojana::yojana.consumer_committee_member')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if(isset($consumerCommitteeMember))
                    {{__('yojana::yojana.edit')}}
                @else
                    {{__('yojana::yojana.create')}}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($consumerCommitteeMember))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($consumerCommitteeMember) ? __('yojana::yojana.create_consumer_committee_member') : __('yojana::yojana.update_consumer_committee_member') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route("admin.consumer_committee_members.index")}}"
                           class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.consumer_committee_member_list') }}
                        </a>
                    </div>
                </div>
                @if(isset($consumerCommitteeMember))
                    <livewire:yojana.consumer_committee_member_form :$action :$consumerCommitteeMember />
                @else
                    <livewire:yojana.consumer_committee_member_form :$action :$consumerCommitteeId/>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
