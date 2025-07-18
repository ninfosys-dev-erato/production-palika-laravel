<form>
    {{-- <livewire:nid-validation-form /> --}}
    <div class="form-group">
        <label for="kyc_status">{{ __('KYC Status') }}</label>
        <select id="kyc_status" wire:model="customerKyc.status" name="customerKyc.status" class="form-control"
            wire:model="customerKyc.status" onchange="Livewire.emit('setKycStatus', this.value)">
            <option value="" disabled selected>{{ __('Choose KYC Status') }}</option>
            @foreach (\Src\Customers\Enums\KycStatusEnum::cases() as $status)
                <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>

    @if ($customerKyc && $customerKyc->status->value === 'rejected')
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card-body border shadow-lg bg-light flex-fill" style="border-radius: 2px;">
                    <div class="mb-3">
                        <p>{{ __('Select reasons for rejection') }}</p>
                        @foreach ([__('Missing Documents'), __('Invalid Information'), __('Inconsistent Details'), __('Expired Document'), __('Unverified Identity')] as $reason)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $reason }}"
                                    id="reason{{ $loop->index + 1 }}" wire:model.defer="reason_to_reject">
                                <label class="form-check-label"
                                    for="reason{{ $loop->index + 1 }}">{{ $reason }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-3">
        <button type="button" wire:confirm='Are you sure you want to change the kyc status?' wire:click="save"
            class="btn btn-primary">Save</button>
    </div>
</form>

@script
    <script>
        $wire.on('language-change', () => {
            window.location.reload();
        });
    </script>
@endscript
