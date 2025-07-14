@extends('digitalBoard.layout')
@section('content')
    <div class="main my-2 md:my-6">
        <livewire:customer_portal.digital_board.notice_detail :notice="$notice">
    </div>
@endsection
