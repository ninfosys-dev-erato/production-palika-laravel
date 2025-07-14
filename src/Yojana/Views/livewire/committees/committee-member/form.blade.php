<form wire:submit.prevent="save">
    <div class="card-body">

        <div class="row">
            <livewire:phone_search/>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form.select-input label="{{ __('yojana::yojana.committee_name') }}" id="committee_id"
                                     name="committeeMember.committee_id"
                                     :options="\Src\Yojana\Models\Committee::get()->pluck('committee_name', 'id')->toArray()"
                                     placeholder="{{ __('yojana::yojana.choose_committee') }}"/>
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('yojana::yojana.name') }}" id="name" name="committeeMember.name"/>

            </div>

            <div class="col-md-6">
                <x-form.file-input label="{{ __('yojana::yojana.photo') }}" id="photo" name="uploadedImage"
                                   accept=".jpg,.jpeg,.png"/>
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('yojana::yojana.phone') }}" id="phone" name="committeeMember.phone"/>
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('yojana::yojana.email') }}" id="email" name="committeeMember.email"/>
            </div>

            <div class='col-md-6'>
                <x-form.text-input label="{{ __('yojana::yojana.designation') }}" id="designation"
                                   name="committeeMember.designation"/>
            </div>


            <div class="col-md-6">
                <x-form.select-input label="{{ __('yojana::yojana.province') }}" id="province_id" name="committeeMember.province_id"
                                     :options="getProvinces()->pluck('title', 'id')->toArray()"
                                     placeholder="{{ __('yojana::yojana.choose_province') }}" wireChange="loadDistricts()"/>
            </div>
            <div class="col-md-6">
                <x-form.select-input label="{{ __('yojana::yojana.district') }}" id="district_id" name="committeeMember.district_id"
                                     :options="$districts" placeholder="{{ __('yojana::yojana.choose_district') }}"
                                     wire-change="loadLocalBodies()"/>

            </div>
            <div class="col-md-6">
                <x-form.select-input label="{{ __('yojana::yojana.local_body') }}" id="local_body_id"
                                     name="committeeMember.local_body_id" :options="$localBodies"
                                     placeholder="{{ __('yojana::yojana.choose_local_body') }}"
                                     wire-change="loadWards"/>
            </div>
            <div class="col-md-6">
                <x-form.select-input label="{{ __('yojana::yojana.ward') }}" id="ward_no" name="committeeMember.ward_no"
                                     :options="$wards" placeholder="{{ __('yojana::yojana.choose_ward') }}"/>
            </div>

            <div class='col-md-6'>
                <x-form.text-input label="{{ __('yojana::yojana.tole') }}" id="tole" name="committeeMember.tole"/>
            </div>
            <div class='col-md-6'>
                <x-form.text-input label="{{ __('yojana::yojana.position') }}" id="position" type="number" min="0"
                                   name="committeeMember.position"/>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>

        @if (!$isModalForm)
            <a href="{{ route('admin.committee-members.index') }}" wire:loading.attr="disabled"
               class="btn btn-danger">{{ __('yojana::yojana.back') }}</a>
        @endif
    </div>
</form>
