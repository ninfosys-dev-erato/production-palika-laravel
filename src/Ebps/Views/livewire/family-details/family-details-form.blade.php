<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='customer_id'>{{__('ebps::ebps.customer_id')}}</label>
        <input wire:model='customerFamilyDetail.customer_id' name='customer_id' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_customer_id')}}">
        <div>
            @error('customerFamilyDetail.customer_id')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='father_name'>{{__('ebps::ebps.father_name')}}</label>
        <input wire:model='customerFamilyDetail.father_name' name='father_name' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_father_name')}}">
        <div>
            @error('customerFamilyDetail.father_name')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='mother_name'>{{__('ebps::ebps.mother_name')}}</label>
        <input wire:model='customerFamilyDetail.mother_name' name='mother_name' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_mother_name')}}">
        <div>
            @error('customerFamilyDetail.mother_name')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='grandfather_name'>{{__('ebps::ebps.grandfather_name')}}</label>
        <input wire:model='customerFamilyDetail.grandfather_name' name='grandfather_name' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_grandfather_name')}}">
        <div>
            @error('customerFamilyDetail.grandfather_name')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='grandmother_name'>{{__('ebps::ebps.grandmother_name')}}</label>
        <input wire:model='customerFamilyDetail.grandmother_name' name='grandmother_name' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_grandmother_name')}}">
        <div>
            @error('customerFamilyDetail.grandmother_name')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='great_grandfather_name'>{{__('ebps::ebps.great_grandfather_name')}}</label>
        <input wire:model='customerFamilyDetail.great_grandfather_name' name='great_grandfather_name' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_great_grandfather_name')}}">
        <div>
            @error('customerFamilyDetail.great_grandfather_name')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('ebps::ebps.save')}}</button>
        <a href="{{route('admin.customer_family_details.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('ebps::ebps.back')}}</a>
    </div>
</form>
