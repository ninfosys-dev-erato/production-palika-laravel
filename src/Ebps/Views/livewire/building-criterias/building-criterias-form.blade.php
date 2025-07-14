<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='min_gcr'>{{__('ebps::ebps.min')}} Gcr</label>
                    <input wire:model='buildingCriteria.min_gcr' name='min_gcr' type='text'
                        class="form-control {{ $errors->has('buildingCriteria.min_gcr') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('buildingCriteria.min_gcr') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='Enter Min Gcr'>
                    <div>
                        @error('buildingCriteria.min_gcr')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='min_far'>{{__('ebps::ebps.min')}} Far</label>
                    <input wire:model='buildingCriteria.min_far' name='min_far' type='text'
                        class="form-control {{ $errors->has('buildingCriteria.min_far') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('buildingCriteria.min_far') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='Enter Min Far'>
                    <div>
                        @error('buildingCriteria.min_far')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='min_dist_center'>Min Dist Center</label>
                    <input wire:model='buildingCriteria.min_dist_center' name='min_dist_center' type='text'
                        class="form-control {{ $errors->has('buildingCriteria.min_dist_center') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('buildingCriteria.min_dist_center') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='Enter Min Dist Center'>
                    <div>
                        @error('buildingCriteria.min_dist_center')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='min_dist_side'>Min Dist Side</label>
                    <input wire:model='buildingCriteria.min_dist_side' name='min_dist_side' type='text'
                        class="form-control {{ $errors->has('buildingCriteria.min_dist_side') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('buildingCriteria.min_dist_side') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='Enter Min Dist Side'>
                    <div>
                        @error('buildingCriteria.min_dist_side')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='min_dist_right'>Min Dist Right</label>
                    <input wire:model='buildingCriteria.min_dist_right' name='min_dist_right' type='text'
                        class="form-control {{ $errors->has('buildingCriteria.min_dist_right') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('buildingCriteria.min_dist_right') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='Enter Min Dist Right'>
                    <div>
                        @error('buildingCriteria.min_dist_right')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='setback'>Setback</label>
                    <input wire:model='buildingCriteria.setback' name='setback' type='text'
                        class="form-control {{ $errors->has('buildingCriteria.setback') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('buildingCriteria.setback') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='Enter Setback'>
                    <div>
                        @error('buildingCriteria.setback')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='dist_between_wall_and_boundaries'>Dist Between Wall And
                        Boundaries</label>
                    <input wire:model='buildingCriteria.dist_between_wall_and_boundaries'
                        name='dist_between_wall_and_boundaries' type='text'
                        class="form-control {{ $errors->has('buildingCriteria.dist_between_wall_and_boundaries') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('buildingCriteria.dist_between_wall_and_boundaries') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='Enter Dist Between Wall And Boundaries'>
                    <div>
                        @error('buildingCriteria.dist_between_wall_and_boundaries')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='public_place_distance'>Public Place Distance</label>
                    <input wire:model='buildingCriteria.public_place_distance' name='public_place_distance'
                        type='text'
                        class="form-control {{ $errors->has('buildingCriteria.public_place_distance') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('buildingCriteria.public_place_distance') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='Enter Public Place Distance'>
                    <div>
                        @error('buildingCriteria.public_place_distance')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='cantilever_distance'>Cantilever Distance</label>
                    <input wire:model='buildingCriteria.cantilever_distance' name='cantilever_distance' type='text'
                        class="form-control {{ $errors->has('buildingCriteria.cantilever_distance') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('buildingCriteria.cantilever_distance') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='Enter Cantilever Distance'>
                    <div>
                        @error('buildingCriteria.cantilever_distance')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='high_tension_distance'>High Tension Distance</label>
                    <input wire:model='buildingCriteria.high_tension_distance' name='high_tension_distance'
                        type='text'
                        class="form-control {{ $errors->has('buildingCriteria.high_tension_distance') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('buildingCriteria.high_tension_distance') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder='Enter High Tension Distance'>
                    <div>
                        @error('buildingCriteria.high_tension_distance')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class="form-group">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="is_active" wire:model="isActive"
                            @if ($isActive) checked @endif>
                        <label class="form-check-label" for="is_active" style="font-size: 0.95rem;">
                            {{ __('ebps::ebps.is_active') }}
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('ebps::ebps.save')}}</button>
        <a href="{{ route('admin.ebps.building_criterias.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{__('ebps::ebps.back')}}</a>
    </div>
</form>
