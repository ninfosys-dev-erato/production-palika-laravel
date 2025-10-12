<div>
    <form wire:submit.prevent="uploadDocument" enctype="multipart/form-data" class="space-y-4">
        <div class="d-flex align-items-end border rounded p-3 mb-3 gap-3 flex-wrap">
            <!-- Document Name -->
            <div class="flex-grow-1">
                <label class="form-label fw-bold">{{ __('Document Name') }}</label>
                <input type="text" class="form-control" wire:model.defer="documentName"
                    placeholder="Enter document name">
                @error('documentName')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Upload File -->
            <div class="flex-grow-1">
                <label class="form-label fw-bold">{{ __('Upload File') }}</label>
                <input type="file" wire:model.defer="documentFile" accept="image/*,.pdf"
                    class="form-control @error('documentFile') is-invalid @enderror">
                <div wire:loading wire:target="documentFile">
                    <span class="spinner-border spinner-border-sm"></span> Uploading...
                </div>
                @error('documentFile')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Upload Button -->
            <div>
                <button type="submit" class="btn btn-primary mt-3">
                    <i class="bx bx-upload"></i> {{ __('Upload') }}
                </button>
            </div>
        </div>
    </form>


    {{-- Table of uploaded documents --}}
    @if ($uploadedDocuments && count($uploadedDocuments) > 0)
        <div class="table-responsive mt-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('Document Name') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($uploadedDocuments as $index => $doc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $doc['name'] }}</td>
                            <td>
                                <a href="{{ $doc['url'] }}" target="_blank" class="btn btn-outline-primary btn-sm me">
                                    <i class="bx bx-file"></i> {{ __('View') }}
                                </a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    wire:click="deleteDocument({{ $index }})">
                                    <i class="bx bx-trash"></i> {{ __('Delete') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@push('styles')
    <style>
        .form-label {
            font-weight: 600;
            color: #333;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
@endpush
