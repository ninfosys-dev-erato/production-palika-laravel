<div class="form">
    @foreach($dynamicFields as $dynamicField)
        <div class="mb-2">
            @if(isset($dynamicField['title']))
                <p>{{$dynamicField['title']}}</p>
            @endif
            @if(isset($dynamicField['fields']))
                @foreach($dynamicField['fields'] as $key=>$field)
                    <button class="btn btn-info btn-sm mb-2" data-bs-copiable="{{$key}}" data-bs-title="{{$field}}" type="button">
                        {{$field}}
                    </button>
                @endforeach
            @endif
        </div>
    @endforeach
    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-md-12">
                <x-form.ck-editor-input
                    label="{{__('settings::settings.template')}}"
                    id="template"
                    name="form.template"
                    :value="$form['template']"
                />
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="styles">{{__('settings::settings.styles')}}</label>
                        <textarea name="styles" id="styles" cols="30" class="form-control" rows="10" wire:model="form.styles">
                        </textarea>
                    </div>

                </div>


            </div>
        </div>

        <div class="mt-2 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('settings::settings.save')}}</button>
        </div>
    </form>
</div>
@once
    @push('scripts')
        <script src="{{ asset('assets/js/copiable.js') }}"></script>
    @endpush
@endonce
