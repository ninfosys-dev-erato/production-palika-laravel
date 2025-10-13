<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <!-- Model Field -->
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='model' class='form-label'>{{ __('yojana::yojana.implementation_method') }}</label>
                    <select wire:model='implementationAgency.model' name='model' class="form-select" disabled>
                        {{--                        <option value="" hidden>{{ __('yojana::yojana.select_an_option') }}</option> --}}
                        <option value="{{ $this->plan?->implementationMethod?->model }}" selected>
                            {{ $this->plan?->implementationMethod?->model->label() }}</option>
                    </select>
                    <div>
                        @error('implementationAgency.model')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>


            @if ($this->plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByConsumerCommittee)
                <!-- Consumer Committee Field -->
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='consumer_committee_id'
                            class='form-label'>{{ __('yojana::yojana.consumer_committee') }} <span class="text-danger">*</span></label>
                        <select wire:model='implementationAgency.consumer_committee_id' name='consumer_committee_id'
                            class="form-select">
                            <option value="" hidden>{{ __('yojana::yojana.select_an_option') }}</option>
                            @foreach ($consumerCommittees as $id => $value)
                                <option value="{{ $id }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('implementationAgency.consumer_committee_id')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            @if (
                $this->plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByNGO ||
                    $this->plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByContract ||
                    $this->plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByQuotation)
                <!-- Organization Field -->
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='organization_id' class='form-label'>{{ __('yojana::yojana.organization') }}</label>
                        <select wire:model='implementationAgency.organization_id' name='organization_id'
                            class="form-select">
                            <option value="" hidden>{{ __('yojana::yojana.select_an_organization') }}</option>
                            @foreach ($organizations as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('implementationAgency.organization_id')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif


            @if ($this->plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByTrust)
                <!-- Trust Field -->
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='application_id' class='form-label'>{{ __('yojana::yojana.trust_name') }}</label>
                        <select wire:model='implementationAgency.application_id' name='application_id'
                            class="form-select">
                            <option value="" hidden>{{ __('yojana::yojana.select_an_option') }}</option>
                            @foreach ($applications as $id => $applicant_name)
                                <option value="{{ $id }}">{{ $applicant_name }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('implementationAgency.application_id')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Comment Field -->
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='comment' class='form-label'>{{ __('yojana::yojana.comment') }}</label>
                    <input wire:model='implementationAgency.comment' name='comment' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_comment') }}">
                    <div>
                        @error('implementationAgency.comment')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            @if ($this->plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByContract)
                <!-- Contract Fields -->

                <div class="divider divider-primary text-start text-primary mb-2">
                    <div class="divider-text  fw-bold ">
                        {{ __('yojana::yojana.contract_details') }}
                    </div>
                </div>

                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='contract_number'
                            class='form-label'>{{ __('yojana::yojana.contract_number') }}</label>
                        <input wire:model='contractDetails.contract_number' name='contract_number' type='number'
                            class='form-control' placeholder="{{ __('yojana::yojana.enter_comment') }}">
                        <div>
                            @error('contractDetails.contract_number')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='notice_date'
                            class='form-label'>{{ __('yojana::yojana.notice_publication_date') }}</label>
                        <input wire:model='contractDetails.notice_date' name='notice_date' type='date'
                            class='form-control'>
                        <div>
                            @error('contractDetails.notice_date')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='bid_acceptance_date'
                            class='form-label'>{{ __('yojana::yojana.bid_acceptance_date') }}</label>
                        <input wire:model='contractDetails.bid_acceptance_date' name='bid_acceptance_date'
                            type='date' class='form-control'>
                        <div>
                            @error('contractDetails.bid_acceptance_date')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='bid_amount' class='form-label'>{{ __('yojana::yojana.bid_amount') }}</label>
                        <input wire:model='contractDetails.bid_amount' name='bid_amount' type='number'
                            class='form-control'>
                        <div>
                            @error('contractDetails.bid_amount')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='deposit_amount'
                            class='form-label'>{{ __('yojana::yojana.deposit_amount') }}</label>
                        <input wire:model='contractDetails.deposit_amount' name='deposit_amount' type='number'
                            class='form-control'>
                        <div>
                            @error('contractDetails.deposit_amount')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            @if ($this->plan?->implementationMethod?->model == \Src\Yojana\Enums\ImplementationMethods::OperatedByQuotation)
                {{--                <livewire:yojana.implementation_agency_quotation_form/> --}}
                <div class="divider divider-primary text-start text-primary mb-2">
                    <div class="divider-text  fw-bold ">
                        {{ __('yojana::yojana.quotation_details') }}
                    </div>
                </div>
                
                @error('quotations')
                    <div class="alert alert-danger mb-3">
                        <i class="bx bx-error"></i> {{ $message }}
                    </div>
                @enderror
                
                @include('Yojana::livewire.implementation-agencies.quotation-form')
            @endif


            <div class="divider divider-primary text-start text-primary mb-2">
                <div class="divider-text  fw-bold ">
                    {{ __('yojana::yojana.documents') }}
                </div>
            </div>

            <!-- Agreement Application File -->
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='agreement_application'
                        class='form-label'>{{ __('yojana::yojana.agreement_application') }}</label>
                    <input wire:model="agreementApplicationFile" name="agreement_application" type="file"
                        class="form-control" placeholder="{{ __('yojana::yojana.enter_agreement_application') }}">

                    <div wire:loading wire:target="agreementApplicationFile">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>

                    <div>
                        @error('implementationAgency.agreement_application')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Agreement Recommendation Letter File -->
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='agreement_recommendation_letter' class='form-label'>
                        {{ __('yojana::yojana.agreement_recommendation_letter') }}</label>
                    <input wire:model="agreementRecommendationLetterFile" name="agreement_recommendation_letter"
                        type="file" class="form-control"
                        placeholder="{{ __('yojana::yojana.enter_agreement_recommendation_letter') }}">

                    <div wire:loading wire:target="agreementRecommendationLetterFile">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>

                    <div>
                        @error('implementationAgency.agreement_recommendation_letter')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Deposit Voucher File -->
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='deposit_voucher'
                        class='form-label'>{{ __('yojana::yojana.deposit_voucher') }}</label>
                    <input wire:model="depositVoucherFile" name="deposit_voucher" type="file"
                        class="form-control" placeholder="{{ __('yojana::yojana.enter_deposit_voucher') }}">

                    <div wire:loading wire:target="depositVoucherFile">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>

                    <div>
                        @error('implementationAgency.deposit_voucher')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Links for Uploaded Files -->
    <div class="row mt-3">
        @if ($applicationUrl)
            <div class="col-12 mb-3">
                <p class="mb-1"><strong>{{ __('yojana::yojana.application_letter_preview') }}:</strong></p>
                <a href="{{ $applicationUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                </a>
            </div>
        @endif

        @if ($agreementRecommendationLetterUrl)
            <div class="col-12 mb-3">
                <p class="mb-1"><strong>{{ __('yojana::yojana.agreement_recommendation_letter_preview') }}:</strong>
                </p>
                <a href="{{ $agreementRecommendationLetterUrl }}" target="_blank"
                    class="btn btn-outline-primary btn-sm">
                    <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                </a>
            </div>
        @endif

        @if ($depositVoucherUrl)
            <div class="col-12 mb-3">
                <p class="mb-1"><strong>{{ __('yojana::yojana.deposit_voucher_preview') }}:</strong></p>
                <a href="{{ $depositVoucherUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                </a>
            </div>
        @endif
    </div>

    <!-- Form Footer -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <a href="{{ route('admin.implementation_agencies.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('yojana::yojana.back') }}</a>
    </div>
</form>

<!-- <script>
    document.addEventListener("livewire:load", () => {
    function initNepaliDatepicker() {
        $('.nepali-date').nepaliDatePicker({
            ndpYear: true,
            ndpMonth: true,
            container: '#implementationBodyModal' // 👈 bind calendar inside modal
        });
    }

    // Init on page load
    initNepaliDatepicker();

    // Re-init after Livewire updates
    Livewire.hook('message.processed', () => {
        initNepaliDatepicker();
    });
});

</script> -->

<!-- @push('scripts')
<script>
    document.addEventListener('livewire:load', function () {

        function initNepaliDatepicker() {
            // Only select inputs inside this component's modal
            $('#implementationBodyModal .nepali-date').nepaliDatePicker({
                ndpYear: true,
                ndpMonth: true,
                container: '#implementationBodyModal' // keep calendar inside modal
            });
        }

        // Init on first load
        initNepaliDatepicker();

        // Re-init after Livewire updates (like adding/removing quotation rows)
        Livewire.hook('message.processed', (message, component) => {
            // Only run if this component is updated
            if (component.fingerprint.name === 'yojana.implementation-agency-form') {
                initNepaliDatepicker();
            }
        });
    });
</script>
@endpush -->

<script>

function initNepaliDatepicker() {
    $('.nepali-date').each(function(index) {
        const input = $(this);

        // Destroy any existing instance first
        if (input.data('nepaliDatePicker')) {
            input.nepaliDatePicker('destroy');
        }

        input.nepaliDatePicker({
            language: "ne",
            ndpYear: true,
            ndpMonth: true,
            container: '#implementationBodyModal', // modal container
            npdInput: true,
            npdDateFormat: 'YYYY-MM-DD',
            ndpEnglishInput: false,
            unicodeDate: true,
            onChange: function() {
            const id = input.attr('id'); // get the unique input ID
            const el = document.getElementById(id);
            el.dispatchEvent(new Event('input', { bubbles: true }));
        }

        });

        // If the input already has a value, set it
        if (input.val()) {
            input.nepaliDatePicker('setDate', input.val());
            input.trigger('input');
        }
    });
}


    // Initialize when modal is shown
    $('#implementationBodyModal').on('shown.bs.modal', function () {
        initNepaliDatepicker();
    });

   document.addEventListener('livewire:init', () => {
    Livewire.on('reinitialize-date-picker', () => {
        console.log('hereeeeee'); // should fire now
        initNepaliDatepicker();
    });
});
    
    // Re-initialize whenever Livewire updates the table (dynamic rows)
    Livewire.hook('message.processed', (message, component) => {
        // Check if modal is visible before initializing
        if ($('#implementationBodyModal').hasClass('show')) {
            initNepaliDatepicker();
        }
    });
    </script>
    




