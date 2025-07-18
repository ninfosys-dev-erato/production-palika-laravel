<div class="p-3">
    <div class="mb-2">
        <span class="fw-bold text-dark">{{__('digitalboard::digitalboard.service')}}:</span>
        <span class="text-primary fw-semibold">{{ $service }}</span>
    </div>
    <div class="mb-2">
        <span class="fw-bold text-dark">{{__('digitalboard::digitalboard.amount')}}:</span>
        <span class="text-success fw-semibold"> {{ $amount }}</span>
    </div>
    <div class="mb-2">
        <span class="fw-bold text-dark">{{__('digitalboard::digitalboard.time')}}:</span>
        <span class="text-info fw-semibold">{{ $time }}</span>
    </div>
    <div class="mb-2">
        <span class="fw-bold text-dark">{{__('digitalboard::digitalboard.wards')}}:</span>
        <span class="text-warning fw-semibold">{{ replaceNumbersWithLocale($wards, true) }}</span>
    </div>
</div>
