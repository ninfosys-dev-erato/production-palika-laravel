<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='projectDocument.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('projectDocument.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='document_name'>Document Name</label>
                <input wire:model='projectDocument.document_name' name='document_name' type='text' class='form-control' placeholder='Enter Document Name'>
                <div>
                    @error('projectDocument.document_name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='data'>Data</label>
                <input wire:model='projectDocument.data' name='data' type='text' class='form-control' placeholder='Enter Data'>
                <div>
                    @error('projectDocument.data')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.project_documents.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
