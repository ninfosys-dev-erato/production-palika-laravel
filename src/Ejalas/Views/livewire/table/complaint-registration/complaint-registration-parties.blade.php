<div>
    @if ($defenders && count($defenders) > 0)
        @foreach ($defenders as $defender)
            <strong>{{ __('ejalas::ejalas.defender') }}:</strong> {{ $defender }} <br>
        @endforeach
    @else
        <strong>{{ __('ejalas::ejalas.defender') }}:</strong> {{ __('ejalas::ejalas.na') }}
    @endif
    <hr class="my-1">
    @if ($complainers && count($complainers) > 0)
        @foreach ($complainers as $complainer)
            <strong>{{ __('ejalas::ejalas.complainer') }}:</strong> {{ $complainer }} <br>
        @endforeach
    @else
        <strong>{{ __('ejalas::ejalas.complainer') }}:</strong> {{ __('ejalas::ejalas.na') }}
    @endif
</div>
