<div>
    @if ($fiscalYearId)
        <strong>{{ __('ejalas::ejalas.fiscal_year') }}:</strong> {{ $fiscalYearId }} <br>
    @endif

    @if ($regNo)
        <strong>{{ __('ejalas::ejalas.reg_no') }}:</strong> {{ $regNo }} <br>
    @endif

    @if ($regDate)
        <strong>{{ __('ejalas::ejalas.reg_date') }}:</strong> {{ $regDate }} <br>
    @endif
</div>
