<div>
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-primary fw-bold mb-1">
                    <i class="bx bx-time-five me-2"></i>{{ __('ebps::ebps.pending_change_requests') }}
                </h2>
                <p class="text-muted mb-0">{{ __('ebps::ebps.review_and_manage_pending_change_requests') }}</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning text-white rounded-circle p-2 me-3">
                                <i class="bx bx-time fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">{{ count($items) }}</h6>
                                <small class="text-muted">{{ __('ebps::ebps.total_pending') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-info text-white rounded-circle p-2 me-3">
                                <i class="bx bx-user fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">{{ collect($items)->where('type', 'user')->count() }}</h6>
                                <small class="text-muted">{{ __('ebps::ebps.user_changes') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle p-2 me-3">
                                <i class="bx bx-building fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">{{ collect($items)->where('type', 'organization')->count() }}
                                </h6>
                                <small class="text-muted">{{ __('ebps::ebps.organization_changes') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Main Table Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-semibold mb-0">
                        <i class="bx bx-list-ul me-2"></i>{{__('ebps::ebps.change_requests_list')}}
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark">{{ count($items) }} items</span>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                @if (count($items) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">
                                        <i class="bx bx-category me-1"></i>{{ __('ebps::ebps.type') }}
                                    </th>
                                    <th class="border-0 fw-semibold">
                                        <i class="bx bx-user me-1"></i>{{ __('ebps::ebps.name') }}
                                    </th>
                                    <th class="border-0 fw-semibold">
                                        <i class="bx bx-phone me-1"></i>{{ __('ebps::ebps.contact') }}
                                    </th>
                                    <th class="border-0 fw-semibold">
                                        <i class="bx bx-check-circle me-1"></i>{{ __('ebps::ebps.status') }}
                                    </th>
                                    <th class="border-0 fw-semibold">
                                        <i class="bx bx-message-detail me-1"></i>{{ __('ebps::ebps.reason') }}
                                    </th>
                                    <th class="border-0 fw-semibold">
                                        <i class="bx bx-calendar me-1"></i>{{ __('ebps::ebps.created_at') }}
                                    </th>
                                    <th class="border-0 fw-semibold text-center">{{ __('ebps::ebps.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $index => $item)
                                    <tr class="border-bottom">
                                        <td class="py-3">
                                            @php
                                                $typeConfig = [
                                                    'user' => ['icon' => 'bx-user', 'color' => 'primary'],
                                                    'organization' => ['icon' => 'bx-building', 'color' => 'success'],
                                                    'system' => ['icon' => 'bx-cog', 'color' => 'info'],
                                                    'default' => ['icon' => 'bx-help-circle', 'color' => 'secondary'],
                                                ];
                                                $config = $typeConfig[$item['type']] ?? $typeConfig['default'];
                                            @endphp
                                            <span
                                                class="badge bg-{{ $config['color'] }} bg-opacity-10 text-{{ $config['color'] }} px-3 py-2">
                                                <i class="bx {{ $config['icon'] }} me-1"></i>
                                                {{ ucfirst($item['type']) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-2 me-2">
                                                    <i class="bx bx-user text-muted"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $item['name'] }}</div>

                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-phone text-muted me-2"></i>
                                                <span>{{ $item['contact'] }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            @php
                                                $statusConfig = [
                                                    'pending' => ['color' => 'warning', 'icon' => 'bx-time'],
                                                    'approved' => ['color' => 'success', 'icon' => 'bx-check'],
                                                    'rejected' => ['color' => 'danger', 'icon' => 'bx-x'],
                                                    'processing' => ['color' => 'info', 'icon' => 'bx-loader-circle'],
                                                    'default' => ['color' => 'secondary', 'icon' => 'bx-help-circle'],
                                                ];
                                                $statusStyle =
                                                    $statusConfig[strtolower($item['status'])] ??
                                                    $statusConfig['default'];
                                            @endphp
                                            <span class="badge bg-{{ $statusStyle['color'] }} rounded-pill px-3 py-2">
                                                <i class="bx {{ $statusStyle['icon'] }} me-1"></i>
                                                {{ ucfirst($item['status']) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="text-truncate" style="max-width: 200px;"
                                                title="{{ $item['reason'] }}">
                                                {{ $item['reason'] }}
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-calendar text-muted me-2"></i>
                                                <div>
                                                    <div class="fw-medium">
                                                        {{ \Carbon\Carbon::parse($item['created_at'])->format('M d, Y') }}
                                                    </div>
                                                    <small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($item['created_at'])->format('H:i') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 text-center">
                                            <div class="btn-group">

                                                @if ($item['type'] === 'Organization')
                                                    <a href="{{ route('admin.ebps.show-organization-template', ['organizationId' => $item['organization_id'], 'mapApplyId' => $item['map_apply_id']]) }}"
                                                        class="btn btn-sm btn-outline-primary" title="View Details"
                                                        target="_blank" rel="noopener noreferrer">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.ebps.show-template', ['houseOwnerId' => $item['id']]) }}"
                                                        class="btn btn-sm btn-outline-primary" title="View Details"
                                                        target="_blank" rel="noopener noreferrer">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                @endif


                                                <button
                                                    wire:click="approveRequest('{{ $item['type'] }}', {{ $item['id'] }})"
                                                    wire:loading.attr="disabled" class="btn btn-sm btn-success">
                                                    <i class="bx bx-check me-1"></i>Approve
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bx bx-inbox text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="text-muted">{{ __('ebps::ebps.no_pending_changes_found') }}</h4>
                        <p class="text-muted mb-4">
                            {{ __('ebps::ebps.there_are_currently_no_pending_change_requests_to_review') }}</p>

                    </div>
                @endif
            </div>

            @if (count($items) > 0)
                <div class="card-footer bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Showing {{ count($items) }} of {{ count($items) }} entries
                        </small>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .table> :not(caption)>*>* {
            padding: 0.75rem 1rem;
            border-bottom-width: 1px;
        }

        .table-hover>tbody>tr:hover>* {
            background-color: rgba(var(--bs-primary-rgb), 0.05);
        }

        .btn-group .btn {
            border-radius: 0.375rem;
            margin: 0 1px;
        }

        .badge {
            font-weight: 500;
            font-size: 0.75rem;
        }

        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .bg-opacity-10 {
            --bs-bg-opacity: 0.1;
        }
    </style>

</div>
