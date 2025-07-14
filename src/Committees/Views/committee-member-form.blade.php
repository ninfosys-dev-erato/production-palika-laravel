<x-layout.app header="CommitteeMember  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Committee Member') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($committeeMember))
                    {{ __('Create') }}
                @else
                    {{ __('Edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($committeeMember))
                        <h5 class="text-primary fw-bold"> {{ __('Add Committee Member') }}</h5>
                    @else
                        <h5 class="text-primary fw-bold">{{ __('Update Committee Member') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.committee-members.index') }}" class="btn btn-info"><i
                                class="bx bx-list-ol"></i>{{ __('Committee Member List') }}</a>
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
