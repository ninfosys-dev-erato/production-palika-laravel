<x-layout.app header="Form List">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('settings::settings.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('settings::settings.form') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('settings::settings.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('settings::settings.form_list') }}</h5>
                    </div>
                    @perm('form create')
                        <div>
                            <a href="{{ route('admin.setting.form.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('settings::settings.add_form') }}</a>
                        </div>
                    @endperm


                </div>
                <div class="card-body">
                    <livewire:settings.form_table :modules="$modules" theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
