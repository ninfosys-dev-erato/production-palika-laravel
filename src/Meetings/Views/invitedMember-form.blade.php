<x-layout.app header="InvitedMember  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ 'InvitedMember' }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Invited Member') }} @if (isset($invitedMember))
                    {{ __('Create') }}
                @else
                    {{ __('Edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card-header d-flex justify-content-between">
                {{ __('Invited Member create') }}
            </div>
            <div class="card">
                @if (isset($invitedMember))
                    <livewire:meetings.invited_member_form :$action :$invitedMember :meetingId="request('meeting')"/>
                @else
                    <livewire:meetings.invited_member_form :$action :meetingId="request('meeting')" />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>