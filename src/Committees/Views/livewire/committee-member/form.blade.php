<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <livewire:phone_search />
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form.select-input label="{{ __('Committee Name') }}" id="committee_id"
                    name="committeeMember.committee_id" :options="\Src\Committees\Models\Committee::get()->pluck('committee_name', 'id')->toArray()" placeholder="{{ __('Choose Committee') }}" />
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('Name') }}" id="name" name="committeeMember.name" />
            </div>
            <div class="col-md-6">
                <x-form.file-input label="{{ __('Photo') }}" id="photo" name="uploadedImage"
                    accept=".jpg,.jpeg,.png" />
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('Phone') }}" id="phone" name="committeeMember.phone" />
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('Email') }}" id="email" name="committeeMember.email" />
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('Designation') }}" id="designation"
                    name="committeeMember.designation" />
            </div>
            <div class="col-md-6">
                <x-form.select-input label="{{ __('Province') }}" id="province_id" name="committeeMember.province_id"
                    :options="getProvinces()->pluck('title', 'id')->toArray()" placeholder="{{ __('Choose Province') }}" wireChange="loadDistricts()" />
            </div>
            <div class="col-md-6">
                <x-form.select-input label="{{ __('District') }}" id="district_id" name="committeeMember.district_id"
                    :options="$districts" placeholder="{{ __('Choose District') }}" wire-change="loadLocalBodies()" />
            </div>
            <div class="col-md-6">
                <x-form.select-input label="{{ __('Local Body') }}" id="local_body_id"
                    name="committeeMember.local_body_id" :options="$localBodies" placeholder="{{ __('Choose Local Body') }}"
                    wire-change="loadWards" />
            </div>
            <div class="col-md-6">
                <x-form.select-input label="{{ __('Ward') }}" id="ward_no" name="committeeMember.ward_no"
                    :options="$wards" placeholder="{{ __('Choose Ward') }}" />
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('Tole') }}" id="tole" name="committeeMember.tole" />
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('Position') }}" id="position" type="number" min="0"
                    name="committeeMember.position" />
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        @if (!$isModalForm)
            <a href="{{ route('admin.committee-members.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('Back') }}</a>
        @endif
    </div>
</form>