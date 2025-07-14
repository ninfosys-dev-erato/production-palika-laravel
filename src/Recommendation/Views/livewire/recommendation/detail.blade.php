<div class="card-body" style="padding: 20px;">
    <ul class="list-unstyled my-3 py-1">
        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-layer" style="font-size: 1.5rem; color: #28a745;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('recommendation::recommendation.title') }}:</span>
            <span style="color: #555;">{{ $recommendation->title ?? __('recommendation::recommendation.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-category" style="font-size: 1.5rem; color: #ffc107;"></i>
            <span class="fw-medium mx-2"
                style="color: #333; font-weight: 500;">{{ __('recommendation::recommendation.recommendation_category') }}:</span>
            <span style="color: #555;">{{ $recommendation->recommendationCategory->title ?? __('recommendation::recommendation.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-file" style="font-size: 1.5rem; color: #007bff;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('recommendation::recommendation.form') }}:</span>
            <span style="color: #555;">{{ $recommendation->form->title ?? __('recommendation::recommendation.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-dollar" style="font-size: 1.5rem; color: #dc3545;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('recommendation::recommendation.revenue') }}:</span>
            <span style="color: #555;">{{ $recommendation->revenue ?? __('recommendation::recommendation.na') }}</span>
        </li>

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-check-circle" style="font-size: 1.5rem; color: #54ae5e;"></i>
            <span class="fw-medium mx-2"
                style="color: #333; font-weight: 500;">{{ __('recommendation::recommendation.is_ward_recommendation') }}?:</span>
            <span style="color: #555;">
                {{ $recommendation->is_ward_recommendation ? __('recommendation::recommendation.yes') : __('recommendation::recommendation.no') }}
            </span>
        </li>

        {{-- <li class="d-flex align-items-center mb-4">
            <i class="bx bx-bell" style="font-size: 1.5rem; color: #8593e4;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('recommendation::recommendation.notify_to') }}:</span>
            <span style="color: #555;">{{ $recommendation->notify_to ?? __('recommendation::recommendation.na') }}</span>
        </li> --}}

        <li class="d-flex align-items-center mb-4">
            <i class="bx bx-user-plus" style="font-size: 1.5rem; color: #007bff;"></i>
            <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('recommendation::recommendation.created_by') }}:</span>
            <span style="color: #555;">{{ $recommendation->createdBy->name ?? __('recommendation::recommendation.na') }}</span>
        </li>

    </ul>
</div>