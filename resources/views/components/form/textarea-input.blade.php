@props([
    'label' => '',
    'id' => '',
    'name' => '',
    'value' => '',
    'class' => '',
    'helper' => '',
    'rows' => 4,
    'required' => false,
    'disabled' => false,
    'isLivewire' => true,
])

<div class="mb-4">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea id="{{ $id }}" name="{{ $name }}" dusk="{{ $name }}" @class(['form-control', 'is-invalid' => $errors->has($name), $class])
        rows="{{ $rows }}" @if ($isLivewire) wire:model="{{ $name }}" @endif
        @if ($required) required @endif @if ($disabled) disabled @endif>{{ old($name, $value) }}</textarea>
    @if ($helper)
        <div id="{{ $id }}-helper" class="form-text">{{ $helper }}</div>
    @endif
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
