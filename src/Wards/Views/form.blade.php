<x-layout.app header="Ward  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">Ward</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($ward))
                    Create
                @else
                    Edit
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($ward))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($ward) ? __('wards::wards.create_ward') : __('wards::wards.update_ward') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.wards.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('wards::wards.ward_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($ward))
                    <livewire:wards.ward_form :$action :$ward />
                @else
                    <livewire:wards.ward_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
