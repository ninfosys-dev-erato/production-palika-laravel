<?php

use Illuminate\Support\Facades\Cache;

$wards = Cache::remember("user_wards_" . auth()->id(), 60, function () {
    return auth()->user()->userWards()->get();
});
?>
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @if($wards->count() > 0)
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{__('Ward').' : '.session()->get('ward')}}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                @foreach($wards as $ward)
                    <li><a class="dropdown-item" wire:click="changeWard({{$ward->ward}})" href="#">{{__('Ward') .' '.$ward->ward}}</a></li>
                @endforeach
            </ul>
        </li>
        @else
        <li class="nav-item">
            <a class="nav-link disabled" href="javascript:void(0)" tabindex="-1">{{__("No Ward Selected")}}</a>
        </li>
        @endif
</ul>

@script
<script>
    $wire.on('ward-change', () => {
        window.location.reload();
    });
</script>
@endscript