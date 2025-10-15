<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label class="form-label" for='employee_id'>{{__('yojana::yojana.employee')}} <span class="text-danger">*</span></label>
{{--        <input wire:model='projectIncharge.employee_id' name='employee_id' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_employee_id')}}">--}}
        <select wire:model='projectIncharge.employee_id' name='employee_id' type='text'
                class='form-control {{ $errors->has('projectIncharge.employee_id') ? 'is-invalid' : '' }}' >
            <option value="" hidden >{{__('yojana::yojana.select_employee')}}</option>
            @foreach($employees as $employee)
                <option value="{{$employee->id}}">{{$employee->name}}</option>
            @endforeach
        </select>
        <div>
            @error('projectIncharge.employee_id')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label class="form-label" for='remarks'>{{__('yojana::yojana.remarks')}}</label>
        <input wire:model='projectIncharge.remarks' name='remarks' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_remarks')}}">
        <div>
            @error('projectIncharge.remarks')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
<div class='col-md-6 mt-4'>
    <div class='form-group'>
        <label class="form-label" for='is_active'>{{__('yojana::yojana.is_active')}}</label>
{{--        <input wire:model='projectIncharge.is_active' name='is_active' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_is_active')}}">--}}
        <input wire:model="projectIncharge.is_active" name="is_active" type="checkbox"
               class="form-check-input m-1"
               id="is_active">
        <div>
            @error('projectIncharge.is_active')
            <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>

    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="{{route('admin.project_incharge.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
