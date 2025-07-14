<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='projectBidSubmission.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('projectBidSubmission.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='submission_type'>Submission Type</label>
                <input wire:model='projectBidSubmission.submission_type' name='submission_type' type='text' class='form-control' placeholder='Enter Submission Type'>
                <div>
                    @error('projectBidSubmission.submission_type')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='submission_no'>Submission No</label>
                <input wire:model='projectBidSubmission.submission_no' name='submission_no' type='text' class='form-control' placeholder='Enter Submission No'>
                <div>
                    @error('projectBidSubmission.submission_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='date'>Date</label>
                <input wire:model='projectBidSubmission.date' name='date' type='text' class='form-control' placeholder='Enter Date'>
                <div>
                    @error('projectBidSubmission.date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='amount'>Amount</label>
                <input wire:model='projectBidSubmission.amount' name='amount' type='text' class='form-control' placeholder='Enter Amount'>
                <div>
                    @error('projectBidSubmission.amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='fiscal_year_id'>Fiscal Year Id</label>
                <input wire:model='projectBidSubmission.fiscal_year_id' name='fiscal_year_id' type='text' class='form-control' placeholder='Enter Fiscal Year Id'>
                <div>
                    @error('projectBidSubmission.fiscal_year_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.project_bid_submissions.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
