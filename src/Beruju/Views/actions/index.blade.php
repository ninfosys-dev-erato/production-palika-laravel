@extends('layouts.admin')

@section('title', __('beruju::beruju.actions'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ __('beruju::beruju.actions') }}</h4>
                        @can('beruju create')
                        <a href="{{ route('admin.beruju.actions.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> {{ __('beruju::beruju.create_action') }}
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    @livewire('Beruju::action-table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
