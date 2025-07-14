<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            @if ($action === \App\Enums\Action::CREATE)
                <div class='col-md-6'>
                    <div class='form-group'>
                        <label for='id'>{{__('Ward Id')}}</label>
                        <input dusk="wards-id-field" wire:model='ward.id' name='id' type='text' class='form-control'
                            placeholder='Enter Ward Id'>
                        <div>
                            @error('ward.id')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='phone'>{{__('Phone')}}</label>
                    <input dusk="wards-phone-field" wire:model='ward.phone' name='phone' type='text' class='form-control'
                        placeholder='Enter Phone'>
                    <div>
                        @error('ward.phone')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='email'>{{__('Email')}}</label>
                    <input dusk="wards-email-field" wire:model='ward.email' name='email' type='text' class='form-control'
                        placeholder='Enter Email'>
                    <div>
                        @error('ward.email')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='address_en'>{{__('Address En')}}</label>
                    <input dusk="wards-address_en-field" wire:model='ward.address_en' name='address_en' type='text' class='form-control'
                        placeholder='Enter Address En'>
                    <div>
                        @error('ward.address_en')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='address_ne'>{{__('Address Ne')}}</label>
                    <input dusk="wards-address_ne-field" wire:model='ward.address_ne' name='address_ne' type='text' class='form-control'
                        placeholder='Enter Address Ne'>
                    <div>
                        @error('ward.address_ne')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='ward_name_en'>{{__('Ward Name En')}}</label>
                    <input dusk="wards-ward_name_en-field" wire:model='ward.ward_name_en' name='ward_name_en' type='text' class='form-control'
                        placeholder='Enter Ward Name En'>
                    <div>
                        @error('ward.ward_name_en')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='ward_name_ne'>{{__('Ward Name Ne')}}</label>
                    <input dusk="wards-ward_name_ne-field" wire:model='ward.ward_name_ne' name='ward_name_ne' type='text' class='form-control'
                        placeholder='Enter Ward Name Ne'>
                    <div>
                        @error('ward.ward_name_ne')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button dusk="save"  type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('Save')}}</button>
        <a  href="{{ route('admin.wards.index') }}" wire:loading.attr="disabled" class="btn btn-danger">{{__('Back')}}</a>
    </div>
</form>
