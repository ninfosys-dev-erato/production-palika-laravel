@props([
    'placeholder' => 'Select date (B.S)',
    'name' => null,
    'label' => '',
    'id' => null,
])

<label class='form-label' for="{{ $id }}">{{ $label }}</label>
<input type="text" name="{{ $name }}" id="{{ $id }}"
    class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" wire:model="{{ $name }}"
    style="{{ $errors->has($name) ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
    placeholder="{{ __('Select Date') }}" />

@error($name)
    <div class="text-danger">{{ $message }}</div>
@enderror

@push('scripts')
    <script>
        const dateInput = $('#{{ $id }}');
        dateInput.nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        });
        dateInput.on('dateSelect', function(e) {
            let selectedDate = $(this).val();
            @this.set('{{ $name }}', selectedDate);
        })
    </script>
@endpush
