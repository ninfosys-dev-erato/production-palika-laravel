<x-layout.app header="{{ __('beruju::beruju.beruju_management') }}">
    <div class="container-fluid">
        <!-- Dashboard Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Quick Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">{{ __('beruju::beruju.quick_actions') }}</h5>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.beruju.registration.create') }}"
                                            class="btn btn-primary w-100">
                                            <i class="fas fa-plus me-2"></i>
                                            {{ __('beruju::beruju.add_beruju') }}
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('admin.beruju.registration.index') }}"
                                            class="btn btn-info w-100">
                                            <i class="fas fa-list me-2"></i>
                                            {{ __('beruju::beruju.view_all_beruju') }}
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="#" class="btn btn-success w-100">
                                            <i class="fas fa-chart-bar me-2"></i>
                                            {{ __('beruju::beruju.beruju_reports') }}
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="#" class="btn btn-warning w-100">
                                            <i class="fas fa-cog me-2"></i>
                                            {{ __('beruju::beruju.beruju_settings') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics Cards -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">0</h4>
                                                <p class="mb-0">{{ __('beruju::beruju.total_beruju') }}</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-file-alt fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">0</h4>
                                                <p class="mb-0">{{ __('beruju::beruju.pending_beruju') }}</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">0</h4>
                                                <p class="mb-0">{{ __('beruju::beruju.resolved_beruju') }}</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-check-circle fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">0</h4>
                                                <p class="mb-0">{{ __('beruju::beruju.rejected_beruju') }}</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-times-circle fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>


@push('styles')
    <style>
        .welcome-message {
            padding: 20px 0;
        }

        .dashboard-icon {
            opacity: 0.8;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 500;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .page-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 5px 0 0 0;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: white;
        }
    </style>
@endpush
