<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-4">
                <label for="local_body_id">{{ __('ebps::ebps.local_body') }}</label>
                <select id="local_body_id" wire:model="customerLandDetail.local_body_id"
                    name="customerLandDetail.local_body_id" class="form-control" wire:change="loadWards">

                    <option value="">{{ __('ebps::ebps.choose_local_body') }}</option>

                    @foreach ($localBodies as $id => $title)
                        <option value="{{ $id }}">{{ $title }}</option>
                    @endforeach
                </select>
                @error('customerLandDetail.local_body_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="col-md-6 mb-4">
                <label for="ward_id">{{ __('ebps::ebps.ward') }}</label>
                <select id="ward_id" name="customerLandDetail.ward" class="form-control"
                    wire:model="customerLandDetail.ward">
                    <option value="">{{ __('ebps::ebps.choose_ward') }}</option>
                    @foreach ($wards as $id => $title)
                        <option value="{{ $title }}">{{ $title }}</option>
                    @endforeach
                </select>
                @error('customerLandDetail.ward')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='tole'>{{ __('ebps::ebps.tole') }}</label>
                    <input wire:model='customerLandDetail.tole' name='tole' type='text' class='form-control'
                        placeholder="{{ __('ebps::ebps.enter_tole') }}">
                    <div>
                        @error('customerLandDetail.tole')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='area_sqm'>{{ __('ebps::ebps.area_sqm') }}</label>
                    <input wire:model='customerLandDetail.area_sqm' name='area_sqm' type='number' class='form-control'
                        placeholder="{{ __('ebps::ebps.enter_area_sqm') }}">
                    <div>
                        @error('customerLandDetail.area_sqm')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='lot_no'>{{ __('ebps::ebps.lot_no') }}</label>
                    <input wire:model='customerLandDetail.lot_no' name='lot_no' type='number' class='form-control'
                        placeholder="{{ __('ebps::ebps.enter_lot_no') }}">
                    <div>
                        @error('customerLandDetail.lot_no')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='seat_no'>{{ __('ebps::ebps.seat_no') }}</label>
                    <input wire:model='customerLandDetail.seat_no' name='seat_no' type='number' class='form-control'
                        placeholder="{{ __('ebps::ebps.enter_seat_no') }}">
                    <div>
                        @error('customerLandDetail.seat_no')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='ownership'>{{ __('ebps::ebps.ownership') }}</label>
                    <select wire:model='customerLandDetail.ownership' name='ownership' class='form-control'>
                        <option value="">{{ __('ebps::ebps.select_ownership') }}</option>
                        @foreach ($ownerships as $ownership)
                            <option value="{{ $ownership->value }}">{{ $ownership->label() }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('customerLandDetail.ownership')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='is_landlord'>{{ __('ebps::ebps.is_landlord') }}</label>
                    <div class="form-check">
                        <input wire:model='customerLandDetail.is_landlord' name='is_landlord' type='checkbox'
                            id="is_landlord" class='form-check-input'>

                    </div>
                    <div>
                        @error('customerLandDetail.is_landlord')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

        <div class=" d-flex justify-content-between mb-4">
            <label class="form-label" for="form-label">{{ __('ebps::ebps.four_boundaries') }}</label>
            <button type="button" class="btn btn-info" wire:click='addFourBoundaries'>
                + {{ __('ebps::ebps.add_four_boundaries') }}
            </button>
        </div>

        @foreach ($fourBoundaries as $index => $boundary)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class='col-md-3'>
                                    <div class='form-group'>
                                        <label for='title'>{{ __('ebps::ebps.title') }}</label>
                                        <input wire:model='fourBoundaries.{{ $index }}.title'
                                            name='fourBoundaries.{{ $index }}.title' type='text'
                                            class='form-control' placeholder="{{ __('ebps::ebps.enter_title') }}">
                                    </div>
                                    <div>
                                        @error('fourBoundaries.{{ $index }}.title')
                                            <small class='text-danger'>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class='col-md-3'>
                                    <div class='form-group'>
                                        <label for='direction'>{{ __('ebps::ebps.direction') }}</label>
                                        <select wire:model='fourBoundaries.{{ $index }}.direction'
                                            name='fourBoundaries.{{ $index }}.direction' class='form-control'>
                                            <option value="">{{ __('ebps::ebps.select_direction') }}</option>
                                            @foreach (\Src\Ebps\Enums\DirectionEnum::cases() as $direction)
                                                <option value="{{ $direction->value }}">{{ $direction->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        @error('fourBoundaries.{{ $index }}.direction')
                                            <small class='text-danger'>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class='col-md-3'>
                                    <div class='form-group'>
                                        <label for='distance'>{{ __('ebps::ebps.distance') }}</label>
                                        <input wire:model='fourBoundaries.{{ $index }}.distance'
                                            name='fourBoundaries.{{ $index }}.distance' type='number'
                                            class='form-control' placeholder="{{ __('ebps::ebps.enter_distance') }}">
                                    </div>
                                    <div>
                                        @error('fourBoundaries.{{ $index }}.distance')
                                            <small class='text-danger'>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class='col-md-3'>
                                    <div class='form-group'>
                                        <label for='lot_no'>{{ __('ebps::ebps.lot_no') }}</label>
                                        <input wire:model='fourBoundaries.{{ $index }}.lot_no'
                                            name='fourBoundaries.{{ $index }}.lot_no' type='text'
                                            class='form-control' placeholder="{{ __('ebps::ebps.enter_lot_no') }}">
                                    </div>
                                    <div>
                                        @error('fourBoundaries.{{ $index }}.lot_no')
                                            <small class='text-danger'>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex justify-content-end align-items-center mb-3">
                            <button type="button" class="btn btn-danger btn-sm"
                                wire:click="removeFourBoundaries({{ $index }})">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('ebps::ebps.save') }}</button>
        <a href="javascript:history.back()" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ebps::ebps.back') }}</a>
    </div>
</form>
