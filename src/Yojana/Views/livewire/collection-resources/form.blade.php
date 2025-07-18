<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='model_type'>Model Type</label>
                <input wire:model='collectionResource.model_type' name='model_type' type='text' class='form-control' placeholder='Enter Model Type'>
                <div>
                    @error('collectionResource.model_type')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='model_id'>Model Id</label>
                <input wire:model='collectionResource.model_id' name='model_id' type='text' class='form-control' placeholder='Enter Model Id'>
                <div>
                    @error('collectionResource.model_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='collectable'>Collectable</label>
                <input wire:model='collectionResource.collectable' name='collectable' type='text' class='form-control' placeholder='Enter Collectable'>
                <div>
                    @error('collectionResource.collectable')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='type'>Type</label>
                <input wire:model='collectionResource.type' name='type' type='text' class='form-control' placeholder='Enter Type'>
                <div>
                    @error('collectionResource.type')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='quantity'>Quantity</label>
                <input wire:model='collectionResource.quantity' name='quantity' type='text' class='form-control' placeholder='Enter Quantity'>
                <div>
                    @error('collectionResource.quantity')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='rate_type'>Rate Type</label>
                <input wire:model='collectionResource.rate_type' name='rate_type' type='text' class='form-control' placeholder='Enter Rate Type'>
                <div>
                    @error('collectionResource.rate_type')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='rate'>Rate</label>
                <input wire:model='collectionResource.rate' name='rate' type='text' class='form-control' placeholder='Enter Rate'>
                <div>
                    @error('collectionResource.rate')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.collection_resources.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
