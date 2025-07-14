<x-layout.app header="Meeting List">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold mb-0">{{ __('Manage Meeting') }}</h5>
        <a href="{{ route('admin.meetings.index') }}" class="btn btn-info"><i
                class="bx bx-list-ul"></i>{{ __('Meeting List') }}</a>
    </div>
    <div class="nav-align-left mb-6">
        <ul class="nav nav-pills me-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-home" aria-controls="navs-pills-home" aria-selected="true">
                    {{ __('Home') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-invited-members" aria-controls="navs-pills-members"
                    aria-selected="false" tabindex="-1">
                    {{ __('Invited Members') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-agendas" aria-controls="navs-pills-left-agendas" aria-selected="false"
                    tabindex="-1">{{ __('Agendas') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-participants" aria-controls="navs-pills-left-participants"
                    aria-selected="false" tabindex="-1">{{ __('Participants') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-decisions" aria-controls="navs-pills-left-decisions"
                    aria-selected="false" tabindex="-1">{{ __('Decisions') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-minutes" aria-controls="navs-pills-left-minutes" aria-selected="false"
                    tabindex="-1">{{ __('Minutes') }}</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-home" role="tabpanel">
                <livewire:meetings.meeting_details :$meeting />
            </div>
            <div class="tab-pane fade" id="navs-pills-invited-members" role="tabpanel">
                <ul class="nav nav-pills me-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-left-home" aria-controls="navs-left-home"
                            aria-selected="true">{{ __('List') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-left-profile" aria-controls="navs-left-profile" aria-selected="false"
                            tabindex="-1">{{ __('Add New') }}</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="navs-left-home" role="tabpanel">
                        <livewire:meetings.invited_member_table theme="bootstrap-4" :meetingId="$meeting->id" />
                    </div>
                    <div class="tab-pane fade" id="navs-left-profile" role="tabpanel">
                        <livewire:meetings.invited_member_form :$action :meetingId="$meeting->id" />
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="navs-pills-agendas" role="tabpanel">
                <ul class="nav nav-pills me-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-left-agenda-index" aria-controls="navs-left-home"
                            aria-selected="true">{{ __('List') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-left-agenda" aria-controls="navs-left-profile"
                            aria-selected="false" tabindex="-1">{{ __('Add New') }}</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="navs-left-agenda-index" role="tabpanel">
                        <livewire:meetings.agenda_table theme="bootstrap-4" :meetingId="$meeting->id" />
                    </div>
                    <div class="tab-pane fade" id="navs-left-agenda" role="tabpanel">
                        <livewire:meetings.agenda_form :$action :meetingId="$meeting->id" />
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="navs-pills-participants" role="tabpanel">
                <ul class="nav nav-pills me-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-left-participants-index"
                            aria-controls="navs-left-participants-index"
                            aria-selected="true">{{ __('List') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-left-participants" aria-controls="navs-left-participants"
                            aria-selected="false" tabindex="-1">{{ __('Add New') }}</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="navs-left-participants-index" role="tabpanel">
                        <livewire:meetings.participant_table theme="bootstrap-4" :meetingId="$meeting->id" />
                    </div>
                    <div class="tab-pane fade" id="navs-left-participants" role="tabpanel">
                        <livewire:meetings.participant_form :$action :meetingId="$meeting->id" />
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="navs-pills-decisions" role="tabpanel">
                <ul class="nav nav-pills me-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-left-decisions-index" aria-controls="navs-left-decisions-index"
                            aria-selected="true">{{ __('List') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-left-decisions" aria-controls="navs-left-decisions"
                            aria-selected="false" tabindex="-1">{{ __('Add New') }}</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="navs-left-decisions-index" role="tabpanel"
                        style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                        <livewire:meetings.decision_table theme="bootstrap-4" :meetingId="$meeting->id" />
                    </div>
                    <div class="tab-pane fade" id="navs-left-decisions" role="tabpanel"
                        style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                        <livewire:meetings.decision_form :$action :meetingId="$meeting->id" />
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="navs-pills-minutes" role="tabpanel"
                style="overflow: hidden; max-width: 90%;">
                <div class="nav-align-left nav-tabs-shadow mb-6" style="overflow-x: hidden;">
                    <ul class="nav nav-pills me-4" role="tablist"></ul>
                    <div class="tab-pane fade active show" id="navs-left-minutes-index" role="tabpanel"
                        style="width: 100%; overflow: hidden;">
                        @if (isset($minute))
                            <livewire:meetings.minute_form :action=App\Enums\Action::UPDATE :$minute
                                :meetingId="$meeting->id" />
                        @else
                            <livewire:meetings.minute_form :$action :meetingId="$meeting->id" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
