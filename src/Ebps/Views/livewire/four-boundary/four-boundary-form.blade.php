<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='land_detail_id'>{{__('ebps::ebps.land_detail_id')}}</label>
        <input wire:model='fourBoundary.land_detail_id' name='land_detail_id' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_land_detail_id')}}">
        <div>
            @error('fourBoundary.land_detail_id')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='title'>{{__('ebps::ebps.title')}}</label>
        <input wire:model='fourBoundary.title' name='title' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_title')}}">
        <div>
            @error('fourBoundary.title')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='direction'>{{__('ebps::ebps.direction')}}</label>
        <input wire:model='fourBoundary.direction' name='direction' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_direction')}}">
        <div>
            @error('fourBoundary.direction')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='distance'>{{__('ebps::ebps.distance')}}</label>
        <input wire:model='fourBoundary.distance' name='distance' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_distance')}}">
        <div>
            @error('fourBoundary.distance')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='lot_no'>{{__('ebps::ebps.lot_no')}}</label>
        <input wire:model='fourBoundary.lot_no' name='lot_no' type='text' class='form-control' placeholder="{{__('ebps::ebps.enter_lot_no')}}">
        <div>
            @error('fourBoundary.lot_no')
                <small class='text-danger'>{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('ebps::ebps.save')}}</button>
        <a href="{{route('admin.four_boundaries.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('ebps::ebps.back')}}</a>
    </div>
</form>
