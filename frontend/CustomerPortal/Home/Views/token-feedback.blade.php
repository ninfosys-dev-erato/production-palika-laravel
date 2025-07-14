@extends('home.layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('home') }}/gunasoStyle.css">
    <main class="container">
        <div class="d-flex justify-content-between">
            <p class="title">तपाईंको टोकन नम्बर खोज्न तलका विवरणहरू भर्नुहोस्।ु</p>
        </div>

        <div class="complaints pt-10">
            <livewire:customer_portal.home.token_feedback_form :$action/>
        </div>


    </main>



@endsection

