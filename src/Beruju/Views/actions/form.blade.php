@extends('layouts.admin')

@section('title', $action === 'create' ? __('beruju::beruju.create_action') : __('beruju::beruju.edit_action'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            {{ $action === 'create' ? __('beruju::beruju.create_action') : __('beruju::beruju.edit_action') }}
                        </h4>
                        <a href="{{ route('admin.beruju.actions.index') }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back"></i> {{ __('beruju::beruju.back_to_list') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @livewire('Beruju::action-form', ['action' => $action, 'berujuAction' => $berujuAction ?? null])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
