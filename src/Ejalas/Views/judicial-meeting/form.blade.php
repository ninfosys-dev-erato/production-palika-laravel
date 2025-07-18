<x-layout.app header="{{ __('Judicial Meeting ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.judicial_meetings.index') }}">{{ __('ejalas::ejalas.judicial_meeting') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($judicialMeeting))
                    {{ __('ejalas::ejalas.edit') }}
                @else
                    {{ __('ejalas::ejalas.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($judicialMeeting))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($judicialMeeting) ? __('ejalas::ejalas.create_judicial_meeting') : __('ejalas::ejalas.update_judicial_meeting') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.judicial_meetings.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.judicial_meeting_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($judicialMeeting))
                    <livewire:ejalas.judicial_meeting_form :$action :$judicialMeeting />
                @else
                    <livewire:ejalas.judicial_meeting_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
