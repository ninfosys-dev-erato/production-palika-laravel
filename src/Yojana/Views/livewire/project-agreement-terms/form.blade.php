<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='projectAgreementTerm.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('projectAgreementTerm.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='data'>Data</label>
                <input wire:model='projectAgreementTerm.data' name='data' type='text' class='form-control' placeholder='Enter Data'>
                <div>
                    @error('projectAgreementTerm.data')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.project_agreement_terms.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
