<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='signature_party' class='form-label'>{{__('yojana::yojana.signature_party')}}</label>
        <input wire:model='agreementSignatureDetail.signature_party' name='signature_party' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_signature_party')}}">
        <div>
            @error('agreementSignatureDetail.signature_party')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='name' class='form-label'>{{__('yojana::yojana.name')}}</label>
        <input wire:model='agreementSignatureDetail.name' name='name' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_name')}}">
        <div>
            @error('agreementSignatureDetail.name')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='position' class='form-label'>{{__('yojana::yojana.position')}}</label>
        <input wire:model='agreementSignatureDetail.position' name='position' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_position')}}">
        <div>
            @error('agreementSignatureDetail.position')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='address' class='form-label'>{{__('yojana::yojana.address')}}</label>
        <input wire:model='agreementSignatureDetail.address' name='address' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_address')}}">
        <div>
            @error('agreementSignatureDetail.address')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='contact_number' class='form-label'>{{__('yojana::yojana.contact_number')}}</label>
        <input wire:model='agreementSignatureDetail.contact_number' name='contact_number' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_contact_number')}}">
        <div>
            @error('agreementSignatureDetail.contact_number')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='date' class='form-label'>{{__('yojana::yojana.date')}}</label>
        <input wire:model='agreementSignatureDetail.date' name='date' type='date' class='form-control' placeholder="{{__('yojana::yojana.enter_date')}}">
        <div>
            @error('agreementSignatureDetail.date')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="{{route('admin.agreement_signature_details.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
