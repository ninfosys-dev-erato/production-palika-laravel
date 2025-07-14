<x-layout.app header="{{__('grantmanagement::grantmanagement.grant_release')}}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('grantmanagement::grantmanagement.grant_release') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('grantmanagement::grantmanagement.show') }}
            </li>
        </ol>
    </nav>


    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('grantmanagement::grantmanagement.grant_release_list') }}
                        </h5>
                    </div>
                    <div>
                        <div class="card-header d-flex justify-content-between">
                            @if (!isset($grantRelease))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($grantRelease) ? __('grantmanagement::grantmanagement.create_grant_release') : __('grantmanagement::grantmanagement.update_grant_release') }}
                                </h5>
                            @endif
                            <div>
                                <a href="{{ route('admin.grant_release.index') }}" class="btn btn-info">
                                    <i
                                        class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.grant_release_list') }}
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="row">

                            {{-- Grantee Type --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.grantee_type') }}:</strong>
                                {{ !empty($grantRelease) && isset($grantRelease->grantee_type) ? class_basename($grantRelease->grantee_type) : __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Grantee --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.grantee') }}:</strong>
                                {{ $grantee->name ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Grantee's Investment --}}
                            <div class="mb-3">
                                <strong>{{ __("Grantee's Investment") }}:</strong>
                                {{ $grantRelease->investment ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- New or Constantly --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.new_or_constantly') }}:</strong>
                                {{ $grantRelease->is_new_or_ongoing ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Last Year's Investment --}}
                            <div class="mb-3">
                                <strong>{{ __("Last Year's Investment") }}:</strong>
                                {{ $grantRelease->last_year_investment ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Plots No --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.plots_no') }}:</strong>
                                {{ $grantRelease->plot_no ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Grant Location --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.grant_location') }}:</strong>
                                {{ $grantRelease->location ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Contact Person --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.contact_person') }}:</strong>
                                {{ $grantRelease->contact_person ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Contact No --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.contact_no') }}:</strong>
                                {{ $grantRelease->contact_no ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Condition --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.condition') }}:</strong>
                                {{ $grantRelease->condition ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('admin.grant_release.index') }}" class="btn btn-danger">
                            {{ __('grantmanagement::grantmanagement.back') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout.app>