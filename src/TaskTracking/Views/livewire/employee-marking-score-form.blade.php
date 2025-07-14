<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='employee_marking_id' class='form-label'>{{__('tasktracking::tasktracking.employee_marking_id')}}</label>
        <input wire:model='employeeMarkingScore.employee_marking_id' name='employee_marking_id' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_employee_marking_id')}}">
        <div>
            @error('employeeMarkingScore.employee_marking_id')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='criteria_id' class='form-label'>{{__('tasktracking::tasktracking.criteria_id')}}</label>
        <input wire:model='employeeMarkingScore.criteria_id' name='criteria_id' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_criteria_id')}}">
        <div>
            @error('employeeMarkingScore.criteria_id')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='score_obtained' class='form-label'>{{__('tasktracking::tasktracking.score_obtained')}}</label>
        <input wire:model='employeeMarkingScore.score_obtained' name='score_obtained' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_score_obtained')}}">
        <div>
            @error('employeeMarkingScore.score_obtained')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='score_out_of' class='form-label'>{{__('tasktracking::tasktracking.score_out_of')}}</label>
        <input wire:model='employeeMarkingScore.score_out_of' name='score_out_of' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_score_out_of')}}">
        <div>
            @error('employeeMarkingScore.score_out_of')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('tasktracking::tasktracking.save')}}</button>
        <a href="{{route('admin.employee_marking_scores.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('tasktracking::tasktracking.back')}}</a>
    </div>
</form>
