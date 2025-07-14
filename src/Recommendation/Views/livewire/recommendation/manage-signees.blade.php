<div class="div">
    <h5 class="text-primary fw-bold mb-3">{{ __('recommendation::recommendation.signees') }}</h5>
    @foreach ($wardUser as $id => $users)
        <small class="text-light text-black">{{ __('recommendation::recommendation.ward') }} : {{ $id }}</small>
        <div class="row mb-4">
            @foreach ($users as $user)
                <div class="col-md-3">
                    <div class="form-check mt-3 me-3">
                        <input type="checkbox" class="form-check-input"
                            id="department{{ $id }}-{{ $user['id'] }}"
                            wire:click="save('{{ $user['id'] }}','{{ $id }}',$event.target.checked)"
                            {{ in_array($user['id'], $selectedDepartmentUsers[$id] ?? []) ? 'checked' : '' }}>
                        <label class="form-check-label" for="department-{{ $user['name'] }}">
                            {{ $user['name'] . ' (' . $user['mobile_no'] . ')' ?? 'NA' }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
