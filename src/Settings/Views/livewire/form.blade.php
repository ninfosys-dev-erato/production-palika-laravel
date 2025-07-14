<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-12'>
                <div class='form-group'>
                    <label for='key'>Key</label>
                    <input wire:model='setting.key' name='key' type='text' class='form-control' placeholder='Enter Key'{{$action === \App\Enums\Action::UPDATE ?"readonly":false}}>
                    <div>
                        @error('setting.key')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='label'>Label</label>
                    <input wire:model='setting.label' name='label' type='text' class='form-control' placeholder='Enter Label'>
                    <div>
                        @error('setting.label')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='label_ne'>Label Nepali</label>
                    <input wire:model='setting.label_ne' name='label_ne' type='text' class='form-control' placeholder='Enter Label'>
                    <div>
                        @error('setting.label_ne')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <div class='form-group'>
                    <label for='key_type'>Key Type</label>
                    <select name="" id="" wire:model='setting.key_type' class='form-control' wire:change="loadNeedle($event.target.value)">
                        <option value="">{{__('settings::settings.select_and_option')}}</option>
                        @foreach(\Src\Settings\Enums\KeyType::cases() as $key)
                            <option value="{{$key->value}}">{{$key->name}}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('setting.key_type')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            @if($setting->key_type !== "")
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='key_needle'>Key Needle</label>
                    <select name="" id="" wire:model='setting.key_needle' name='key_needle' type='text' class='form-control'>
                        @foreach($needleOptions as $option)
                            <option value="{{$option}}">{{$option}}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('setting.key_needle')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='key_id'>Key Id</label>
                    <input wire:model='setting.key_id' name='key_id' type='text' class='form-control' placeholder='Enter Key Id'>
                    <div>
                        @error('setting.key_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            @endif
            <div class='col-md-12'>
                <div class='form-group'>
                    <label for='description'>Description</label>
                    <input wire:model='setting.description' name='description' type='text' class='form-control' placeholder='Enter Description'>
                    <div>
                        @error('setting.description')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            @if($action === \App\Enums\Action::UPDATE )
                <button type="submit" class="btn btn-primary mt-2" wire:loading.attr="disabled"><i class="bx bx-save"></i> Save</button>
            @endif
        </div>
    </div>
    @if($action === \App\Enums\Action::CREATE )
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>

            <a href="{{route('admin.settings.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>

    </div>
    @endif
</form>
