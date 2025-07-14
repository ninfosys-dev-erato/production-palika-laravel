<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='consumerCommitteeTransaction.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('consumerCommitteeTransaction.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='type'>Type</label>
                <input wire:model='consumerCommitteeTransaction.type' name='type' type='text' class='form-control' placeholder='Enter Type'>
                <div>
                    @error('consumerCommitteeTransaction.type')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='date'>Date</label>
                <input wire:model='consumerCommitteeTransaction.date' name='date' type='text' class='form-control' placeholder='Enter Date'>
                <div>
                    @error('consumerCommitteeTransaction.date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='amount'>Amount</label>
                <input wire:model='consumerCommitteeTransaction.amount' name='amount' type='text' class='form-control' placeholder='Enter Amount'>
                <div>
                    @error('consumerCommitteeTransaction.amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='remarks'>Remarks</label>
                <input wire:model='consumerCommitteeTransaction.remarks' name='remarks' type='text' class='form-control' placeholder='Enter Remarks'>
                <div>
                    @error('consumerCommitteeTransaction.remarks')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.consumer_committee_transactions.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
