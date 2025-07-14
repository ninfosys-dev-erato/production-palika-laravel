<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='employee_id' class='form-label'>{{__('tasktracking::tasktracking.employee_id')}}</label>
        <input wire:model='employeeMarking.employee_id' name='employee_id' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_employee_id')}}">
        <div>
            @error('employeeMarking.employee_id')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='anusuchi_id' class='form-label'>{{__('tasktracking::tasktracking.anusuchi_id')}}</label>
        <input wire:model='employeeMarking.anusuchi_id' name='anusuchi_id' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_anusuchi_id')}}">
        <div>
            @error('employeeMarking.anusuchi_id')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='score' class='form-label'>{{__('tasktracking::tasktracking.score')}}</label>
        <input wire:model='employeeMarking.score' name='score' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_score')}}">
        <div>
            @error('employeeMarking.score')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='fiscal_year' class='form-label'>{{__('tasktracking::tasktracking.fiscal_year')}}</label>
        <input wire:model='employeeMarking.fiscal_year' name='fiscal_year' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_fiscal_year')}}">
        <div>
            @error('employeeMarking.fiscal_year')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='period_title' class='form-label'>{{__('tasktracking::tasktracking.period_title')}}</label>
        <input wire:model='employeeMarking.period_title' name='period_title' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_period_title')}}">
        <div>
            @error('employeeMarking.period_title')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='period_type' class='form-label'>{{__('tasktracking::tasktracking.period_type')}}</label>
        <input wire:model='employeeMarking.period_type' name='period_type' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_period_type')}}">
        <div>
            @error('employeeMarking.period_type')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='date_from' class='form-label'>{{__('tasktracking::tasktracking.date_from')}}</label>
        <input wire:model='employeeMarking.date_from' name='date_from' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_date_from')}}">
        <div>
            @error('employeeMarking.date_from')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='date_to' class='form-label'>{{__('tasktracking::tasktracking.date_to')}}</label>
        <input wire:model='employeeMarking.date_to' name='date_to' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_date_to')}}">
        <div>
            @error('employeeMarking.date_to')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('tasktracking::tasktracking.save')}}</button>
        <a href="{{route('admin.employee_markings.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('tasktracking::tasktracking.back')}}</a>
    </div>
</form>
