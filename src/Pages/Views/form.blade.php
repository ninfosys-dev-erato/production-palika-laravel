<x-layout.app header="Page  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('pages::pages.page') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($page))
                    {{ __('pages::pages.create') }}
                @else
                    {{ __('pages::pages.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                @if (isset($page))
                    <livewire:pages.page_form :$action :$page />
                @else
                    <livewire:pages.page_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
