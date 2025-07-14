<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">NID {{__("Verification")}}</h5>
        <small class="text-muted">{{__("Fill the fields below")}}</small>
    </div>

    <div class="card-body">
        <form wire:submit.prevent="submit">
            <div class="mb-3">
                <label for="nin" class="form-label">{{__("National ID (NIN)")}}</label>
                <input type="text" id="nin" wire:model.defer="nin"
                       class="form-control @error('nin') is-invalid @enderror"
                       placeholder="Enter your 10-digit NIN">
                @error('nin') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="fullName" class="form-label">{{__("Full Name")}}</label>
                <input type="text" id="fullName" wire:model.defer="fullName"
                       class="form-control @error('fullName') is-invalid @enderror"
                       placeholder="As per National ID">
                @error('fullName') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">{{__("Gender")}}</label>
                <select id="gender" wire:model.defer="gender"
                        class="form-select @error('gender') is-invalid @enderror">
                    <option value="">{{__("Select Gender")}}</option>
                    <option value="M">{{__("Male")}}</option>
                    <option value="F">{{__("Female")}}</option>
                </select>
                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="dobLoc" class="form-label">{{__("Date of Birth (BS)")}}</label>
                <input type="text" id="dobLoc" wire:model.defer="dobLoc"
                       class="form-control @error('dobLoc') is-invalid @enderror"
                       placeholder="e.g. २०५१-०७-२१">
                @error('dobLoc') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="button" class="btn btn-primary" wire:click="submit">
                {{__("Verify")}}  NID
            </button>
        </form>

        {{-- Verification Result --}}
        @if($verified)
            <div class="alert mt-4 {{ $verificationPassed ? 'alert-success' : 'alert-danger' }}">
                {{ $verificationPassed ? '✅'.__('NID verification successful!') : '❌'.__('NID verification failed.')}}
            </div>
        @endif

        {{-- Exception Message --}}
        @if (session()->has('error'))
            <div class="alert alert-warning mt-2">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
