<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='ebps_document_id'>Ebps Document</label>
                    <select wire:model='mapImportantDocument.ebps_document_id' name='ebps_document_id'
                        class="form-select {{ $errors->has('mapImportantDocument.ebps_document_id') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('mapImportantDocument.ebps_document_id') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                        <option value="" selected hidden>{{ __('ebps::ebps.select_ebps_document') }}</option>
                        @foreach ($ebpsDocument as $document)
                            <option value="{{ $document->id }}">{{ $document->title }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('mapImportantDocument.ebps_document_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='map_important_document_type'>Map Important Document Type</label>
                    <input wire:model='mapImportantDocument.map_important_document_type'
                        name='map_important_document_type' type='text' class='form-control'
                        placeholder='Enter Map Important Document Type'>
                    <div>
                        @error('mapImportantDocument.map_important_document_type')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='accepted_file_type'>Accepted File Type</label>
                    <input wire:model='mapImportantDocument.accepted_file_type' name='accepted_file_type' type='text'
                        class='form-control' placeholder='Enter Accepted File Type'>
                    <div>
                        @error('mapImportantDocument.accepted_file_type')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='position'>Position</label>
                    <input wire:model='mapImportantDocument.position' name='position' type='text'
                        class='form-control' placeholder='Enter Position'>
                    <div>
                        @error('mapImportantDocument.position')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class="form-group">
                    <div class="form-check mt-2">

                        <input class="form-check-input" type="checkbox" id="can_be_null" wire:model="canBeNull"
                            @if ($canBeNull) checked @endif>
                        <label class="form-check-label" for="can_be_null" style="font-size: 0.95rem;">
                            {{ __('ebps::ebps.can_be_null') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class="form-group">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="needs_approval" wire:model="needsApproval"
                            @if ($needsApproval) checked @endif>
                        <label class="form-check-label" for="needs_approval" style="font-size: 0.95rem;">
                            {{ __('ebps::ebps.needs_approval') }}
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{ route('admin.ebps.map_important_documents.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">Back</a>
    </div>
</form>
