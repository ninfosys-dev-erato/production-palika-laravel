<x-layout.app header="Form Create {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('recommendation::recommendation.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('recommendation::recommendation.form') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (!isset($form))
                    {{ __('recommendation::recommendation.create') }}
                @else
                    {{ __('recommendation::recommendation.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('recommendation::recommendation.form') }} @if (!isset($form))
                        {{ __('recommendation::recommendation.create') }}
                    @else
                        {{ __('recommendation::recommendation.edit') }}
                    @endif
                    <div>
                        <a href="{{ route('admin.setting.form.index') }}" class="btn btn-info"><i class="bx bx-list-ol">
                            </i>{{ __('recommendation::recommendation.form_list') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($form))
                        <livewire:settings.form_form :$action :$form :$modules />
                    @else
                        <livewire:settings.form_form :$action :$modules />
                    @endif

                </div>
            </div>
        </div>
</x-layout.app>
