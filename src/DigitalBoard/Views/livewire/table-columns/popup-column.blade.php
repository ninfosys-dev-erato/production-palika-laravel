<div class="p-3">
    <div class="mb-2">
        <span class="fw-bold text-dark">{{__('digitalboard::digitalboard.title')}}:</span>
        <span class="text-primary fw-semibold">{{ $title }}</span>
    </div>
    <div class="mb-2">
        <span class="fw-bold text-dark">{{__('digitalboard::digitalboard.display_duration')}}:</span>
        <span class="text-primary fw-semibold">{{ replaceNumbersWithLocale($displayDuration, true) }} {{__('digitalboard::digitalboard.sec')}}</span>
    </div>
    <div class="mb-2">
        <span class="fw-bold text-dark">{{__('digitalboard::digitalboard.iteration_duration')}}:</span>
        <span class="text-primary fw-semibold">{{ replaceNumbersWithLocale($iterationDuration, true) }} {{__('digitalboard::digitalboard.sec')}}</span>
    </div>
    <div class="mb-2">
        <span class="fw-bold text-dark">{{__('digitalboard::digitalboard.wards')}}:</span>
        <span class="text-primary fw-semibold">{{ replaceNumbersWithLocale($wards, true) }}</span>
    </div>
</div>
