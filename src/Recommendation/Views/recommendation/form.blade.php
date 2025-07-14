<x-layout.app header="{{ __('recommendation::recommendation.recommendation_form') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('recommendation::recommendation.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('recommendation::recommendation.recommendation') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (!isset($recommendation))
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
                    @if (!isset($recommendation))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('recommendation::recommendation.create_recommendation') }}</h5>
                    @else
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('recommendation::recommendation.update_recommendation') }}</h5>
                    @endif
                    <div>
                        @perm('letter_head access')
                            <a href="{{ route('admin.recommendations.recommendation.index') }}" class="btn btn-info">
                                <i class="bx bx-list-ol"></i>{{ __('recommendation::recommendation.recommendation_list') }}
                            </a>
                        @endperm
                    </div>
                </div>

                <div class="card-body">
                    @if (isset($recommendation))
                        <livewire:recommendation.recommendation_form :$action :$recommendation />
                    @else
                        <livewire:recommendation.recommendation_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
