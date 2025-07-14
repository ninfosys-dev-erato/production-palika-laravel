<div class="form">

    <form wire:submit.prevent="save">
        <div class="row">

            <div class="col-md-10 mb-3" wire:ignore>
                @if ($admin)
                    @if ($action === App\Enums\Action::CREATE)
                        <label for="customer_id">{{ __('grievance::grievance.customer') }}</label>
                        <select dusk="grievance-customer_id-field" id="customer_id" name="customer_id" wire:model.defer="customer_id" class="form-control"
                            wire:change="updatedCustomerId($event.target.value)"
                            placeholder="{{ __('grievance::grievance.choose_customer') }}">
                            <option value="">{{ __('grievance::grievance.choose_customer') }}</option>
                        </select>
                    @endif
                @endif
            </div>

            <div class="col-md-2 mb-3">
                <button type="button" class="form-control" style="margin-top: 20px; "
                    wire:click="openCustomerKycModal">
                    + {{__('grievance::grievance.add_customer')}}</button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <x-form.checkbox-input label="{{ __('grievance::grievance.is_anonymous') }}" id="is_anonymous" name="is_anonymous"
                    :options="['is_anonymous' => __('grievance::grievance.is_anonymous')]" />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <x-form.text-input label="{{ __('grievance::grievance.subject') }}" id="subject" name="subject" />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <x-form.textarea-input label="{{ __('grievance::grievance.description') }}" id="description" name="description" />
            </div>
        </div>

        <div class="row mb-3" wire:ignore>
            <label class="form-label" type="departments">{{ __('grievance::grievance.select_a_department') }}</label>
            <x-form.select :options="$branches" multiple name="selectedDepartments" wireModel="selectedDepartments"
                placeholder="Select Department" />
        </div>

        <div class="row mb-3">
            <div class="col-12" wire:ignore>
                <x-form.select-input label="{{ __('grievance::grievance.grievance_type') }}" id="grievance_type_id" name="grievance_type_id"
                    placeholder="{{ __('grievance::grievance.choose_grievance_type') }}" :options="$types" required />
            </div>
        </div>

        <div class="mb-3">
            <div class='form-group'>
                <label class="form-label" for='image'>{{ __('grievance::grievance.image') }}</label>
                <input dusk="grievance-uploadedImage-field" wire:model="uploadedImage" name='uploadedImage' type='file' class='form-control' multiple
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <div>
                    @error('uploadedImage')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
                @if ($uploadedImage)
                    <div class="row">
                        @foreach ($uploadedImage as $image)
                            <div class="col-md-3 col-sm-4 col-6 mb-3">
                                <img src="{{ $image->temporaryUrl() }}" alt="Uploaded Image Preview"
                                    class="img-thumbnail w-100 " style="height: 150px; object-fit: cover;" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row">
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary"
                    wire:loading.attr="disabled">{{ __('grievance::grievance.save') }}</button>
            </div>
        </div>
    </form>
    @if ($showCustomerKycModal)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('grievance::grievance.create_customer') }}</h5>
                        <button type="button" wire:click="closeCustomerKycModal"
                            class="btn btn-light d-flex justify-content-center align-items-center shadow-sm"
                            style="width: 40px; height: 40px; border: none; background-color: transparent;">
                            <span style="color: red; font-size: 20px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <livewire:customers.customer_form :$action :$isModalForm :isForGrievance=true />
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let customerSelect = $('#customer_id');

            customerSelect.select2({
                ajax: {
                    url: function(params) {
                        let client_href = '{{ route('customers.search') }}';
                        let query = [];
                        if (params.term) {
                            if (/^\d+$/.test(params.term)) {
                                query.push('filter[mobile_no]=' + params.term);
                            } else {
                                query.push('filter[name]=' + params.term);
                            }
                        }
                        if (query.length > 0) {
                            client_href += '?' + query.join('&');
                        }
                        return client_href;
                    },
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data.data.map(customer => ({
                                id: customer.id,
                                text: `${customer.mobile_no} (${customer.name})`
                            }))
                        };
                    }
                }
            });

            customerSelect.on('change', function() {
                let selectedValue = $(this).val();
                @this.set('customer_id', selectedValue);
            });

            Livewire.hook('message.processed', () => {
                let existingCustomerId = @this.get('customer_id');
                customerSelect.val(existingCustomerId).trigger('change');
            });
        });
    </script>
@endpush


@script
    <script>
        $(document).ready(function() {

            const grievanceSelect = $('#grievance_type_id');
            grievanceSelect.select2();

            grievanceSelect.on('change', function() {
                @this.set('grievance_type_id', $(this).val());
            })
        })
    </script>
@endscript
