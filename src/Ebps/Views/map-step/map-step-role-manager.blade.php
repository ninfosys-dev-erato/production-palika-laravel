<x-layout.app header="{{ __('ebps::ebps.manage_step_roles') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ebps.map_steps.index') }}">{{ __('ebps::ebps.map_steps') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.manage_step_roles') }}</li>
        </ol>
    </nav>

    <div class="row g-6">
        <div class="col-md-12">
            <livewire:ebps.step_role_manager :mapStep="$mapStep" theme="bootstrap-4" />
        </div>
    </div>
</x-layout.app>
