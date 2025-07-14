<div class="card-body" style="padding: 20px;">
    <ul class="list-unstyled my-3 py-1">
        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-layer" style="font-size: 1.5rem; color: #28a745;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('grievance::grievance.title') }}:</span>
            <span style="color: #555;">{{ $grievanceType->title ?? __('grievance::grievance.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-time" style="font-size: 1.5rem; color: #ffc107;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('grievance::grievance.created_at') }}:</span>
            <span
                style="color: #555;">{{ $grievanceType->created_at ? $grievanceType->created_at->format('d-m-Y H:i:s') : __('grievance::grievance.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-user" style="font-size: 1.5rem; color: #007bff;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('grievance::grievance.deleted_at') }}:</span>
            <span
                style="color: #555;">{{ $grievanceType->deleted_at ? $grievanceType->deleted_at->format('d-m-Y H:i:s') : __('grievance::grievance.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-group" style="font-size: 1.5rem; color: #dc3545;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('grievance::grievance.associated_notifee') }}:</span>
            <span style="color: #555;">
                @if ($grievanceType->roles && $grievanceType->roles->isNotEmpty())
                    {{ $grievanceType->roles->map(function ($role) {
                            return ucwords(str_replace('_', ' ', $role->name));
                        })->join(', ') }}
                @else
                    {{ __('grievance::grievance.no_notifee_associated') }}
                @endif
            </span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-buildings" style="font-size: 1.5rem; color: #6c757d;"></i>
            <span class="fw-medium mx-2"
                style="color: #333; font-weight: 500;">{{ __('grievance::grievance.associated_departments') }}:</span>
            <span style="color: #555;">
                @if ($grievanceType->departments && $grievanceType->departments->isNotEmpty())
                    {{ $grievanceType->departments->pluck('title')->join(', ') }}
                @else
                    {{ __('grievance::grievance.no_departments_associated') }}
                @endif
            </span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-file" style="font-size: 1.5rem; color: #8593e4;"></i>
            <span class="fw-medium mx-2"
                style="color: #333; font-weight: 500;">{{ __('grievance::grievance.grievance_details_count') }}:</span>
            <span style="color: #555;">{{ $grievanceType->grievanceDetails->count() ?? 0 }}</span>
        </li>
    </ul>
</div>
