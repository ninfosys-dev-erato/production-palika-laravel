<x-layout.app header="{{__('grantmanagement::grantmanagement.enterprise_list')}}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('grantmanagement::grantmanagement.group')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{__('grantmanagement::grantmanagement.list')}}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('grantmanagement::grantmanagement.enterprise_list') }}
                        </h5>
                    </div>
                    <div>
                        <div>
                            <a href="{{ route("admin.enterprises.index")}}" class="btn btn-info">
                                <i
                                    class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.enterprise_list') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">
                                {{ __('grantmanagement::grantmanagement.enterprise') }}
                            </h6>
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.unique_id') }}:</strong>
                                {{ $enterprise->unique_id ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.name') }}:</strong>
                                {{ $enterprise->name ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.vat_pan') }}:</strong>
                                {{ $enterprise->vat_pan ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.enterprise_type') }}:</strong>
                                {{ $enterprise->enterprise_type->title ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>
                            @if(!empty($farmer) && $enterprise->farmer_id)
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.associated_farmer') }}:</strong>
                                    <a href="{{ route('farmers.show', $enterprise->farmer_id) }}">
                                        {{ $enterprise->farmer->name ?? 'Farmer #' . $enterprise->farmer_id }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">
                                {{ __('grantmanagement::grantmanagement.address') }}
                            </h6>
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.province') }}:</strong>
                                {{ $enterprise->province->title ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.district') }}:</strong>
                                {{ $enterprise->district->title ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.local_body') }}:</strong>
                                {{ $enterprise->localBody->title ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.ward_no') }}:</strong>
                                {{ $enterprise->ward->ward_name_ne ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.village') }}:</strong>
                                {{ $enterprise->village ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.tole') }}:</strong>
                                {{ $enterprise->tole ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('admin.enterprises.index') }}" class="btn btn-danger">
                            {{ __('grantmanagement::grantmanagement.back') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout.app>