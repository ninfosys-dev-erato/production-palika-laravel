<div class="div">
    <div class="row mb-4">
        @foreach ($departments as $department)
            <div class="col-md-3">
                <div class="form-check mt-3 me-3">
                    <input type="checkbox" class="form-check-input" id="dept_{{ $department['id'] }}"
                        value="{{ $department['id'] }}" wire:model="selectedDepartments">
                    <label class="form-check-label" for="dept_{{ $department['id'] }}">
                        {{ $department['title'] ?? 'NA' }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>