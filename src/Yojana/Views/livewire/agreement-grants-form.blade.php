<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='source_type_id' class='form-label'>{{__('yojana::yojana.source_type')}}</label>
                    {{--        <input wire:model='agreementGrant.source_type_id' name='source_type_id' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_source_type_id')}}">--}}
                    <select wire:model='agreementGrant.source_type_id' name='source_type_id' type='text'
                            class='form-control {{ $errors->has('agreementGrant.source_type_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden >{{__('yojana::yojana.select_source_type')}}</option>
                        @foreach($sourceTypes as $id => $title)
                            <option value="{{$id}}">{{$title}}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('agreementGrant.source_type_id')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='material_name' class='form-label'>{{__('yojana::yojana.material_name')}}</label>
                    <input wire:model='agreementGrant.material_name' name='material_name' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_material_name')}}">
                    <div>
                        @error('agreementGrant.material_name')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='unit' class='form-label'>{{__('yojana::yojana.unit')}}</label>
                    <input wire:model='agreementGrant.unit' name='unit' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_unit')}}">
                    <div>
                        @error('agreementGrant.unit')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='amount' class='form-label'>{{__('yojana::yojana.amount')}}</label>
                    <input wire:model='agreementGrant.amount' name='amount' type='number' class='form-control' placeholder="{{__('yojana::yojana.enter_amount')}}">
                    <div>
                        @error('agreementGrant.amount')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="{{route('admin.agreement_grants.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
