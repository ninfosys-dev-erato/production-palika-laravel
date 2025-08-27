<form wire:submit.prevent="save" class="mx-4">
    <!-- Basic Information Section -->
    <div class="mb-4">
        {{-- <label for="phone"
            class="form-label fw-bold fs-7 d-block">{{ __('ejalas::ejalas.search_user_by_phone_number') }}</label>
        <div class="input-group">
            <input type="text" class="form-control" id="phone" wire:model.defer="phone"
                placeholder={{ __('ejalas::ejalas.enter_phone_number') }} aria-label="Phone number"
                aria-describedby="button-addon2">
            <button class="btn btn-outline-primary" type="button" wire:click.prevent="search">
                {{ __('ejalas::ejalas.search') }}
            </button>
        </div> --}}

        <livewire:phone_search />
        {{-- @error('phone')
            <span class="text-danger text-sm">{{ __($message) }}</span>
        @enderror --}}
    </div>



    <div class="divider divider-primary text-start text-primary mb-4">
        <div class="divider-text fw-bold fs-6">
            {{ __('ejalas::ejalas.personal_details') }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="name" class="form-label">{{ __('ejalas::ejalas.name') }}</label>
                <input wire:model="party.name" id="name" name="name" type="text" class="form-control"
                    placeholder="{{ __('ejalas::ejalas.enter_name') }}">
                @error('party.name')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="gender" class="form-label">{{ __('ejalas::ejalas.gender') }}</label>
                <select wire:model="party.gender" id="gender" name="gender" class="form-select">
                    <option value="" hidden>{{ __('ejalas::ejalas.select_a_gender') }}</option>
                    <option value="Male">{{ __('ejalas::ejalas.male') }}</option>
                    <option value="Female">{{ __('ejalas::ejalas.female') }}</option>
                </select>
                @error('party.gender')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="age" class="form-label">{{ __('ejalas::ejalas.age') }}</label>
                <input wire:model="party.age" id="age" name="age" type="text" class="form-control"
                    placeholder="{{ __('ejalas::ejalas.enter_age') }}">
                @error('party.age')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="phone_no" class="form-label">{{ __('ejalas::ejalas.phone_no') }}</label>
                <input wire:model="party.phone_no" id="phone_no" name="phone_no" type="tel" class="form-control"
                    placeholder="{{ __('ejalas::ejalas.enter_phone_no') }}">
                @error('party.phone_no')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="citizenship_no" class="form-label">{{ __('ejalas::ejalas.citizenship_no') }}</label>
                <input wire:model="party.citizenship_no" id="citizenship_no" name="citizenship_no" type="text"
                    class="form-control" placeholder="{{ __('ejalas::ejalas.enter_citizenship_no') }}">
                @error('party.citizenship_no')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
    </div>

    <!-- Family Information Section -->
    <div class="divider divider-primary text-start text-primary mb-4">
        <div class="divider-text fw-bold fs-6">
            {{ __('ejalas::ejalas.family_information') }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="grandfather_name" class="form-label">{{ __('ejalas::ejalas.grandfather_name') }}</label>
                <input wire:model="party.grandfather_name" id="grandfather_name" name="grandfather_name" type="text"
                    class="form-control" placeholder="{{ __('ejalas::ejalas.enter_grandfather_name') }}">
                @error('party.grandfather_name')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="father_name" class="form-label">{{ __('ejalas::ejalas.father_name') }}</label>
                <input wire:model="party.father_name" id="father_name" name="father_name" type="text"
                    class="form-control" placeholder="{{ __('ejalas::ejalas.enter_father_name') }}">
                @error('party.father_name')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="spouse_name" class="form-label">{{ __('ejalas::ejalas.spouse_name') }}</label>
                <input wire:model="party.spouse_name" id="spouse_name" name="spouse_name" type="text"
                    class="form-control" placeholder="{{ __('ejalas::ejalas.enter_spouse_name') }}">
                @error('party.spouse_name')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
    </div>

    <!-- Permanent Address Section -->
    <div class="divider divider-primary text-start text-primary mb-4">
        <div class="divider-text fw-bold fs-6">
            {{ __('ejalas::ejalas.permanent_address') }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="permanent_province_id"
                    class="form-label">{{ __('ejalas::ejalas.permanent_province') }}</label>
                <select wire:model="party.permanent_province_id" id="permanent_province_id"
                    name="permanent_province_id" class="form-select" wire:change='getDistrict'>
                    <option value="" hidden>{{ __('ejalas::ejalas.select_a_province') }}</option>
                    @foreach ($provinces as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('party.permanent_province_id')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="permanent_district_id"
                    class="form-label">{{ __('ejalas::ejalas.permanent_district') }}</label>
                <select wire:model="party.permanent_district_id" id="permanent_district_id"
                    name="permanent_district_id" class="form-select" wire:change='getLocalBody'
                    wire:key="permanent_district_{{ $party->permanent_province_id }}">
                    <option value="" hidden>{{ __('ejalas::ejalas.select_a_district') }}</option>
                    @foreach ($districts as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('party.permanent_district_id')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="permanent_local_body_id"
                    class="form-label">{{ __('ejalas::ejalas.permanent_local_body') }}</label>
                <select wire:model="party.permanent_local_body_id" id="permanent_local_body_id"
                    name="permanent_local_body_id" class="form-select" wire:change='getWard'
                    wire:key="permanent_local_body_{{ $party->permanent_district_id }}">
                    <option value="" hidden>{{ __('ejalas::ejalas.select_a_local_body') }}</option>
                    @foreach ($localBodies as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('party.permanent_local_body_id')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="permanent_ward_id"
                    class="form-label">{{ __('ejalas::ejalas.permanent_ward_no') }}</label>
                <select wire:model="party.permanent_ward_id" id="permanent_ward_id" name="permanent_ward_id"
                    class="form-select" wire:key="permanent_ward_{{ $party->permanent_local_body_id }}">
                    <option value="" hidden>{{ __('ejalas::ejalas.select_a_ward') }}</option>
                    @foreach ($wards as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('party.permanent_ward_id')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="permanent_tole"
                    class="form-label">{{ __('ejalas::ejalas.permanent_tolestreet') }}</label>
                <input wire:model="party.permanent_tole" id="permanent_tole" name="permanent_tole" type="text"
                    class="form-control" placeholder="{{ __('ejalas::ejalas.enter_permanent_tole') }}">
                @error('party.permanent_tole')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
    </div>

    <!-- Temporary Address Section -->
    <div class="divider divider-primary text-start text-primary mb-4">
        <div class="divider-text fw-bold fs-6">
            {{ __('ejalas::ejalas.temporary_address') }}
        </div>
    </div>
    <div class="row">
        <!-- Temporary Province -->
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="temporary_province_id"
                    class="form-label">{{ __('ejalas::ejalas.temporary_province') }}</label>
                <select wire:model="party.temporary_province_id" id="temporary_province_id"
                    name="temporary_province_id" class="form-select" wire:change="getTemporaryDistrict">
                    <option value="" hidden>{{ __('ejalas::ejalas.select_a_province') }}</option>
                    @foreach ($provinces as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('party.temporary_province_id')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>

        <!-- Temporary District -->
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="temporary_district_id"
                    class="form-label">{{ __('ejalas::ejalas.temporary_district') }}</label>
                <select wire:model="party.temporary_district_id" id="temporary_district_id"
                    name="temporary_district_id" class="form-select" wire:change="getTemporaryLocalBody"
                    wire:key="temporary_district_{{ $party->temporary_province_id }}">
                    <option value="" hidden>{{ __('ejalas::ejalas.select_a_district') }}</option>
                    @foreach ($temporaryDistricts as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('party.temporary_district_id')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>

        <!-- Temporary Local Body -->
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="temporary_local_body_id"
                    class="form-label">{{ __('ejalas::ejalas.temporary_local_body') }}</label>
                <select wire:model="party.temporary_local_body_id" id="temporary_local_body_id"
                    name="temporary_local_body_id" class="form-select" wire:change="getTemporaryWard"
                    wire:key="temporary_local_body_{{ $party->temporary_district_id }}">
                    <option value="" hidden>{{ __('ejalas::ejalas.select_a_local_body') }}</option>
                    @foreach ($temporaryLocalBodies as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('party.temporary_local_body_id')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>

        <!-- Temporary Ward -->
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="temporary_ward_id"
                    class="form-label">{{ __('ejalas::ejalas.temporary_ward_no') }}</label>
                <select wire:model="party.temporary_ward_id" id="temporary_ward_id" name="temporary_ward_id"
                    class="form-select" wire:key="temporary_ward_{{ $party->temporary_local_body_id }}">
                    <option value="" hidden>{{ __('ejalas::ejalas.select_a_ward') }}</option>
                    @foreach ($temporaryWards as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('party.temporary_ward_id')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>

        <!-- Temporary Tole/Street -->
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="temporary_tole"
                    class="form-label">{{ __('ejalas::ejalas.temporary_tolestreet') }}</label>
                <input wire:model="party.temporary_tole" id="temporary_tole" name="temporary_tole" type="text"
                    class="form-control" placeholder="{{ __('ejalas::ejalas.enter_temporary_tole') }}">
                @error('party.temporary_tole')
                    <small class='text-danger'>{{ __($message) }}</small>
                @enderror
            </div>
        </div>
    </div>

    <!-- Form Footer -->
    <div class="card-footer">
        @if ($searchResult)
            <button type="button" class="btn btn-primary" wire:loading.attr="disabled"
                wire:click="addSearchResult">{{ __('ejalas::ejalas.add') }}</button>
        @else
            <button type="submit" class="btn btn-primary"
                wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        @endif

        <button type="button" data-bs-dismiss="modal" class="btn btn-danger"
            wire:loading.attr="disabled">{{ __('ejalas::ejalas.back') }}</button>
    </div>
</form>
