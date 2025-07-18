@props([
    'label' => '', // string: Label for the select input
    'id' => '', // string: ID for the select input
    'name' => '', // string: Name for the select input (used in wire:model)
    'options' => [], // array: key-value pairs (key is value, value is the option text)
    'selected' => null, // string|array|null (for single or multiple selection)
    'class' => '', // string: Additional classes for the select
    'helper' => '', // string: Helper text below the select
    'multiple' => false, // boolean: Whether the select allows multiple options
    'required' => false, // boolean: Whether the select is required
    'disabled' => false, // boolean: Whether the select is disabled
    'placeholder' => '', // string: Placeholder text for the select
    'isLivewire' => true, // boolean: Whether this is a Livewire component
    'isLive' => false, // boolean: Whether wire:model.live should be used
    'wireChange' => null, // string: The wire:change action with the dynamic parameter
])

<div>
    {{-- Label --}}
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    {{-- Select Element with Dropdown Icon --}}
    <div class="input-group">
        <select style="width: 100% !important ; height:100%" @class([
            'form-control select2',
            'is-invalid' => $errors->has($name), // Highlight with `is-invalid` if there's an error
            $class,
        ]) {{-- Add the `select2` class --}}
            id="{{ $id }}"
            @if ($isLivewire) @if (!$isLive)
                    wire:model="{{ $name }}"
                @else
                    wire:model.live="{{ $name }}" @endif
            @endif
            @if ($wireChange) wire:change="{{ $wireChange }}" @endif
            name="{{ $name }}{{ $multiple ? '[]' : '' }}" {{-- for multiple select --}}
            aria-describedby="{{ $id }}-helper"
            @if ($multiple) multiple @endif
            @if ($required) required @endif
            @if ($disabled) disabled @endif
            dusk="{{ $name }}"
            >
            {{-- Placeholder --}}
            @if ($placeholder && !$multiple)
                <option value="">{{ $placeholder }}</option>
            @endif

            {{-- Options --}}
            @foreach ($options as $key => $option)
                <option value="{{ $key }}" @if (
                    $multiple && is_array(old($name, $selected))
                        ? in_array($key, old($name, $selected))
                        : old($name, $selected) == $key) selected @endif>
                    {{ $option }}
                </option>
            @endforeach
            <span class="input-group-text">
                <i class="bi bi-caret-down">▼</i>
            </span>
        </select>

    </div>

    {{-- Helper Text --}}
    @if ($helper)
        <div id="{{ $id }}-helper" class="form-text">{{ $helper }}</div>
    @endif

    {{-- Validation Error --}}
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

@once
    @push('styles')
        {{-- Include Select2 CSS --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('scripts')
        {{-- Include Select2 JS --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectElement = $('.select2');

                selectElement.select2({
                    placeholder: "{{ $placeholder }}",
                    width: 'resolve'
                });

                selectElement.on('change', function(e) {
                    const value = $(this).val();
                    const name = '{{ $name }}';
                    @this.set(name, value);

                    @if ($wireChange)

                        @this.call('{{ $wireChange }}');
                    @endif
                });
            });
        </script>
    @endpush
@endonce
