<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='projectAllocatedAmount.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('projectAllocatedAmount.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='budget_head_id'>Budget Head Id</label>
                <input wire:model='projectAllocatedAmount.budget_head_id' name='budget_head_id' type='text' class='form-control' placeholder='Enter Budget Head Id'>
                <div>
                    @error('projectAllocatedAmount.budget_head_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='amount'>Amount</label>
                <input wire:model='projectAllocatedAmount.amount' name='amount' type='text' class='form-control' placeholder='Enter Amount'>
                <div>
                    @error('projectAllocatedAmount.amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.project_allocated_amounts.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
