<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='type'>Type</label>
                <input wire:model='planTemplate.type' name='type' type='text' class='form-control' placeholder='Enter Type'>
                <div>
                    @error('planTemplate.type')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='template_for'>Template For</label>
                <input wire:model='planTemplate.template_for' name='template_for' type='text' class='form-control' placeholder='Enter Template For'>
                <div>
                    @error('planTemplate.template_for')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='title'>Title</label>
                <input wire:model='planTemplate.title' name='title' type='text' class='form-control' placeholder='Enter Title'>
                <div>
                    @error('planTemplate.title')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='data'>Data</label>
                <input wire:model='planTemplate.data' name='data' type='text' class='form-control' placeholder='Enter Data'>
                <div>
                    @error('planTemplate.data')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.plan_templates.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
