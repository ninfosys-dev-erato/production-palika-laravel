<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='parent_id'>{{ __('emergencycontacts::emergencycontacts.select_parent') }}</label>
                    <select dusk="emergencyContact.parent_id-field" name="emergencyContact.parent_id" wire:model="emergencyContact.parent_id" id="group"
                        class="form-control">
                        <option value=""> {{ __('emergencycontacts::emergencycontacts.select_parent') }}</option>
                        @foreach ($contacts as $contact)
                            <option value="{{ $contact->id }}">
                                {{ $contact->service_name }}
                            </option>
                        @endforeach
                    </select>
                    <div>
                        @error('emergencyContact.parent_id')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class='form-group'>
                    <label for='group'>{{ __('emergencycontacts::emergencycontacts.select_group') }}</label>
                    <select dusk="emergencyContact.group-field" name="emergencyContact.group" wire:model="emergencyContact.group" id="group"
                        class="form-control">
                        <option value=""> {{ __('emergencycontacts::emergencycontacts.select_group') }}</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->value }}">{{ $group->label() }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('emergencyContact.group')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class='form-group'>
                    <label for='service_name'>{{ __('emergencycontacts::emergencycontacts.service_name') }}</label>
                    <input dusk="service_name-field" wire:model='emergencyContact.service_name' name='service_name' type='text'
                        class="form-control {{ $errors->has('emergencyContact.service_name') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('emergencyContact.service_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('emergencycontacts::emergencycontacts.enter_service_name') }}">
                    <div>
                        @error('emergencyContact.service_name')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='service_name_ne'>{{ __('emergencycontacts::emergencycontacts.service_name') . ' ' . __('emergencycontacts::emergencycontacts.nepali') }}</label>
                    <input dusk="service_name_ne-field" wire:model='emergencyContact.service_name_ne' name='service_name_ne' type='text'
                        class="form-control {{ $errors->has('emergencyContact.service_name') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('emergencyContact.service_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('emergencycontacts::emergencycontacts.enter_service_name') }}">
                    <div>
                        @error('emergencyContact.service_name_ne')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6">

                <div class="mb-3">
                    <div class='form-group'>
                        <label for='image'>{{ __('emergencycontacts::emergencycontacts.icon') }}</label>
                        <input dusk="icon-field" wire:model="icon" name='icon' type='file'
                            class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('icon') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            accept=".jpg,.jpeg,.png">
                        <div>
                            @error('icon')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                        @if ($icon)
                            <img src="{{ $icon->temporaryUrl() }}" alt="Uploaded Image Preview"
                                class="img-thumbnail mt-2" style="height: 300px;">
                        @endif
                    </div>
                </div>
                <div>
                    @if ($existingImage)
                        <img src="{{ customFileAsset(config('src.EmergencyContacts.emergencyContact.icon_path'), $existingImage, 'local', 'tempUrl') }}"
                            alt="Current Banner Image" class="img-thumbnail mt-2" style="height: 50px;">
                    @endif
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='contact_person'>{{ __('emergencycontacts::emergencycontacts.contact_person') }}</label>
                    <input dusk="contact_person-field" wire:model='emergencyContact.contact_person' name='contact_person' type='text'
                        class="form-control {{ $errors->has('emergencyContact.contact_person') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('emergencyContact.contact_person') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('emergencycontacts::emergencycontacts.enter_contact_person') }}">
                    <div>
                        @error('emergencyContact.contact_person')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='contact_person_ne'>{{ __('emergencycontacts::emergencycontacts.contact_person') . ' ' . __('emergencycontacts::emergencycontacts.nepali') }}</label>
                    <input dusk="contact_person_ne-field" wire:model='emergencyContact.contact_person_ne' name='contact_person_ne' type='text'
                        class="form-control {{ $errors->has('emergencyContact.contact_person_ne') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('emergencyContact.contact_person_ne') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('emergencycontacts::emergencycontacts.enter_contact_person') }}">
                    <div>
                        @error('emergencyContact.contact_person_ne')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='address'>{{ __('emergencycontacts::emergencycontacts.address') }}</label>
                    <input dusk="address-field" wire:model='emergencyContact.address' name='address' type='text'
                        class="form-control {{ $errors->has('emergencyContact.address') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('emergencyContact.address') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('emergencycontacts::emergencycontacts.enter_address') }}">
                    <div>
                        @error('emergencyContact.address')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='address_ne'>{{ __('emergencycontacts::emergencycontacts.address') . ' ' . __('emergencycontacts::emergencycontacts.nepali') }}</label>
                    <input dusk="address_ne-field" wire:model='emergencyContact.address_ne' name='address_ne' type='text'
                        class="form-control {{ $errors->has('emergencyContact.address_ne') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('emergencyContact.address_ne') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('emergencycontacts::emergencycontacts.enter_address') }}">
                    <div>
                        @error('emergencyContact.address_ne')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='contact_numbers'>{{ __('emergencycontacts::emergencycontacts.contact_number') }}</label>
                    <input dusk="contact_numbers-field" wire:model='emergencyContact.contact_numbers' name='contact_numbers' type='text'
                        class="form-control {{ $errors->has('emergencyContact.contact_numbers') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('emergencyContact.contact_numbers') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('emergencycontacts::emergencycontacts.enter_contact_numbers') }}">
                    <div>
                        @error('emergencyContact.contact_numbers')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='site_map'>{{ __('emergencycontacts::emergencycontacts.site_map') }}</label>
                    <input dusk="site_map-field" wire:model='emergencyContact.site_map' name='site_map' type='text'
                        class="form-control {{ $errors->has('emergencyContact.site_map') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('emergencyContact.site_map') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('emergencycontacts::emergencycontacts.enter_map_link') }}">
                    <div>
                        @error('emergencyContact.site_map')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='website_url'>{{ __('emergencycontacts::emergencycontacts.website_url') }}</label>
                    <input dusk="website_url-field" wire:model='emergencyContact.website_url' name='website_url' type='text'
                        class="form-control {{ $errors->has('emergencyContact.website_url') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('emergencyContact.website_url') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('emergencycontacts::emergencycontacts.enter_website_url') }}">
                    <div>
                        @error('emergencyContact.website_url')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='facebook_url'>{{ __('emergencycontacts::emergencycontacts.facebook_url') }}</label>
                    <input dusk="facebook_url-field" wire:model='emergencyContact.facebook_url' name='facebook_url' type='text'
                        class="form-control {{ $errors->has('emergencyContact.facebook_url') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('emergencyContact.facebook_url') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('emergencycontacts::emergencycontacts.enter_facebook_url') }}">
                    <div>
                        @error('emergencyContact.facebook_url')
                            <div class='text-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <x-form.ck-editor-input label="{{ __('emergencycontacts::emergencycontacts.content') }}" id="content" name="emergencyContact.content"
                    wire:model="emergencyContact.content">
                </x-form.ck-editor-input>
                @error('emergencyContact.content')
                    <div class='text-danger'>{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <x-form.ck-editor-input label="{{ __('emergencycontacts::emergencycontacts.content') . ' ' . __('emergencycontacts::emergencycontacts.nepali') }}" id="content_ne"
                    name="emergencyContact.content_ne" wire:model="emergencyContact.content_ne">
                </x-form.ck-editor-input>
                @error('emergencyContact.content_ne')
                    <div class='text-danger'>{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('emergencycontacts::emergencycontacts.save') }}</button>
            <a href="{{ route('admin.emergency-contacts.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('emergencycontacts::emergencycontacts.back') }}</a>
        </div>
</form>
