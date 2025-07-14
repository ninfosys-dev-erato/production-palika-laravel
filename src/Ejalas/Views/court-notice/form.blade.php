<x-layout.app header="{{ __('Court Notice ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.court_notices.index') }}">{{ __('ejalas::ejalas.court_notice') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($courtNotice))
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
                    @if (!isset($courtNotice))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($courtNotice) ? __('ejalas::ejalas.create_court_notice') : __('ejalas::ejalas.update_court_notice') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.court_notices.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.court_notice_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($courtNotice))
                    <livewire:ejalas.court_notice_form :$action :$courtNotice />
                @else
                    <livewire:ejalas.court_notice_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
