<x-layout.app header="Organization  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('ebps::ebps.organization')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($organization))
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
                    @if (!isset($organization))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($organization) ? __('ebps::ebps.create_organization') : __('ebps::ebps.update_organization') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.organizations.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.organization_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($organization))
                    <livewire:ebps.organization_form :$action :$organization />
                @else
                    <livewire:ebps.organization_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
