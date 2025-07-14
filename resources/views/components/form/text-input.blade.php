@props([
    'label' => null,
    'id',
    'name',
    'value' => '',
    'class' => '',
    'placeholder' => '',
    'helper' => '',
    'type' => 'text',
    'min' => null,
    'max' => null,
    'step' => null,
    'pattern' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'autocomplete' => null,
    'isLivewire' => true,
])

<div class="mb-3">
    <div class="form-group">
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
        @if ($required)
            <span class="text-danger">*</span>
        @endif
        <input type="{{ $type }}"
            class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }} {{ $class }}"
            id="{{ $id }}" name="{{ $name }}"
            @if ($isLivewire) wire:model="{{ $name }}" @endif value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}" aria-describedby="{{ $id }}-helper"
            style="{{ $errors->has($name) ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
            @if (isset($min)) min="{{ $min }}" @endif
            @if (isset($max)) max="{{ $max }}" @endif
            @if (isset($step)) step="{{ $step }}" @endif
            @if (isset($pattern)) pattern="{{ $pattern }}" @endif
            @if ($required) required @endif @if ($disabled) disabled @endif
            @if ($readonly) readonly @endif @if ($autofocus) autofocus @endif
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif dusk="{{ $name }}">

        @if ($helper)
            <em id="{{ $id }}-helper" class="form-text ">{{ $helper }}</em> <br>
        @endif

        @error($name)
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
