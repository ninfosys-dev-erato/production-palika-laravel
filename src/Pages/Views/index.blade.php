<x-layout.app header="Page List">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('pages::pages.page') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('pages::pages.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('pages::pages.list') }}
                    @perm('page_create')
                        <div>
                            <a href="{{ route('admin.pages.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('pages::pages.add_page') }}</a>
                        </div>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:pages.page_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
