@extends('digitalBoard.layout')
@section('content')
    <div class="main my-3 md:my-[32px]">
        <livewire:customer_portal.digital_board.program_detail :program="$program">
    </div>
@endsection

