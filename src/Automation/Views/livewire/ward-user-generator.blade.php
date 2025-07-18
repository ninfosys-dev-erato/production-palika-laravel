<form>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header text-white text-center rounded-top-4">
                        <h4 class="mb-0">Generate Wards</h4>
                    </div>

                    <div class="d-grid">
                        <a wire:click='generateWards' class="btn btn-success btn-lg">
                            <i class="fas fa-users me-2"></i>Generate Wards
                        </a>
                    </div>

                </div>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white text-center rounded-top-4">
                    <h4 class="mb-0">Generate Ward Users</h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label for="palika" class="form-label fw-bold">Palika Name</label>
                        <input type="text" class="form-control form-control-lg" id="palika" wire:model="palika"
                            name="palika" placeholder="e.g. Baijannath" required>
                    </div>

                    <div class="mb-4">
                        <label for="count" class="form-label fw-bold">Number of Wards</label>
                        <input type="number" class="form-control form-control-lg"wire:model="count" id="count"
                            name="count" placeholder="e.g. 9" required>
                    </div>


                    <div class="mb-4">
                        <label for="role" class="form-label fw-bold">Select Role</label>
                        <select wire:model="role_id" id="role" class="form-select form-select-lg" required>
                            <option value="">-- Choose a Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>



                    <div class="d-grid">
                        <button wire:click='generateUsers' class="btn btn-success btn-lg">
                            <i class="fas fa-users me-2"></i>Generate Users
                        </button>
                    </div>

                </div>
            </div>
            <br>

        </div>
    </div>
    </div>
</form>
