<div class="card-body" style="padding: 20px;">
    <h5 class="text-primary fw-bold mb-0">{{ __('users::users.user_details') }}</h5>
    <ul class="list-unstyled my-3 py-1">

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-user" style="font-size: 1.5rem; color: #28a745;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('users::users.name') }}:</span>
            <span style="color: #555;">{{ $user->name ?? __('users::users.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-envelope" style="font-size: 1.5rem; color: #ffc107;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('users::users.email') }}:</span>
            <span style="color: #555;">{{ $user->email ?? __('users::users.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-phone" style="font-size: 1.5rem; color: #007bff;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('users::users.phone_number') }}:</span>
            <span style="color: #555;">{{ $user->mobile_no ?? __('users::users.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-map" style="font-size: 1.5rem; color: #dc3545;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('users::users.local_body') }}:</span>
            <span style="color: #555;">{{ $user->userWards->first()?->localBody?->title ?? __('users::users.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-pin" style="font-size: 1.5rem; color: #6c757d;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('users::users.assigned_wards') }}:</span>
            <span style="color: #555;">
                @forelse ($user->userWards as $userWard)
                    {{ $userWard->ward }}
                    @if (!$loop->last)
                        ,
                    @endif
                @empty
                    {{ __('users::users.no_wards_assigned') }}
                @endforelse
            </span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-sitemap" style="font-size: 1.5rem; color: #8593e4;"></i>
            <span class="fw-medium mx-2"
                style="color: #333; font-weight: 500;">{{ __('users::users.assigned_departments') }}:</span>
            <span style="color: #555;">
                @forelse ($user->departments as $department)
                    {{ $department->title }}
                    @if ($department->pivot->is_department_head)
                        <span class="badge bg-success mx-1">{{ __('users::users.head') }}</span>
                    @endif
                    @if (!$loop->last)
                        ,
                    @endif
                @empty
                    {{ __('users::users.no_departments_assigned') }}
                @endforelse
            </span>
        </li>
    </ul>
</div>
