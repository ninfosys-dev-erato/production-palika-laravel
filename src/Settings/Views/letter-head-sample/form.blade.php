<x-layout.app header="Letter Head Sample {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('settings::settings.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('settings::settings.letter_head_sample') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (!isset($letterHeadSample))
                    {{ __('settings::settings.create') }}
                @else
                    {{ __('settings::settings.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('settings::settings.letter_head_sample') }} @if (!isset($letterHeadSample))
                        {{ __('settings::settings.create') }}
                    @else
                        {{ __('settings::settings.edit') }}
                    @endif
                    <div>
                        @perm('letter_head_sample access')
                            <a href="{{ route('admin.letter-head-sample.index') }}" class="btn btn-info"><i
                                    class="bx bx-list-ol"></i>{{ __('settings::settings.letter_head_sample_list') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($letterHeadSample))
                        <livewire:settings.letter_head_sample_form :$action :$letterHeadSample />
                    @else
                        <livewire:settings.letter_head_sample_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
