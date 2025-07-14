<div class="div">
    <h5 class="text-primary fw-bold mb-0">{{ __('grievance::grievance.manage_departments') }}</h5>
    <div class="row mb-4">
        @foreach ($departments as $department)
            <div class="col-md-3">
                <div class="form-check mt-3 me-3">
                    <input type="checkbox" class="form-check-input" id="{{ $department['id'] }}"
                        value="{{ $department['id'] }}" wire:model="selectedDepartments">
                    <label class="form-check-label" for="{{ $department['id'] }}">
                        {{ $department['title'] ?? 'NA' }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>

    <button wire:click="syncDepartments" class="btn btn-primary">{{__('grievance::grievance.save')}}</button>
</div>
