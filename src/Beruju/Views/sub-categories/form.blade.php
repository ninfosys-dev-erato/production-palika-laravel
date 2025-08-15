<x-layout.app header="{{ __('Sub-Category ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-start">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.beruju.sub-categories.index') }}">{{ __('beruju::beruju.sub_categories') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($subCategory))
                    {{ __('beruju::beruju.edit') }}
                @else
                    {{ __('beruju::beruju.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($subCategory))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($subCategory) ? __('beruju::beruju.create_sub_category') : __('beruju::beruju.edit_sub_category') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.beruju.sub-categories.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('beruju::beruju.back_to_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($subCategory))
                    <livewire:beruju.sub_category_form :$action :$subCategory />
                @else
                    <livewire:beruju.sub_category_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
