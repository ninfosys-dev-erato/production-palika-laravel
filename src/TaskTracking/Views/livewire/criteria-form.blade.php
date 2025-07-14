<form wire:submit.prevent="save">
    <div class="card-body">
        <button class="btn btn-success" wire:click="addData" type="button"><i class="bx bx-plus"></i>Add</button>
        <button wire:click="openregan" type="button" class="btn btn-primary" >{{__('tasktracking::tasktracking.add_criteria')}}</button>
        @foreach($criterion as $key => $criteria)
            <div class="row" wire:key="row-{{$key}}"}}>
                <div class='col-md-6'>
                    <div class='form-group'>
                        <label for='name' class='form-label'>{{__('tasktracking::tasktracking.name')}}</label>
                        <input wire:model='criterion.{{$key}}.name' name='name' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_name')}}">
                        <div>
                            @error('criterion.{{$key}}.name')
                            <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div><div class='col-md-6'>
                    <div class='form-group'>
                        <label for='name_en' class='form-label'>{{__('tasktracking::tasktracking.name_en')}}</label>
                        <input wire:model='criterion.{{$key}}.name_en' name='name_en' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_name_en')}}">
                        <div>
                            @error('criterion.{{$key}}.name_en')
                            <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div><div class='col-md-6'>
                    <div class='form-group'>
                        <label for='max_score' class='form-label'>{{__('tasktracking::tasktracking.maximum_score')}}</label>
                        <input wire:model='criterion.{{$key}}.max_score' name='max_score' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_maximum_score')}}">
                        <div>
                            @error('criterion.{{$key}}.max_score')
                            <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div><div class='col-md-6'>
                    <div class='form-group'>
                        <label for='min_score' class='form-label'>{{__('tasktracking::tasktracking.minimum_score')}}</label>
                        <input wire:model='criterion.{{$key}}.min_score' name='min_score' type='text' class='form-control' placeholder="{{__('tasktracking::tasktracking.enter_minimum_score')}}">
                        <div>
                            @error('criterion.{{$key}}.min_score')
                            <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</form>
