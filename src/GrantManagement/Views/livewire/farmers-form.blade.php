<div>

    <form wire:submit.prevent="save">
        <div class="card-body">
            <div class="row">

                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text ">{{ __('grantmanagement::grantmanagement.farmerperson_details') }}</div>
                </div>


                {{-- @if ($action->value === 'create') --}}
                <div class='col-md-4 mb-4' wire:ignore>
                    <div class='form-group'>
                        <label for='first_name'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.name') }}</label>
                        <select name="selectUser" id="selectUser" class="form-select form-control select2-component"
                            @if ($action->value === 'update') disabled @endif>
                            @foreach ($customer as $id => $name)
                                <option value="{{ $id }}" @if ($farmer->user_id == $id) selected @endif>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('farmer.user_id')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- @endif --}}

                <div class='col-md-6 mb-4'>
                    <div class="form-group">
                        <label class="form-label"
                            for="image">{{ __('grantmanagement::grantmanagement.photo') }}</label>
                        <input wire:model="uploadedImage" name="uploadedImage" type="file"
                            class="form-control {{ $errors->has('uploadedImage') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('uploadedImage') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            accept="image/*">
                        @error('uploadedImage')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror

                        @if (
                            ($uploadedImage && $uploadedImage instanceof \Illuminate\Http\File) ||
                                $uploadedImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ||
                                $uploadedImage instanceof \Illuminate\Http\UploadedFile)
                            @php
                                $extension = strtolower($uploadedImage->getClientOriginalExtension());
                            @endphp

                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                <img src="{{ $uploadedImage->temporaryUrl() }}" alt="Uploaded Image Preview"
                                    class="img-thumbnail mt-2" style="height: 300px;">
                            @elseif ($extension === 'pdf')
                                <div class="card mt-2" style="max-width: 200px;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ __('grantmanagement::grantmanagement.pdf_file') }}
                                        </h5>
                                        <p class="card-text">{{ $uploadedImage->getClientOriginalName() }}</p>
                                        <a href="{{ $uploadedImage->temporaryUrl() }}" target="_blank"
                                            class="btn btn-primary btn-sm">
                                            {{ __('grantmanagement::grantmanagement.open_pdf') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @elseif($action === App\Enums\Action::UPDATE)
                            @php
                                $extension = strtolower(pathinfo($uploadedImage, PATHINFO_EXTENSION));
                            @endphp

                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                <img src="{{ customAsset(config('src.GrantManagement.grant.photo'), $uploadedImage) }}"
                                    alt="Farmer Photo" class="img-thumbnail mt-2" style="height: 300px;">
                            @elseif ($extension === 'pdf')
                                <div class="card mt-2" style="max-width: 200px;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ __('grantmanagement::grantmanagement.pdf_file') }}
                                        </h5>
                                        <p class="card-text">{{ $uploadedImage }}</p>
                                        <a href="{{ customFileAsset(config('src.GrantManagement.grant.photo'), $uploadedImage, 'local') }}"
                                            target="_blank" class="btn btn-primary btn-sm">
                                            {{ __('grantmanagement::grantmanagement.open_pdf') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>



                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='phone_no'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.contact_no') }}</label>
                        <input wire:model='farmer.phone_no' name='phone_no' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_contact_no') }}">
                        <div>
                            @error('farmer.phone_no')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class="form-group">
                        <label for="gender"
                            class="form-label">{{ __('grantmanagement::grantmanagement.gender') }}</label>
                        <select wire:model="farmer.gender" name="gender" class="form-control">
                            <option value="">{{ __('grantmanagement::grantmanagement.select_gender') }}</option>
                            @foreach ($genders as $genderOption)
                                <option value="{{ $genderOption['value'] }}">{{ __($genderOption['label']) }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('farmer.gender')
                                <small class="text-danger">{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='marital_status'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.marital_status') }}</label>
                        <select wire:model='farmer.marital_status' name='marital_status' class='form-control'>
                            <option value="">{{ __('grantmanagement::grantmanagement.select_marital_status') }}
                            </option>
                            @foreach ($maritalStatuses as $maritalOptions)
                                <option value="{{ $maritalOptions['value'] }}">{{ __($maritalOptions['label']) }}
                                </option>
                            @endforeach
                        </select>
                        <div>
                            @error('farmer.marital_status')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='father_name'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.father_name') }}</label>
                        <input wire:model='farmer.father_name' name='father_name' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_father_name') }}">
                        <div>
                            @error('farmer.father_name')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='grandfather_name'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.grandfather_name__fatherinlaws_name_and_surname') }}</label>
                        <input wire:model='farmer.grandfather_name' name='grandfather_name' type='text'
                            class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_grandfather_name') }}">
                        <div>
                            @error('farmer.grandfather_name')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='citizenship_no'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.citizenship_no') }}</label>
                        <input wire:model='farmer.citizenship_no' name='citizenship_no' type='text'
                            class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_citizenship_no') }}">
                        <div>
                            @error('farmer.citizenship_no')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='farmer_id_card_no'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.farmer_id_card_no') }}</label>
                        <input wire:model='farmer.farmer_id_card_no' name='farmer_id_card_no' type='text'
                            class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_farmer_id_card_no') }}">
                        <div>
                            @error('farmer.farmer_id_card_no')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='national_id_card_no'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.national_id_card_no') }}</label>
                        <input wire:model='farmer.national_id_card_no' name='national_id_card_no' type='text'
                            class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_national_id_card_no') }}">
                        <div>
                            @error('farmer.national_id_card_no')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text ">{{ __('grantmanagement::grantmanagement.permanent_address') }}</div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='province_id'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.province') }}</label>
                        <select wire:change="getDistricts" wire:model="farmer.province_id" name='province_id'
                            class='form-control' wire:key="province_select">
                            <option value="">{{ __(key: 'Select Province') }}</option>
                            @foreach ($provinces as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('farmer.province_id')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='district_id'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.district') }}</label>
                        <select wire:model='farmer.district_id' name='district_id' class='form-control'
                            wire:change="getLocalBodies" wire:key="district_id_{{ $farmer->province_id }}">
                            <option value="">{{ __('grantmanagement::grantmanagement.select_district') }}
                            </option>

                            @foreach ($districts as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('farmer.district_id')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='local_body_id'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.local_body') }}</label>
                        <select wire:model='farmer.local_body_id' name='local_body_id' class='form-control'
                            wire:change="getWards" wire:key="local_body_id_{{ $farmer->district_id }}">
                            <option value="">{{ __('grantmanagement::grantmanagement.select_local_body') }}
                            </option>

                            @foreach ($localBodies as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('farmer.local_body_id')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='ward_no'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.ward_no') }}</label>
                        <select wire:model='farmer.ward_no' name='ward_no' class='form-control'
                            wire:key="local_body_id{{ $farmer->local_body_id }}">
                            <option value="">{{ __('grantmanagement::grantmanagement.select_ward') }}</option>
                            @foreach ($wards as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('farmer.ward_no')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='village'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.village') }}</label>
                        <input wire:model='farmer.village' name='village' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_village') }}">
                        <div>
                            @error('farmer.village')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='tole'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.tole') }}</label>
                        <input wire:model='farmer.tole' name='tole' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_tole') }}">
                        <div>
                            @error('farmer.tole')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                @if ($showSelectedFarmerModal)
                    <div class="divider divider-primary text-start text-primary font-14">
                        <div class="divider-text ">{{ __('grantmanagement::grantmanagement.relationship') }}</div>
                    </div>


                    <div class='col-md-6 mb-4'>
                        <div class='form-group' wire:ignore>
                            <label for='spouse_name'
                                class='form-label'>{{ __('grantmanagement::grantmanagement.name_of_house_owner') }}</label>

                            <select name="selectFarmers" id="selectFarmers" class="form-select select2-component"
                                multiple>
                                @foreach ($farmersArray as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('farmer.spouse_name')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class='col-md-6 mb-4'>
                        <div class='form-group' wire:ignore>
                            <label for='relationship'
                                class='form-label'>{{ __('grantmanagement::grantmanagement.select_relationship') }}</label>

                            <select name="selectRelationship" id="selectRelationship"
                                class="form-select select2-component" multiple wire:ignore>
                                @foreach ($relationshipsArray as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>

                            <div>
                                @error('farmer.relationship')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>




                    <div class="divider divider-primary text-start text-primary font-14">
                        <div class="divider-text ">{{ __('grantmanagement::grantmanagement.involvement') }}</div>
                    </div>



                    <div class='col-md-4 mb-3' wire:ignore>
                        <label class="form-label"
                            type="groups">{{ __('grantmanagement::grantmanagement.select_groups') }}</label>
                        <div class="d-flex align-items-center gap-1">

                            <x-form.select :options="$groups" multiple name="selectedGroups" wireModel="selectedGroups"
                                placeholder="Select Groups" class="form-group flex-grow-1" required />

                            <button type="button" wire:click="openModal('Group')"
                                class="btn btn-sm btn-outline-primary p-1 m-0" data-bs-toggle="modal"
                                data-bs-target="#indexModal">
                                <i class='bx bx-plus-medical fs-5'></i>
                            </button>

                        </div>
                    </div>

                    <div class="col-md-4 mb-3" wire:ignore>
                        <label class="form-label"
                            type="enterprises">{{ __('grantmanagement::grantmanagement.select_enterprises') }}</label>
                        <div class="d-flex align-items-center gap-1">

                            <x-form.select :options="$enterprises" multiple name="selectedEnterprises"
                                wireModel="selectedEnterprises" placeholder="Select Enterprises"
                                class="form-group flex-grow-1" required />
                            <button type="button" wire:click="openModal('Enterprise')"
                                class="btn btn-sm btn-outline-primary p-1 m-0" data-bs-toggle="modal"
                                data-bs-target="#indexModal">
                                <i class='bx bx-plus-medical fs-5'></i>
                            </button>
                        </div>

                    </div>

                    <div class="col-md-4 mb-3" wire:ignore>
                        <label class="form-label"
                            for="selectedCooperatives">{{ __('grantmanagement::grantmanagement.select_cooperatives') }}</label>

                        <div class="d-flex align-items-center gap-1">
                            <x-form.select :options="$cooperatives" multiple name="selectedCooperatives"
                                wireModel="selectedCooperatives" placeholder="Select Cooperatives"
                                class="form-group flex-grow-1" required />

                            <button type="button" wire:click="openModal('Cooperative')"
                                class="btn btn-sm btn-outline-primary p-1 m-0" data-bs-toggle="modal"
                                data-bs-target="#indexModal">
                                <i class='bx bx-plus-medical fs-5'></i>
                            </button>
                        </div>
                    </div>

                @endif

            </div>
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary"
                wire:loading.attr="disabled">{{ __('grantmanagement::grantmanagement.save') }}</button>
            <a href="{{ route('admin.farmers.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('grantmanagement::grantmanagement.back') }}</a>
        </div>

    </form>

    @if ($showSelectedFarmerModal)

        <!-- COOPERATIVE INVOLVEMENT MODAL -->
        <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="planLevelModalLabel"
            aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalLabel">
                            {{ __('Create ' . $activeModal) }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;
                        </button>
                    </div>
                    <div class="modal-body">

                        @if ($activeModal === 'Cooperative')
                            <livewire:grant_management.cooperative_form :action="App\Enums\Action::CREATE" :showSelectedFarmerModal="false" />
                        @endif

                        @if ($activeModal === 'Group')
                            <livewire:grant_management.group_form :showSelectedFarmerModal="false" :action="App\Enums\Action::CREATE" />
                        @endif


                        @if ($activeModal === 'Enterprise')
                            <livewire:grant_management.enterprise_form :showSelectedFarmerModal="false" :action="App\Enums\Action::CREATE" />
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            const elements = [{
                    id: '#selectFarmers',
                    placeholder: "{{ __('grantmanagement::grantmanagement.select_farmers') }}",
                    selectedValues: @json($farmer->farmer_ids) ?? [],
                    updateFunction: 'updateSelectedFarmer'
                },
                {
                    id: '#selectRelationship',
                    placeholder: "{{ __('grantmanagement::grantmanagement.select_relations') }}",
                    selectedValues: @json($farmer->relationships) ?? [],
                    updateFunction: 'updateSelectedRelationship'
                },
                {
                    id: "#selectUser",
                    placeholder: "{{ __('grantmanagement::grantmanagement.select_user') }}",
                    selectedValues: @json($farmer->relationships) ?? [],
                    updateFunction: "showUserData"

                }
            ];

            elements.forEach(function(element) {
                const selectElement = $(element.id);

                selectElement.select2({
                    placeholder: element.placeholder,
                    allowClear: true,
                    width: '100%'
                });

                // Set selected values
                selectElement.val(element.selectedValues).trigger('change');

                // Handle change event
                selectElement.on('change', function() {
                    @this.call(element.updateFunction, $(this).val());
                });

            });

            const selectedValue = {{ $farmer->user_id ?? 'null' }};
            $('#selectUser').select2({
                placeholder: "{{ __('grantmanagement::grantmanagement.select_user') }}",
                allowClear: true,
                width: '100%'
            });

            // Set the selected user (if editing)
            setTimeout(() => {
                if (selectedValue !== null) {
                    $('#selectUser').val(selectedValue).trigger('change');
                }
            }, 100);
            // Update Livewire property when selection changes
            $('#selectUser').on('change', function() {
                @this.set('farmer.user_id', $(this).val());
            });
        });



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
@endpush
