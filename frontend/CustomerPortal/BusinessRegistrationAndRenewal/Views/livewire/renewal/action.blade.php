<div>

    @if ($businessRenewal->application_status === Src\BusinessRegistration\Enums\ApplicationStatusEnum::PENDING)
        <div class="alert alert-warning text-center p-3">
            <strong>{{ __('Your request is under review!') }}</strong><br>
            {{ __('Please wait for admin approval before uploading the payment receipt.') }}
        </div>
    @endif

    @if ($showBillUpload)
        <div class="col-md-12 mb-2">
            <form wire:submit.prevent="uploadBill">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <h5 class="text-dark">
                                <strong>{{ __('Amount to be Paid') }} :</strong>
                                <span class="text-success fw-bold">
                                    {{ __('NRS ') }}{{ number_format($businessRenewal->renew_amount + ($businessRenewal->penalty_amount ?? 0), 2) }}
                                </span>
                            </h5>
                        </div>
                        <div class="form-group">
                            <label for="payment_receipt">{{ __('Upload Payment Photo') }}</label>
                            <input wire:model="payment_receipt" name="payment_receipt" type="file"
                                class="form-control" accept="image/*">
                            @error('payment_receipt')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @if ($payment_receipt)
                                <img src="{{ method_exists($payment_receipt, 'temporaryUrl') ? $payment_receipt->temporaryUrl() : $payment_receipt }}"
                                    alt="Uploaded Image Preview" class="img-thumbnail mt-2" style="height: 300px;"
                                    onerror="this.style.display='none';">
                            @endif
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary mt-2" type="submit" wire:loading.attr="disabled"
                    wire:click="uploadBill">{{ __('Upload') }}</button>
            </form>
        </div>
    @endif


    @if (!empty($businessRenewal->payment_receipt))
        <div class="col-md-12 mt-3">
            <label for="existing-bill">{{ __('Uploaded Payment Photo') }}</label>
            <img src="{{ customFileAsset(config('src.BusinessRegistration.businessRegistration.bill'), $businessRenewal->payment_receipt, 'local', 'tempUrl') }}"
                alt="Uploaded Bill Image" class="img-thumbnail mt-2 clickable" style="height: 300px; cursor: pointer;"
                data-bs-toggle="modal" data-bs-target="#billModal">
        </div>

        <div class="modal fade" id="billModal" tabindex="-1" aria-labelledby="billModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="billModalLabel">{{ __('Uploaded Bill Image') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ customFileAsset(config('src.BusinessRegistration.businessRegistration.bill'), $businessRenewal->payment_receipt, 'local', 'tempUrl') }}"
                            alt="Full-size Uploaded Bill" class="img-fluid" style="max-height: 90vh;">
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="modal fade" id="sendForPaymentModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Payable renew amount') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="renew_amount" class="form-label">{{ __('Renew Amount') }}</label>
                        <input type="text" id="renew_amount" class="form-control" wire:model="renew_amount">
                        @error('renew_amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="penalty_amount" class="form-label">{{ __('Penalty Amount') }}</label>
                        <input type="text" id="penalty_amount" class="form-control" wire:model="penalty_amount">
                        @error('penalty_amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="sendForPayment">{{ __('Send For Payment') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveRenewalForm" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Approve Renewal Form') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class='form-group' wire:ignore>
                            <label for='bill_no' class="form-label">{{ __('Bill No') }}</label>
                            <input wire:model='bill_no' name='bill_no' type='text' class='form-control'
                                placeholder="{{ __('Bill NO') }}" id="bill_no">
                        </div>
                        @error('bill_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <div class='form-group' wire:ignore>
                            <label for='payment_receipt_date' class="form-label">{{ __('Payment Date') }}</label>
                            <input wire:model='payment_receipt_date' name='payment_receipt_date' type='text'
                                class='form-control' placeholder="{{ __('Payment Date') }}"
                                id="payment_receipt_date">
                        </div>
                        @error('payment_receipt_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <div class='form-group' wire:ignore>
                            <label for='date_to_be_maintained'
                                class="form-label">{{ __('Date To Be Maintained') }}</label>
                            <input wire:model='date_to_be_maintained' name='date_to_be_maintained' type='text'
                                class='form-control' placeholder="{{ __('Date To Be Maintained') }}"
                                id="date_to_be_maintained">
                        </div>
                        @error('date_to_be_maintained')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="approveRenewal">{{ __('Approve renewal request') }}</button>
                </div>
            </div>
        </div>
    </div>

</div>

@script
    <script>
        const paymentReceipt = $('#payment_receipt_date');
        const dateToBeMaintained = $('#date_to_be_maintained');

        paymentReceipt.nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        });

        dateToBeMaintained.nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        })

        paymentReceipt.on('dateSelect', function(e) {
            let paymentReceiptDate = $(this).val();
            @this.set('payment_receipt_date', paymentReceiptDate);
        })

        dateToBeMaintained.on('dateSelect', function(e) {
            let selectedDate = $(this).val();
            @this.set('date_to_be_maintained', selectedDate);
        })

        $wire.on('showPaymentModal', () => {
            $('#sendForPaymentModal').modal('show');
        })

        $wire.on('approveRenewal', () => {
            $('#approveRenewalForm').modal('show');
        })
    </script>
@endscript
