<x-layout.app header="ConstructionType  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('ebps::ebps.construction_type')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($constructionType))
                    {{__('ebps::ebps.create')}}
                @else
                    {{__('ebps::ebps.edit')}}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($constructionType))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($constructionType) ? __('ebps::ebps.create_construction_type') : __('ebps::ebps.update_construction_type') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.construction_types.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.construction_type_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($constructionType))
                    <livewire:ebps.construction_type_form :$action :$constructionType />
                @else
                    <livewire:ebps.construction_type_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
