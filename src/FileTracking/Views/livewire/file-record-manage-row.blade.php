<tr class="table-active cursor-pointer" wire:click="goToFileRecord({{ $fileRecord->id }})">
    <td>
        <div class="checkbox-container">
            <input class="form-check-input" type="checkbox" value="">
            <div class="form-check-custom">
                <input class="custom-checkbox" type="checkbox" id="customCheckbox{{ $fileRecord->id }}">
                <label class="custom-checkbox-label" wire:click.prevent="toggleFavourite({{ $fileRecord }})"
                    onclick="event.stopPropagation()" for="customCheckbox{{ $fileRecord->id }}">
                    <i
                        class="bx bx-star bx-sm {{ optional($fileRecord->seenFavourites)->is_favourite ? 'text-warning' : 'text-muted' }}"></i>
                </label>
            </div>
        </div>
    </td>
    <td>
        <div class="d-flex align-items-center gap-2">
            <img src="{{ Avatar::create($fileRecord->applicant_name ?? 'Unknown')->toBase64() }}"
                class="rounded-circle img-thumbnail avatar-sm" alt="User Avatar">

            <span>{{ $fileRecord->applicant_name }} |{{ $fileRecord->applicant_mobile_no }}</span>
        </div>
    </td>
    <td>
        @if (!empty($fileRecord->reg_no))
            <strong>#{{ $fileRecord->reg_no }}</strong>|
        @endif
        <span>{{ $fileRecord->title }}</span>
    </td>
    <td>
        <span class="badge bg-label-primary me-1">{{ $fileRecord->created_at->diffForHumans() }}</span>
    </td>
</tr>
