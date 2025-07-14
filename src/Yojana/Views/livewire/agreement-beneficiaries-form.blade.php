<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='beneficiary_id' class='form-label'>{{__('yojana::yojana.beneficiary')}}</label>
                    {{--        <input wire:model='agreementBeneficiary.beneficiary_id' name='beneficiary_id' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_beneficiary_id')}}">--}}
                    <select wire:model='agreementBeneficiary.beneficiary_id' name='beneficiary_id' type='text'
                            class='form-control {{ $errors->has('agreementBeneficiary.beneficiary_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden >{{__('yojana::yojana.select_beneficiary')}}</option>
                        @foreach($beneficiaries as $id => $title)
                            <option value="{{$id}}">{{$title}}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('agreementBeneficiary.beneficiary_id')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='total_count' class='form-label'>{{__('yojana::yojana.total_count')}}</label>
                    <input wire:model='agreementBeneficiary.total_count' name='total_count' type='number' class='form-control' placeholder="{{__('yojana::yojana.enter_total_count')}}">
                    <div>
                        @error('agreementBeneficiary.total_count')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='men_count' class='form-label'>{{__('yojana::yojana.men_count')}}</label>
                    <input wire:model='agreementBeneficiary.men_count' name='men_count' type='number' class='form-control' placeholder="{{__('yojana::yojana.enter_men_count')}}">
                    <div>
                        @error('agreementBeneficiary.men_count')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='women_count' class='form-label'>{{__('yojana::yojana.women_count')}}</label>
                    <input wire:model='agreementBeneficiary.women_count' name='women_count' type='number' class='form-control' placeholder="{{__('yojana::yojana.enter_women_count')}}">
                    <div>
                        @error('agreementBeneficiary.women_count')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="{{route('admin.agreement_beneficiaries.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
