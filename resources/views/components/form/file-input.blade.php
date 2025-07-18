@props([
    'label',
    'id',
    'name',
    'class' => '',
    'helper' => '',
    'required' => false,
    'disabled' => false,
    'multiple' => false,
    'accept' => '',
    'isLivewire' => true,
    'dusk' => null,
])

<div>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    <input type="file" @class(['form-control', $class]) id="{{ $id }}"
        @if ($isLivewire) wire:model="{{ $name }}" @endif
        name="{{ $name }}{{ $multiple ? '[]' : '' }}" aria-describedby="{{ $id }}-helper"
        @if ($required) required @endif @if ($disabled) disabled @endif
        @if ($multiple) multiple @endif
        @if ($accept) accept="{{ $accept }}" @endif
        @if ($dusk) dusk="{{ $dusk }}" @endif>

    @if ($helper)
        <div id="{{ $id }}-helper" class="form-text">{{ $helper }}</div>
    @endif

    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror

</div>
