<x-layout.app header="CommitteeMember  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('yojana::yojana.committee_member') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($committeeMember))
                    {{ __('yojana::yojana.create') }}
                @else
                    {{ __('yojana::yojana.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($committeeMember))
                        <h5 class="text-primary fw-bold"> {{ __('yojana::yojana.add_committee_member') }}</h5>
                    @else
                        <h5 class="text-primary fw-bold">{{ __('yojana::yojana.update_committee_member') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.committee-members.index') }}" class="btn btn-info"><i
                                class="bx bx-list-ol"></i>{{ __('yojana::yojana.committee_member_list') }}</a>
                    </div>
                </div>
                @if (isset($committeeMember))
                    <livewire:committees.committee_member_form :$action :$committeeMember />
                @else
                    <livewire:committees.committee_member_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
