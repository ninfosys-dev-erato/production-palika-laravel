@extends('errors::layout')
@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('माफ गर्नुहोस्! धेरै अनुरोधहरू। केही समयपछि पुन: प्रयास गर्नुहोस्।'))
