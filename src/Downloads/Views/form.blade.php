<x-layout.app header="Download  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('downloads::downloads.download') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($download))
                    {{ __('downloads::downloads.create') }}
                @else
                    {{ __('downloads::downloads.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex justify-content-between card-header">
                    <h5 class="text-primary fw-bold mb-0">{{ __('downloads::downloads.download_form') }}</h5>
                </div>
                @if (isset($download))
                    <livewire:downloads.download_form :$action :$download />
                @else
                    <livewire:downloads.download_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
