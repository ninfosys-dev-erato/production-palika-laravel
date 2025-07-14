<x-layout.app header="{{__('grantmanagement::grantmanagement.farmer_list')}}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('grantmanagement::grantmanagement.farmer')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{__('grantmanagement::grantmanagement.list')}}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ isset($farmer) ? __('grantmanagement::grantmanagement.farmer') : __('grantmanagement::grantmanagement.create_farmer') }}
                    </h5>

                    <div>
                        <a href="{{ route('admin.farmers.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i> {{ __('grantmanagement::grantmanagement.farmer_list') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3">
                                    {{ __('grantmanagement::grantmanagement.farmer_details') }}
                                </h6>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.name') }}:</strong>
                                    {{ $farmer->user->name ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.contact_no') }}:</strong>
                                    {{ $farmer->phone_no ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.gender') }}:</strong>
                                    {{ ucfirst($farmer->gender ?? __('grantmanagement::grantmanagement.n_a')) }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.marital_status') }}:</strong>
                                    {{ ucfirst($farmer->marital_status ?? __('grantmanagement::grantmanagement.n_a')) }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.fathers_name') }}:</strong>
                                    {{ $farmer->father_name ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.grandfathers_name') }}:</strong>
                                    {{ $farmer->grandfather_name ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.citizenship_no') }}:</strong>
                                    {{ $farmer->citizenship_no ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.farmer_id_card_no') }}:</strong>
                                    {{ $farmer->farmer_id_card_no ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.national_id_card_no') }}:</strong>
                                    {{ $farmer->national_id_card_no ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mt-4 mb-3">
                                    {{ __('grantmanagement::grantmanagement.permanent_address') }}
                                </h6>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.province') }}:</strong>
                                    {{ $farmer->province->title ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.district') }}:</strong>
                                    {{ $farmer->district->title ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.local_body') }}:</strong>
                                    {{ $farmer->localBody->title ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.ward') }}:</strong>
                                    {{ $farmer->ward->ward_name_ne ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.village') }}:</strong>
                                    {{ $farmer->village ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.tole') }}:</strong>
                                    {{ $farmer->tole ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3">
                                    {{ __('grantmanagement::grantmanagement.household_relationship') }}
                                </h6>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.related_farmers') }}:</strong>
                                    @forelse ($relatedFarmers as $relatedFarmer)
                                        <span
                                            class="badge bg-light text-dark">{{ $relatedFarmer->first_name ?? __('grantmanagement::grantmanagement.n_a') }}</span>
                                    @empty
                                        <span class="text-muted">N/A</span>
                                    @endforelse
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.relationships') }}:</strong>
                                    @forelse ($farmer->relationships ?? [] as $relationship)
                                        <span class="badge bg-light text-dark">{{ $relationship ?? __('grantmanagement::grantmanagement.n_a') }}</span>
                                    @empty
                                        <span class="text-muted">N/A</span>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Photo Field -->
                                <div class="row mt-4">
                                    <div class='col-md-6 mb-4'>
                                        <div class="form-group">
                                            <h6 class="border-bottom pb-2 mt-4 mb-3">
                                                {{ __('grantmanagement::grantmanagement.photo') }}
                                            </h6>

                                            @if(!empty($farmer) && $farmer->photo)
                                                @php
                                                    $extension = strtolower(pathinfo($farmer->photo, PATHINFO_EXTENSION));
                                                @endphp

                                                @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ customAsset(config('src.GrantManagement.grant.photo'), $farmer->photo) }}"
                                                        alt="Farmer Photo" class="img-thumbnail mt-2" style="height: 300px;">
                                                @elseif($extension === 'pdf')
                                                    <div class="card mt-2" style="max-width: 200px;">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                {{ __('grantmanagement::grantmanagement.pdf_file') }}
                                                            </h5>
                                                            <p class="card-text">{{ $farmer->photo }}</p>
                                                            <a href="{{ customFileAsset(config('src.GrantManagement.grant.photo'), $farmer->photo) }}"
                                                                target="_blank" class="btn btn-primary btn-sm">
                                                                {{ __('grantmanagement::grantmanagement.open_pdf') }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <p class="text-muted">
                                                    {{ __('grantmanagement::grantmanagement.no_photo_available') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('admin.farmers.index') }}" class="btn btn-danger">
                            {{ __('grantmanagement::grantmanagement.back') }}
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-layout.app>