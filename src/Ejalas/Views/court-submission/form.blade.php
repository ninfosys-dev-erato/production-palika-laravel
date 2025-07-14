<x-layout.app header="{{ __('Court Submission ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.court_submissions.index') }}">{{ __('ejalas::ejalas.court_submission') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($courtSubmission))
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
                    @if (!isset($courtSubmission))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($courtSubmission) ? __('ejalas::ejalas.create_court_submission') : __('ejalas::ejalas.update_court_submission') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.court_submissions.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.court_submission_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($courtSubmission))
                    <livewire:ejalas.court_submission_form :$action :$courtSubmission />
                @else
                    <livewire:ejalas.court_submission_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
