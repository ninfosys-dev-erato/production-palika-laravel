@php
    function getTextColor($status)
    {
        switch (strtolower($status)) {
            case 'closed':
                return ' text-success';
            case 'replied':
                return ' text-primary';
            case 'investigating':
                return ' text-primary';
            case 'unseen':
                return ' text-warning';
            case 'medium':
                return ' text-warning';
            case 'high':
                return ' text-danger';
            case 'low':
                return ' text-primary';
            default:
                return ' text-dark';
        }
    }
@endphp

<x-layout.app header="{{__('grievance::grievance.grievance_detail')}}">
    <div class="container">

        <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.grievance_detail') }}</a>
                </li>
            </ol>
        </nav>
        <div class="col-md-12">
            <div class="">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="text-primary fw-bold mb-0">{{ __('grievance::grievance.grievance_details') }}</h5>
                    <a href="javascript:history.back()" class="btn btn-info"><i
                            class="bx bx-arrow-back"></i>{{ __('grievance::grievance.back') }}</a>
                </div>
                <div class="col-12">
                    <div class="card mb-5 shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <h4 class="mb-4 text-primary fw-bold">{{ __('grievance::grievance.token') }}: {{ $grievanceDetail->token }}
                            </h4>
                            <div class="row gy-3">

                                <div class="col-md-4 col-12">
                                    <i
                                        class="bx {{ $grievanceDetail->is_public ? 'bx-check-circle text-success' : 'bx-x-circle text-danger' }} me-2"></i>
                                    <span class="fw-medium">{{ __('grievance::grievance.is_public') }}:</span>
                                    <span>{{ $grievanceDetail->is_public ? __('grievance::grievance.yes') : __('grievance::grievance.no') }}</span>
                                </div>

                                <div class="col-md-4 col-12">
                                    <i class="bx bx-calendar-check text-secondary me-2"></i>
                                    <span class="fw-medium">{{ __('grievance::grievance.status') }}:</span>
                                    <span class="{{ getTextColor($grievanceDetail->status->value) }}">
                                        {{ strtoupper(__($grievanceDetail->status->value)) }}
                                    </span>
                                </div>
                                @if ($grievanceDetail->approved_at)
                                    <div class="col-md-4 col-12">
                                        <i class="bx bx-calendar text-secondary me-2"></i>
                                        <span class="fw-medium">{{ __('grievance::grievance.approved_date') }}:</span>
                                        <span>{{ $grievanceDetail->approved_at }}</span>
                                    </div>
                                @endif
                                <!-- Priority -->
                                <div class="col-md-4 col-12">
                                    <i class="bx bx-flag text-secondary me-2"></i>
                                    <span class="fw-medium">{{ __('grievance::grievance.priority') }}:</span>
                                    <span class="{{ getTextColor($grievanceDetail->priority->value) }} fw-bold">
                                        {{ strtoupper(__($grievanceDetail->priority->value)) }}
                                    </span>
                                </div>

                                <div class="col col-12">
                                    <i class="bx bx-category text-secondary me-2"></i>
                                    <span class="fw-medium">{{ __('grievance::grievance.grievance_type') }}:</span>
                                    <span>{{ $grievanceDetail->grievanceType->title }}</span>
                                </div>

                                <br>
                                <div class="col col-12">
                                    <i class="bx bx-building text-secondary me-2"></i>
                                    <span class="fw-medium">{{ __('grievance::grievance.branch') }}:</span>
                                    @foreach ($branchTitles as $branchTitle)
                                        <span class="text-primary">{{ $branchTitle }} ||</span>
                                    @endforeach
                                </div>

                                <br>

                                @if ($grievanceDetail->customer)
                                    <div class="col-md-4 col-12">
                                        <i class="bx bx-user text-secondary me-2"></i>
                                        <span class="fw-medium">{{ __('grievance::grievance.name') }}:</span>
                                        <span class="text-dark">{{ $grievanceDetail->customer->name }}</span>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <i class="bx bx-envelope text-secondary me-2"></i>
                                        <span class="fw-medium">{{ __('grievance::grievance.email') }}:</span>
                                        <a href="mailto:{{ $grievanceDetail->customer->email }}"
                                            class="text-decoration-underline text-dark">
                                            {{ $grievanceDetail->customer->email }}
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <i class="bx bx-phone text-secondary me-2"></i>
                                        <span class="fw-medium">{{ __('grievance::grievance.phone_number') }}:</span>
                                        <a href="tel:{{ $grievanceDetail->customer->mobile_no }}" class="text-dark">
                                            {{ $grievanceDetail->customer->mobile_no }}
                                        </a>
                                    </div>
                                @endif

                                <div class="col-md-4 col-12 text-primary">
                                    <livewire:grievance.grievance_detail_change_visibility_status_form :$grievanceDetail
                                        :action="\App\Enums\Action::UPDATE" />
                                </div>
                                @if (empty($grievanceDetail->records->first()->reg_no))
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.grievance.grievanceDetail.register', ['id' => $grievanceDetail->id]) }}"
                                            class="btn btn-info">
                                            {{ __('grievance::grievance.register_grievance') }}
                                        </a>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.file_records.show', ['id' => $grievanceDetail->records->first()->id]) }}"
                                            class="btn btn-info">
                                            {{ __('grievance::grievance.view_registerd_file') }}
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-grievance-detail"
                                aria-controls="navs-pills-grievance-detail" aria-selected="false">
                                {{ __('grievance::grievance.grievance_detail') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-assign-user" aria-controls="navs-pills-assign-user"
                                aria-selected="false">
                                {{ __('grievance::grievance.assign_user_priority') }}
                            </button>
                        </li>
                        @if ($grievanceDetail->status->value != 'closed')
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-grievance-reply"
                                    aria-controls="navs-pills-grievance-reply" aria-selected="false">
                                    {{ __('grievance::grievance.grievance_reply') }}
                                </button>
                            </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-logs" aria-controls="navs-pills-logs"
                                aria-selected="false">
                                {{ __('grievance::grievance.grievance_logs') }}
                            </button>
                        </li>

                    </ul>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-pills-grievance-detail" role="tabpanel">
                                <div class="col-md-12">
                                    <p class="mb-3">
                                        <strong class="text-dark">{{ __('grievance::grievance.subject') }}:</strong>
                                        <span class="text-muted">{{ $grievanceDetail->subject }}</span>
                                    </p>

                                    <div class="mb-4">
                                        <strong class="text-dark">{{ __('grievance::grievance.descriptions') }}:</strong>
                                        <div class="p-3 rounded shadow-sm"
                                            style="background-color: #f9f9f9; border: 1px solid #e0e0e0;">
                                            <p class="text-muted mb-0">{{ $grievanceDetail->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <div class="card-body border shadow-lg bg-light flex-fill"
                                            style="border-radius: 10px;">
                                            <h5 class="text">{{ __('grievance::grievance.supporting_documents') }}</h5>
                                            <div class="row">
                                                @if (!empty($grievanceDetail->documents))
                                                    @foreach ($grievanceDetail->documents as $fileName)
                                                        @php
                                                            $fileUrl = customFileAsset(
                                                                config('src.Grievance.grievance.path'),
                                                                                    $fileName,
                                                                'local',
                                                                'tempUrl',
                                                                                );
                                                                            @endphp
                                                        <div class="col-auto mb-2">
                                                            <a href="{{ $fileUrl }}" target="_blank"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="bx bx-file"></i>
                                                                {{ __('yojana::yojana.view_uploaded_file') }}
                                                            </a>
                                                            </div>
                                                    @endforeach
                                                @else
                                                    <div class="col-md-12">
                                                        <p class="text-center">
                                                            {{ __('grievance::grievance.no_supporting_document_provided') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="navs-pills-assign-user" role="tabpanel">

                                <livewire:grievance.grievance_detail_change_assigned_user_form :$grievanceDetail
                                    :action="\App\Enums\Action::UPDATE" :$users />

                                <div class="mt-3">
                                    <label for="setprio">{{ __('grievance::grievance.change_grievance_priority') }}</label>
                                    <livewire:grievance.grievance_detail_grievance_priority :$grievanceDetail
                                        :action="\App\Enums\Action::UPDATE" />
                                </div>
                            </div>

                            <div class="tab-pane fade" id="navs-pills-grievance-reply" role="tabpanel">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <livewire:grievance.grievance_detail_change_status_form :$grievanceDetail
                                            :action="\App\Enums\Action::UPDATE" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="navs-pills-logs" role="tabpanel">
                                <div class="col-md-12">

                                    <livewire:grievance.grievance_detail_assign_history_form :$grievanceDetail />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
