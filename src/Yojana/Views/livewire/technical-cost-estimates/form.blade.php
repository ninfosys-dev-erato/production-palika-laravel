<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='technicalCostEstimate.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('technicalCostEstimate.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='detail'>Detail</label>
                <input wire:model='technicalCostEstimate.detail' name='detail' type='text' class='form-control' placeholder='Enter Detail'>
                <div>
                    @error('technicalCostEstimate.detail')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='quantity'>Quantity</label>
                <input wire:model='technicalCostEstimate.quantity' name='quantity' type='text' class='form-control' placeholder='Enter Quantity'>
                <div>
                    @error('technicalCostEstimate.quantity')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='unit_id'>Unit Id</label>
                <input wire:model='technicalCostEstimate.unit_id' name='unit_id' type='text' class='form-control' placeholder='Enter Unit Id'>
                <div>
                    @error('technicalCostEstimate.unit_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='rate'>Rate</label>
                <input wire:model='technicalCostEstimate.rate' name='rate' type='text' class='form-control' placeholder='Enter Rate'>
                <div>
                    @error('technicalCostEstimate.rate')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.technical_cost_estimates.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
