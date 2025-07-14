<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('tasktracking::tasktracking.anusuchi_details') }}</div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='name' class='form-label'>{{ __('tasktracking::tasktracking.name') }}</label>
                    <input wire:model='anusuchi.name' name='name' type='text' class='form-control'
                        placeholder="{{ __('tasktracking::tasktracking.enter_name') }}">
                    <div>
                        @error('anusuchi.name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='name_en' class='form-label'>{{ __('tasktracking::tasktracking.name_english') }}</label>
                    <input wire:model='anusuchi.name_en' name='name_en' type='text' class='form-control'
                        placeholder="{{ __('tasktracking::tasktracking.enter_name_english') }}">
                    <div>
                        @error('anusuchi.name_en')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='description' class='form-label'>{{ __('tasktracking::tasktracking.description') }}</label>
                    <input wire:model='anusuchi.description' name='description' type='text' class='form-control'
                        placeholder="{{ __('tasktracking::tasktracking.enter_description') }}">
                    <div>
                        @error('anusuchi.description')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('tasktracking::tasktracking.manage_criterion_details') }}</div>
            </div>
            <div class="text-end mb-3">
                <button type="button" wire:click="addCriteria" class="btn btn-primary btn-md">
                    {{ __('tasktracking::tasktracking.add_criteria') }}
                </button>
            </div>
            @foreach ($criterion as $key => $criteria)
                <!-- Card for each Criterion -->
                <div class="card mb-3" wire:key="row-{{ $key }}">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-11">
                                <strong>{{ __('tasktracking::tasktracking.criterion') }} #{{ $key + 1 }}</strong>
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeCriterion({{ $key }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Name -->
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label class='form-label'>{{ __('tasktracking::tasktracking.name') }}</label>
                                    <input wire:model='criterion.{{ $key }}.name' type='text'
                                        class='form-control' placeholder="{{ __('tasktracking::tasktracking.enter_name') }}">
                                    @error("criterion.$key.name")
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Name En -->
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label class='form-label'>{{ __('tasktracking::tasktracking.name_en') }}</label>
                                    <input wire:model='criterion.{{ $key }}.name_en' type='text'
                                        class='form-control' placeholder="{{ __('tasktracking::tasktracking.enter_name_en') }}">
                                    @error("criterion.$key.name_en")
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Max Score -->
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label class='form-label'>{{ __('tasktracking::tasktracking.maximum_score') }}</label>
                                    <input wire:model='criterion.{{ $key }}.max_score' type='text'
                                        class='form-control' placeholder="{{ __('tasktracking::tasktracking.enter_maximum_score') }}">
                                    @error("criterion.$key.max_score")
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Min Score -->
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label class='form-label'>{{ __('tasktracking::tasktracking.minimum_score') }}</label>
                                    <input wire:model='criterion.{{ $key }}.min_score' type='text'
                                        class='form-control' placeholder="{{ __('tasktracking::tasktracking.enter_minimum_score') }}">
                                    @error("criterion.$key.min_score")
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('tasktracking::tasktracking.save') }}</button>
            <a href="{{ route('admin.anusuchis.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('tasktracking::tasktracking.back') }}</a>
        </div>
</form>
