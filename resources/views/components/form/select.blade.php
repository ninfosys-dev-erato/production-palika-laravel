@props([
    'options' => [],
    'multiple' => false,
    'placeholder' => 'Select an option',
    'name' => null,
    'label' => '',
    'wireModel' => null,
    'wireChange' => null,
    'class' => null,
])
<div class="{{ $class ?? 'form-group mb-4' }}">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    <select id="{{ $name }}" name="{{ $name }}" dusk="{{ $name }}"
        class="form-select select2-component @error($name) is-invalid @enderror" {{ $multiple ? 'multiple' : '' }}
        {{ $wireModel ? "wire:model=$wireModel" : '' }} style="width: 100%;">
        @if ($placeholder && !$multiple)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $value => $label)
            <option value="{{ $value }}">{{ ucwords(str_replace('_', ' ', $label)) }}</option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            const selectElement = $('#{{ $name }}');

            const initializeSelect2 = () => {
                selectElement.select2();
                selectElement.on('change', function(e) {
                    @this.set('{{ $wireModel }}', $(this).val());

                    @if ($wireChange)
                        @this.call('{{ $wireChange }}');
                    @endif

                });
            };

            initializeSelect2();
        });
    </script>
@endpush
