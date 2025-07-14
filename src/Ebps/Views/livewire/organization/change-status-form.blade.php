<form>
    <div class="form-group">
        <label class="form-label" for="kyc_status">{{ __('ebps::ebps.status') }}</label>
        <select id="kyc_status" wire:model="organization.status" name="organization.status" class="form-control"
            wire:model="organization.status" wire:change="setStatus"
            wire:confirm='Are you sure you want to change the status?'>
            <option value="" disabled selected>{{ __('ebps::ebps.choose_status') }}</option>
            @foreach (\Src\Ebps\Enums\OrganizationStatusEnum::cases() as $status)
                <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>

    @if ($rejectModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('ebps::ebps.rejection_reason') }}</h5>
                        <button type="button" class="close" wire:click="$set('rejectModal', false)">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label>{{ __('ebps::ebps.reason_for_rejection') }}</label>
                        <textarea class="form-control" wire:model.defer="reason_to_reject"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('rejectModal', false)">{{ __('ebps::ebps.cancel') }}</button>
                        <button type="button" class="btn btn-primary" wire:click="save">{{ __('ebps::ebps.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</form>
