<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='name' class='form-label'>{{__('yojana::yojana.name')}}</label>
                    <input wire:model='committeeType.name' name='name' type='text' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_name_in_nepali')}}">
                    <div>
                        @error('committeeType.name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='name_en' class='form-label'>{{__('yojana::yojana.name_english')}}</label>
                    <input wire:model='committeeType.name_en' name='name_en' type='text' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_name_in_english')}}">
                    <div>
                        @error('committeeType.name_en')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='code' class='form-label'>{{__('yojana::yojana.code')}}</label>
                    <input wire:model='committeeType.code' name='code' type='text' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_code')}}">
                    <div>
                        @error('committeeType.code')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
    </div>
</form>


