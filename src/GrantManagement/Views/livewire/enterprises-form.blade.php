<div>


    <form wire:submit.prevent="save">
        <div class="card-body">
            <div class="row">

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='enterprise_type_id'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.enterprise_type') }}</label>
                        <select wire:model='enterprise.enterprise_type_id' name='enterprise_type_id' class='form-control'>
                            <option value=''>{{ __('grantmanagement::grantmanagement.enterprise_type') }}</option>
                            @foreach ($enterpriseses as $id => $type)
                                <option value="{{ $id }}">{{ $type }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('enterprise.enterprise_type_id')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='name'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.enterprise_name') }}</label>
                        <input wire:model='enterprise.name' name='name' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enterprise_name') }}">
                        <div>
                            @error('enterprise.name')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='vat_pan'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.vat_pan') }}</label>
                        <input wire:model='enterprise.vat_pan' name='vat_pan' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_vat_pan') }}">
                        <div>
                            @error('enterprise.vat_pan')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>




                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text ">{{ __('grantmanagement::grantmanagement.local_address') }}</div>
                </div>

                <div class="col-md-6 mb-4">
                    <label class='form-label'
                        for="province_id">{{ __('grantmanagement::grantmanagement.province') }}</label>
                    <select id="province_id" name="enterprise.province_id" class="form-control"
                        wire:model="enterprise.province_id" wire:change="getDistricts">
                        <option value="">{{ __('grantmanagement::grantmanagement.select_province') }}</option>
                        @foreach ($provinces as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>

                    @error('enterprise.province_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label class='form-label'
                        for="district_id">{{ __('grantmanagement::grantmanagement.district') }}</label>
                    <select id="district_id" name="enterprise.district_id" class="form-control"
                        wire:model="enterprise.district_id" wire:change="getLocalBodies">
                        <option value="">{{ __('grantmanagement::grantmanagement.select_district') }}</option>
                        @foreach ($districts as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>

                    @error('enterprise.district_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label class='form-label'
                        for="local_body_id">{{ __('grantmanagement::grantmanagement.local_body') }}</label>
                    <select id="local_body_id" name="enterprise.local_body_id" class="form-control"
                        wire:model="enterprise.local_body_id" wire:change="getWards">

                        <option value="">{{ __('grantmanagement::grantmanagement.select_local_body') }}</option>

                        @foreach ($localBodies as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach

                    </select>

                    @error('enterprise.local_body_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>


                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='ward_no'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.ward') }}</label>
                        <select wire:model='enterprise.ward_no' name='ward_no' class='form-control'>
                            <option value="">{{ __('grantmanagement::grantmanagement.select_ward') }}</option>
                            @foreach ($wards as $id => $display_name)
                                <option value="{{ $id }}">{{ $display_name }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('enterprise.ward_no')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='village'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.village') }}</label>
                        <input wire:model='enterprise.village' name='village' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_village') }}">
                        <div>
                            @error('enterprise.village')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='tole'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.tole') }}</label>
                        <input wire:model='enterprise.tole' name='tole' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_tole') }}">
                        <div>
                            @error('enterprise.tole')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                @if ($showSelectedFarmerModal)
                    <div class="divider divider-primary text-start text-primary font-14">
                        <div class="divider-text ">{{ __('grantmanagement::grantmanagement.farmer_involved') }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group" wire:ignore>
                            <label class='form-label'
                                for="farmer_ids">{{ __('grantmanagement::grantmanagement.farmers') }}</label>

                            <div class="d-flex align-items-center gap-1">

                                <x-form.select :options="$farmers" multiple name="selectedFarmers"
                                    wireModel="selectedFarmers" placeholder="Select Farmers"
                                    class="form-group flex-grow-1" required />
                                <button type="button" class="btn btn-sm btn-outline-primary p-1 m-0"
                                    onclick="resetForm()" data-bs-toggle="modal" data-bs-target="#indexModal">
                                    <i class='bx bx-plus-medical fs-5'></i>
                                </button>
                            </div>
                        </div>
                        @error('group_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif


            </div>
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary"
                wire:loading.attr="disabled">{{ __('grantmanagement::grantmanagement.save') }}</button>
            <a href="{{ route('admin.enterprises.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('grantmanagement::grantmanagement.back') }}</a>
        </div>
    </form>

    @if ($showSelectedFarmerModal)
        <!-- FARMER INVOLVEMENT MODAL -->
        <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="farmerLabel" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="farmerLabel">
                            {{ __('grantmanagement::grantmanagement.create_farmer') }}
                        </h5>
                        <button type="button" class="btn-close" onclick="resetForm()" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <livewire:grant_management.farmer_form :showSelectedFarmerModal="false" :action="App\Enums\Action::CREATE" />
                    </div>
                </div>
            </div>
        </div>
    @endif


</div>
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', () => {
            $('#indexModal').modal('hide');
            $('.modal-backdrop').remove();
        });

    });
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('indexModal'));
            modal.show();
        });
    });

    function resetForm() {
        Livewire.dispatch('reset-form');
    }

    $('#indexModal').on('hidden.bs.modal', function() {
        $('body').removeClass('modal-open').css({
            'overflow': '',
            'padding-right': ''
        });
    });
</script>
