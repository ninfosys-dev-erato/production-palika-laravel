<x-layout.app header="{{ __('grantmanagement::grantmanagement.cash_grant_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('grantmanagement::grantmanagement.cash_grant') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('grantmanagement::grantmanagement.show') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('grantmanagement::grantmanagement.cash_grant_list') }}
                        </h5>
                    </div>
                    <div>
                        @perm('gms_activity create')
                            <a href="{{ route('admin.cash_grants.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i>
                                {{ __('grantmanagement::grantmanagement.add_cash_grant') }}</a>
                        @endperm
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-body">
                        <div class="row">

                            {{-- Name --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.name') }}:</strong>
                                {{ !empty($cashGrant['user']) ? $cashGrant['user']->name : __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Ward --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.ward') }}:</strong>
                                {{ !empty($cashGrant['ward']) ? $cashGrant['ward']->ward_name_en : __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Age --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.age') }}:</strong>
                                {{ $cashGrant['age'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Contact --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.contact') }}:</strong>
                                {{ $cashGrant['contact'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Citizenship No --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.citizenship_no') }}:</strong>
                                {{ $cashGrant['citizenship_no'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Father's Name --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.father_name') }}:</strong>
                                {{ $cashGrant['father_name'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Grandfather's Name --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.grandfather_name') }}:</strong>
                                {{ $cashGrant['grandfather_name'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Helplessness Type --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.helplessness_type') }}:</strong>
                                {{ !empty($cashGrant['getHelplessnessType']) ? $cashGrant['getHelplessnessType']->helplessness_type : __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Cash Amount --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.cash_amount') }}:</strong>
                                {{ $cashGrant['cash'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Remark --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.remark') }}:</strong>
                                {{ $cashGrant['remark'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- File --}}
                            <div class="mb-3">
                                @php
                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                    $isImage = false;
                                    $fileUrl = '';

                                    if (!empty($cashGrant->file)) {
                                        $extension = strtolower(pathinfo($cashGrant->file, PATHINFO_EXTENSION));
                                        $isImage = in_array($extension, $imageExtensions);
                                        
                                        // Generate file URL using customFileAsset
                                        $fileUrl = customFileAsset(
                                            config('src.GrantManagement.grant.file'),
                                            $cashGrant->file,
                                            'local',
                                            'tempUrl'
                                        );
                                    }
                                @endphp

                                <strong>{{ __('grantmanagement::grantmanagement.file') }}:</strong>
                                @if (!empty($cashGrant->file))
                                    @if ($isImage)
                                        <img src="{{ $fileUrl }}" class="img-thumbnail" style="height: 300px;" alt="Uploaded File">
                                    @else
                                        <div class="mt-1">
                                            <strong>{{ __('File Preview') }}:</strong>
                                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary btn-sm ms-2">
                                                <i class="bx bx-file"></i> {{ __('View Uploaded File') }}
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-muted">
                                        {{ __('grantmanagement::grantmanagement.no_file_uploaded') }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('admin.cash_grants.index') }}" class="btn btn-danger">Back</a>
                    </div>
                </div>



            </div>
        </div>
    </div>
    </div>
</x-layout.app>
