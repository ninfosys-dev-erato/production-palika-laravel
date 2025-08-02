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
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    {{ __('settings::settings.letter_head_sample_list') }}
                    <div class="d-flex gap-2">
                        @perm('letter_head_sample create')
                            <a href="{{ route('admin.letter-head-sample.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('settings::settings.add_letter_head_sample') }}</a>
                        @endperm
                    </div>
                </div>

            </div>
            <livewire:settings.letter_head_sample_display />
        </div>
    </div>


</x-layout.app>
