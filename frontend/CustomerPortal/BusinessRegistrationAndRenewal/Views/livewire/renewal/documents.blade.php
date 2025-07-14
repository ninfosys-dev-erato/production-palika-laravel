<div class="col-md-12" wire:init="refresh">

    <div class="list-group">
        @foreach ($documents as $key => $document)
            <div class="list-group-item list-group-item-action py-3 px-4 rounded shadow-sm"
                wire:key="doc-{{ $key }}">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Document Name') }}</label>
                            <input type="text" class="form-control"
                                wire:model="documents.{{ $key }}.document_name"
                                placeholder="Enter document name" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Upload Document') }}</label>
                            <input type="file" class="form-control-file"
                                wire:model.defer="documents.{{ $key }}.document">

                            <div wire:loading wire:target="documents.{{ $key }}.document">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Uploading...
                            </div>

                            @if (isset($documents[$key]['url']) && !empty($documents[$key]['url']))
                                <p>
                                    <a href="{{ $documents[$key]['url'] }}" target="_blank">
                                        <i class="bx bx-file"></i> {{ $documents[$key]['document_name'] }}
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3" wire:target="documents.{{ $key }}.document">
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Document Status') }}</label>
                            <select wire:model.defer="documents.{{ $key }}.document_status"
                                id="documents.{{ $key }}.document_status" class="form-control" disabled>
                                @foreach ($options as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select readonly>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group-vertical">
                            <button class="btn btn-primary" wire:click="save({{ $key }})"> <i
                                    class="bx bx-save"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
