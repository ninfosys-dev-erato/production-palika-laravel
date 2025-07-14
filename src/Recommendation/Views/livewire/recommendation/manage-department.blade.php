<div class="div">
    <h5 class="text-primary fw-bold mb-0">{{ __('recommendation::recommendation.manage_departments') }}</h5>
    <div class="row mb-4">
        @foreach ($departments as $label => $id)
            <div class="col-md-3">
                <div class="form-check mt-3 me-3">
                    <input dusk="recommendation-department-{{ $id }}-field" type="checkbox" class="form-check-input" id="department-{{ $id }}"
                        value="{{ $id }}" wire:model="selectedDepartments">
                    <label class="form-check-label" for="department-{{ $label }}">
                        {{ $label ?? 'NA' }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>

    <button wire:click="save" class="btn btn-primary">{{__('recommendation::recommendation.save')}}</button>
</div>
