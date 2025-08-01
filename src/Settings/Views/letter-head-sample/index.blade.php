<x-layout.app header="Letter Head Sample List">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('settings::settings.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('settings::settings.letter_head_sample') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('settings::settings.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('settings::settings.letter_head_sample_list') }}
                    @perm('letter_head_sample create')
                        <div>
                            <a href="{{ route('admin.letter-head-sample.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('settings::settings.add_letter_head_sample') }}</a>
                        </div>
                    @endperm

                </div>
                <div class="card-body">
                    <livewire:settings.letter_head_sample_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
