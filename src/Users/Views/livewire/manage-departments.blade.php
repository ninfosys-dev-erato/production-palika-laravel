<div>
    <h5 class="text-primary fw-bold mb-0">{{ __('users::users.assigned_departments') }}</h5>

    <form wire:submit.prevent="saveDepartments">
        <div class="table-responsive card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('users::users.assigned_departments') }}</th>
                        <th>{{ __('users::users.is_hod') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $index => $department)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0">{{ $department['title'] }}</p>
                                    <input type="checkbox" wire:model.live="selectedDepartments"
                                        value="{{ $department['id'] }}" class="form-check-input ms-2">
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input type="checkbox" wire:model="departmentHeads.{{ $department['id'] }}"
                                        class="form-check-input"
                                        {{ in_array($department['id'], $selectedDepartments) ? '' : 'disabled' }}>
                                    <label class="form-check-label"></label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($errors->has('department_head'))
                <div class="alert alert-danger">
                    {{ $errors->first('department_head') }}
                </div>
            @endif
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-danger">Cancel</a>
        </div>
    </form>
</div>
