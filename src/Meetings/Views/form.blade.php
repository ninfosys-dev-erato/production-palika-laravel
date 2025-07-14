<x-layout.app header="Meeting  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Meeting') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($meeting))
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
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="mb-4" style="color: #737380; font-weight: bold;">
                            @if (!isset($meeting))
                                {{ __('Create Meeting') }}
                            @else
                                {{ __('Edit Meeting') }}
                            @endif
                        </h3>
                        <div>
                            <a href="{{ route('admin.meetings.index') }}" class="btn btn-info"><i
                                    class="bx bx-list-ol"></i>{{ __('Meeting List') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (isset($meeting))
                            <livewire:meetings.meeting_form :$action :$meeting />
                        @else
                            <livewire:meetings.meeting_form :$action :meetingId="request('meeting')" />
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout.app>
