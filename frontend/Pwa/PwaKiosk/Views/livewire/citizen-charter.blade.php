<div class="container my-4">
    <div class="row justify-content-between">
        <div class="col-md-3">
            <h5 class="text-dark">Citizen Charter</h5>

            <div class="btn-group w-100" role="group">
                <button class="btn btn-sm btn-outline-primary" wire:click="isPalika()">
                    {{ __('Palika') }}
                </button>
                <button class="btn btn-sm btn-outline-primary" wire:click="isWard({{$ward}})">
                    {{ __('Ward') }}
                </button>
            </div>


            <div class="mt-4 overflow-auto" style="max-height: 400px;">
                @foreach ($citizenCharters as $charter)
                    <p class="p-2 bg-light rounded user-select-none"
                       style="cursor: pointer;"
                       wire:click="selectCharter({{ $charter->id }})"
                       class="{{ $charter->id === $selectedCharter->id ? 'bg-primary text-white' : 'hover:bg-secondary' }}">
                        {{ $charter->service }}
                    </p>
                @endforeach
            </div>
        </div>

        <div class="col-md-9 bg-light p-4 rounded">
            <h5>{{ $selectedCharter->service }}</h5>
            <div class="d-flex gap-3 mt-2">
                <button class="btn btn-success">{{ $selectedCharter->amount }}</button>
                <div class="bg-white p-2 rounded">{{ __('Time') }}: {{ $selectedCharter->time }}</div>
            </div>
            <div class="mt-3 text-muted">
                {!! nl2br(e($selectedCharter->required_document)) !!}
            </div>
        </div>
    </div>
</div>
