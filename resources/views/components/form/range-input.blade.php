@props([
    'label' => '',
    'id' => '',
    'name' => '',
    'value' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'class' => '',
    'helper' => '',
    'required' => false,
    'disabled' => false,
    'isLivewire'=>true
])

<div>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input
        type="range"
        id="{{ $id }}"
        @if($isLivewire) wire:model="{{ $name }}" @endif
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        min="{{ $min }}"
        max="{{ $max }}"
        step="{{ $step }}"
        @class(["form-range", $class])
        @if($required) required @endif
        @if($disabled) disabled @endif
        oninput="document.getElementById('{{ $id }}-value').innerText = this.value;"
    >
    <span id="{{ $id }}-value">{{ old($name, $value) }}</span>
    @if($helper)
        <div id="{{ $id }}-helper" class="form-text">{{ $helper }}</div>
    @endif
    @error($name)
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
