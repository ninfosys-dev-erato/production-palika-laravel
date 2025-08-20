@extends('layouts.admin')

@section('title', __('beruju::beruju.action_details'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ __('beruju::beruju.action_details') }}</h4>
                        <div>
                            @can('beruju edit')
                            <a href="{{ route('admin.beruju.actions.edit', $berujuAction->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> {{ __('beruju::beruju.edit') }}
                            </a>
                            @endcan
                            <a href="{{ route('admin.beruju.actions.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> {{ __('beruju::beruju.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">{{ __('beruju::beruju.resolution_cycle') }}:</th>
                                    <td>{{ $berujuAction->resolutionCycle ? 'Cycle #' . $berujuAction->resolutionCycle->id : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.action_type') }}:</th>
                                    <td>{{ $berujuAction->actionType ? $berujuAction->actionType->name_eng : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.status') }}:</th>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'Pending' => 'warning',
                                                'Completed' => 'success',
                                                'Rejected' => 'danger'
                                            ];
                                            $color = $statusColors[$berujuAction->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ $berujuAction->status }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.resolved_amount') }}:</th>
                                    <td>{{ $berujuAction->resolved_amount ? number_format($berujuAction->resolved_amount, 2) : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">{{ __('beruju::beruju.created_by') }}:</th>
                                    <td>{{ $berujuAction->creator ? $berujuAction->creator->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.created_at') }}:</th>
                                    <td>{{ $berujuAction->created_at ? $berujuAction->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.updated_at') }}:</th>
                                    <td>{{ $berujuAction->updated_at ? $berujuAction->updated_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($berujuAction->remarks)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>{{ __('beruju::beruju.remarks') }}:</h6>
                            <p class="text-muted">{{ $berujuAction->remarks }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
