<x-layout.app header="{{ __('downloads::downloads.download_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('downloads::downloads.download') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('downloads::downloads.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('downloads::downloads.download_list') }}</h5>
                    </div>

                    @perm('downloads_create')
                        <div>
                            <a href="{{ route('admin.downloads.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('downloads::downloads.add_download') }}</a>

                        </div>
                    @endperm

                </div>

                <div class="card-body">
                    <livewire:downloads.download_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
