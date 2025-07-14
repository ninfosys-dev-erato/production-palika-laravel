@extends('digitalBoard.layout')
@section('content')
    <div class="main my-[32px]">
        <livewire:customer_portal.digital_board.citizen_charter_detail :charter="$charter">
    </div>
@endsection

