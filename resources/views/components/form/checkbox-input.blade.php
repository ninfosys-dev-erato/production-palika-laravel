@props([
    'label' => '', // string
    'id' => '', // string
    'name' => '', // string
    'options' => [], // array: key-value pairs (key is value, value is the label text)
    'checked' => [], // array (for multiple checkboxes)
    'class' => '', // string
    'helper' => '', // string
    'required' => false, // boolean
    'disabled' => false, // boolean
    'isLivewire'=>true
])

<div>
    <p class="form-label">{{ $label }}</p>

    @foreach($options as $key => $option)
        <div class="form-check">
            <input
                type="checkbox"
                id="{{ $id . '-' . $key }}"
                name="{{ $name }}[]"
                value="{{ $key }}"
                @if($isLivewire) wire:model="{{ $name }}" @endif
                    dusk="{{$name}}"
                @class(["form-check-input", $class])
                @if(is_array(old($name, $checked)) && in_array($key, old($name, $checked))) checked @endif
                @if($required) required @endif
                @if($disabled) disabled @endif
            >
            <label for="{{ $id . '-' . $key }}" class="form-check-label">{{ $option }}</label>
        </div>
    @endforeach

    @if($helper)
        <div id="{{ $id }}-helper" class="form-text">{{ $helper }}</div>
    @endif

    @error($name)
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
