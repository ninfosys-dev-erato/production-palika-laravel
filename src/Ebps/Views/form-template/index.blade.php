<x-layout.app header="{{ __('ebps::ebps.form_template_list') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.ebps') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.form_template') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('ebps::ebps.form_template_list') }}</h5>
                    </div>
                    @perm('form create')
                        <div>
                            <a href="{{ route('admin.ebps.form.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('ebps::ebps.add_form_template') }}</a>
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
