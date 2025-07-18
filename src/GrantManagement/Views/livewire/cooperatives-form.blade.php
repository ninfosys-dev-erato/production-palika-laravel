<div>


    <form wire:submit.prevent="save">
        <div class="card-body">
            <div class="row">
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='name'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.name_of_the_cooperative') }}</label>
                        <input wire:model='cooperative.name' name='name' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.name_of_the_cooperative') }}">
                        <div>
                            @error('cooperative.name')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mb-4">
                    <label class='form-label'
                        for="cooperative_type_id">{{ __('grantmanagement::grantmanagement.cooperative_type') }}</label>
                    <select id="cooperative_type_id" name="cooperative.cooperative_type_id" class="form-control"
                        wire:model="cooperative.cooperative_type_id">
                        <option value="">{{ __('grantmanagement::grantmanagement.select_cooperative_type') }}
                        </option>
                        @foreach ($cooperative_types as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>

                    @error('cooperative.cooperative_type_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label class='form-label'
                        for="affiliation_id">{{ __('grantmanagement::grantmanagement.affiliation') }}</label>
                    <select id="affiliation_id" name="cooperative.cooperative_type_id" class="form-control"
                        wire:model="cooperative.affiliation_id">
                        <option value="">{{ __('grantmanagement::grantmanagement.select_an_option') }}</option>
                        @foreach ($affiliations as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>

                    @error('cooperative.affiliation_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>



                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='registration_no'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.registration_no') }}</label>
                        <input wire:model='cooperative.registration_no' name='registration_no' type='text'
                            class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.registration_no') }}">
                        <div>
                            @error('cooperative.registration_no')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for="registration_date"
                            class='form-label'>{{ __('grantmanagement::grantmanagement.registration_date') }}</label>
                        <input type="text" name="registration_date" id="registration_date"
                            class="form-control {{ $errors->has('registration_date') ? 'is-invalid' : '' }} nepali-date"
                            wire:model="cooperative.registration_date"
                            style="{{ $errors->has('registration_date') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            placeholder="{{ __('grantmanagement::grantmanagement.select_date') }}" />

                        @error('cooperative.registration_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='vat_pan'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.sheetvat') }}</label>
                        <input wire:model='cooperative.vat_pan' name='vat_pan' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.sheetvat') }}">
                        <div>
                            @error('cooperative.vat_pan')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>



                <div class='col-md-12'>
                    <div class='form-group'>
                        <label for='objective'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.objective') }}</label>
                        <textarea wire:model='cooperative.objective' name='objective' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_objective') }}"> </textarea>
                        <div>
                            @error('cooperative.objective')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text ">{{ __('grantmanagement::grantmanagement.permanent_address') }}</div>
                </div>

                <div class="col-md-6 mb-4">
                    <label class='form-label'
                        for="province_id">{{ __('grantmanagement::grantmanagement.province') }}</label>
                    <select id="province_id" name="cooperative.province_id" class="form-control"
                        wire:model="cooperative.province_id" wire:change="getDistricts">
                        <option value="">{{ __('grantmanagement::grantmanagement.select_province') }}</option>
                        @foreach ($provinces as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>

                    @error('cooperative.province_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label class='form-label'
                        for="district_id">{{ __('grantmanagement::grantmanagement.district') }}</label>
                    <select id="district_id" name="cooperative.district_id" class="form-control"
                        wire:model="cooperative.district_id" wire:change="getLocalBodies">
                        <option value="">{{ __('grantmanagement::grantmanagement.select_district') }}</option>
                        @foreach ($districts as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>

                    @error('cooperative.district_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label class='form-label'
                        for="local_body_id">{{ __('grantmanagement::grantmanagement.local_body') }}</label>
                    <select id="local_body_id" name="cooperative.local_body_id" class="form-control"
                        wire:model="cooperative.local_body_id" wire:change="getWards">

                        <option value="">{{ __('grantmanagement::grantmanagement.select_local_body') }}</option>

                        @foreach ($localBodies as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach

                    </select>

                    @error('cooperative.local_body_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>


                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='ward_no'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.ward') }}</label>
                        <select wire:model='cooperative.ward_no' name='ward_no' class='form-control'>
                            <option value="">{{ __('grantmanagement::grantmanagement.select_ward') }}</option>
                            @foreach ($wards as $id => $display_name)
                                <option value="{{ $id }}">{{ $display_name }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('cooperative.ward_no')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='village'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.village') }}</label>
                        <input wire:model='cooperative.village' name='village' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_village') }}">
                        <div>
                            @error('cooperative.village')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='tole'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.tole') }}</label>
                        <input wire:model='cooperative.tole' name='tole' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_tole') }}">
                        <div>
                            @error('cooperative.tole')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>




                @if ($showSelectedFarmerModal)
                    <div class="divider divider-primary text-start text-primary font-14">
                        <div class="divider-text ">{{ __('grantmanagement::grantmanagement.farmers_involved') }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group" wire:ignore>
                            <label class="form-label"
                                type="farmers">{{ __('grantmanagement::grantmanagement.farmer') }}</label>
                            <div class="d-flex align-items-center gap-1">
                                <x-form.select :options="$farmers" multiple name="selectedFarmers"
                                    wireModel="selectedFarmers" placeholder="Select Farmers"
                                    class="form-group flex-grow-1" required />
                                <button type="button" wire:click="openFarmerModal"
                                    class="btn btn-sm btn-outline-primary p-1 m-0" onclick="resetForm()"
                                    data-bs-toggle="modal" data-bs-target="#indexModal">
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
            <a href="{{ route('admin.cooperative.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('grantmanagement::grantmanagement.back') }}</a>
        </div>

    </form>

    @if ($showSelectedFarmerModal)
        <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="planLevelModalLabel"
            aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalLabel">
                            {{ __('grantmanagement::grantmanagement.create_farmer') }}
                        </h5>
                        <button type="button" class="btn-close" onclick="resetForm()" data-bs-dismiss="modal"
                            aria-label="Close">&times;
                        </button>
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
