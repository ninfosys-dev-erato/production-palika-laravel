@php
    function getStatusColor($status)
    {
        switch (strtolower($status)) {
            case 'accepted':
                return 'bg-success text-white';
            case 'pending':
                return 'bg-warning text-dark';
            case 'rejected':
                return 'bg-danger text-white';
            default:
                return 'bg-secondary text-white';
        }
    }
    function getTextColor($status)
    {
        switch (strtolower($status)) {
            case 'accepted':
                return ' text-success';
            case 'pending':
                return ' text-warning';
            case 'rejected':
                return 'text-danger';
            default:
                return ' text-secondary';
        }
    }

@endphp

<x-layout.customer-app header="Customer Detail">

    <div class="col-md-12">
        <div class="">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-primary fw-bold mb-0">
                    {{ __('Customer Detail') }}</h5>
                @if (empty($customer->kyc_verified_at) && $customer->kyc)
                    <a href="{{ route('customer.kyc.create') }}"><i class="bx bx-edit"></i>{{ __('Update') }}</a>
                @endif
            </div>
            @if ($customer->kyc != null)
                <div class="card-01">
                    <div class="row">
                        <div class="col-md-4 d-flex align-items-stretch">
                            <div class="card-body border shadow-lg bg-white flex-fill" style="border-radius: 10px;">
                                @if ($customer->avatar)
                                    <img src="{{ customFileAsset(config('src.Customers.customer.avatar_path'), $customer->avatar, 'local', 'tempUrl') }}"
                                        alt="{{ $customer->name }}" class="mx-auto d-block rounded-circle"
                                        style="width: 100px; height: 100px;">
                                @elseif($customer->name)
                                    <img src="{{ Avatar::create($customer->name)->toBase64() }}"
                                        alt="{{ $customer->name }}" class="mx-auto d-block rounded-circle"
                                        style="width: 100px; height: 100px;">
                                @else
                                    <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}"
                                        alt="{{ $customer->name }}" class="mx-auto d-block rounded-circle"
                                        style="width: 100px; height: 100px;">
                                @endif
                                <hr>
                                <p><strong>{{ __('Name') }}:</strong> {{ $customer->name }}</p>
                                @if ($customer->email)
                                    <p><strong>{{ __('Email') }}:</strong> <a
                                            href="mailto:{{ $customer->email }}">{{ $customer->email }}</a> </p>
                                @endif
                                <p><strong>{{ __('Mobile') }}:</strong> <a
                                        href="tel:{{ $customer->mobile_no }}">{{ $customer->mobile_no }}</a></p>
                                <p><strong>{{ __('Gender') }}:</strong> {{ $customer->gender?->label() }}</p>
                                <p><strong>{{ __('Nepali Date of Birth') }}:</strong>
                                    {{ $customer->kyc->nepali_date_of_birth ?? 'Not Provided' }}</p>
                                <p><strong>{{ __('English Date of Birth') }}:</strong>
                                    {{ $customer->kyc->english_date_of_birth ?? 'Not Provided' }}</p>
                                <p>
                                    <strong>{{ __('KYC Status') }}: </strong>
                                    <span class="{{ getTextColor($customer->kyc->status->value) }}">
                                        {{ strtoupper($customer->kyc->status->value) }}
                                    </span>

                                </p>
                            </div>
                        </div>

                        <div class="col-md-8 d-flex align-items-stretch">
                            <div class="card-body border shadow-lg bg-light flex-fill" style="border-radius: 10px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>{{ __('Grand Father Name') }}:</strong>
                                            {{ $customer->kyc->grandfather_name ?? 'Not Provided' }}</p>
                                        <p><strong>{{ __('Father Name') }}:</strong>
                                            {{ $customer->kyc->father_name ?? 'Not Provided' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>{{ __('Mother Name') }}:</strong>
                                            {{ $customer->kyc->mother_name ?? 'Not Provided' }}
                                        </p>
                                        <p><strong>{{ __('Spouse Name') }}:</strong>
                                            {{ $customer->kyc->spouse_name ?? 'Not Provided' }}
                                        </p>
                                    </div>
                                </div>

                                <hr>
                                <h5 class=" text-decoration-underline" style="font-weight: bold;">
                                    {{ __('Permanent Address') }}
                                </h5>
                                <p>
                                    <strong>{{ __('Permanent Address') }}:</strong>
                                    {{ ($customer->kyc->permanentProvince->title ?? __('Not Provided')) .
                                        ', ' .
                                        ($customer->kyc->permanentDistrict->title ?? __('Not Provided')) .
                                        ', ' .
                                        ($customer->kyc->permanentLocalBody->title ?? __('Not Provided')) .
                                        ' - ' .
                                        ($customer->kyc->permanent_ward ?? __('Not Provided')) .
                                        ', ' .
                                        ($customer->kyc->permanent_tole ?? __('Not Provided')) }}
                                </p>

                                <hr>
                                <h5 class=" text-decoration-underline" style="font-weight: bold;">
                                    {{ __('Temporary Address') }}
                                </h5>
                                <p>
                                    <strong>{{ __('Temporary Address') }}:</strong>
                                    {{ ($customer->kyc->temporaryProvince->title ?? __('Not Provided')) .
                                        ', ' .
                                        ($customer->kyc->temporaryDistrict->title ?? __('Not Provided')) .
                                        ', ' .
                                        ($customer->kyc->temporaryLocalBody->title ?? __('Not Provided')) .
                                        ' - ' .
                                        ($customer->kyc->temporary_ward ?? __('Not Provided')) .
                                        ', ' .
                                        ($customer->kyc->temporary_tole ?? __('Not Provided')) }}
                                </p>

                                <hr>
                                <h5 class=" text-decoration-underline" style="font-weight: bold;">
                                    {{ __('Document Details') }}
                                </h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>{{ __('Document Type') }}:</strong>
                                        {{ $customer->kyc->document_type ?? __('Not Provided') }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>{{ __('Document Issued Date') }}:</strong>
                                        {{ $customer->kyc->document_issued_date_nepali ?? __('Not Provided') }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>{{ __('Document Issued District') }}:</strong>
                                        {{ $customer->kyc->citizenshipIssueDistrict->title ?? __('Not Provided') }}
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <strong>{{ __('Document Number') }}:</strong>
                                        {{ $customer->kyc->document_number ?? __('Not Provided') }}
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="card-body border shadow-lg bg-light flex-fill" style="border-radius: 2px;">
                                    <h5 class="text-center text-decoration-underline">{{ __('Document Images') }}
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>{{ __('Document Image 1') }}:</strong><br>
                                            @if ($customer->kyc->document_image1)
                                                @php
                                                    $fileUrl = customFileAsset(
                                                        config('src.CustomerKyc.customerKyc.path'),
                                                        $customer->kyc->document_image1,
                                                        getStorageDisk('private'),
                                                        'tempUrl',
                                                    );
                                                @endphp

                                                <a href="{{ $fileUrl }}" target="_blank"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bx bx-file"></i>
                                                    {{ __('yojana::yojana.view_uploaded_file') }}
                                                </a>
                                            @else
                                                <p>{{ __('Not Provided') }}</p>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <strong>{{ __('Document Image 2') }}:</strong><br>
                                            @if ($customer->kyc->document_image2)
                                                @php
                                                    $fileUrl = customFileAsset(
                                                        config('src.CustomerKyc.customerKyc.path'),
                                                        $customer->kyc->document_image2,
                                                        getStorageDisk('private'),
                                                        'tempUrl',
                                                    );
                                                @endphp

                                                <a href="{{ $fileUrl }}" target="_blank"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bx bx-file"></i>
                                                    {{ __('yojana::yojana.view_uploaded_file') }}
                                                </a>
                                            @else
                                                <p>{{ __('Not Provided') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">{{ __('Document Image') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body d-flex justify-content-center align-items-center">
                                            <img id="modalImage" src="" alt="Document Image" class="img-fluid"
                                                style="max-height: 100%; max-width: 100%;" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function showImage(src) {
                                    document.getElementById('modalImage').src = src;
                                }
                            </script>
                        </div>
                    </div>
                </div>
            @else
                <div class="card text-center border shadow-lg bg-light" style="border-radius: 10px;">
                    <div class="card-body">
                        <h5 class="card-title text-danger">{{ __('KYC Not Filled') }}</h5>
                        <p class="card-text">
                            {{ __('The customer has not filled out their KYC details yet.') }}
                        </p>
                        <a href="{{ route('customer.kyc.create') }}" class="btn btn-primary mt-3">
                            {{ __('Apply for KYC') }}
                        </a>
                    </div>
                </div>

            @endif
        </div>
    </div>
</x-layout.customer-app>
