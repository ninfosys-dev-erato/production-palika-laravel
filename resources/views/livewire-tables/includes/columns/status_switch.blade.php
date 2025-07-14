<div class="text-center">
    <label class="switch">
        <input type="checkbox" wire:click="toggleStatus({{ $rowId }})" {{ $isActive ? 'checked' : '' }}
        wire:confirm="{{ __('Are you sure you want to change the status?') }}" >
        <span class="slider">
            <span class="slider-before"></span>
        </span>
    </label>
</div>

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 20px;
    }

    .slider-before {
        position: absolute;
        height: 16px; 
        width: 16px;  
        left: 2px;
        bottom: 2px; 
        background-color: white;
        border-radius: 50%;
        transition: 0.4s;
    }

    .switch input:checked + .slider {
        background-color: #4CAF50;
    }

    .switch input:checked + .slider .slider-before {
        transform: translateX(20px);
    }
</style>
