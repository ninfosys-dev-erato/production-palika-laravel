<x-layout.app header="Activity Log Detail">
    <div class="container">
        <div class="card mb-4 shadow-sm">
            <!-- Main Event Section -->
            <div class="card-header bg-light py-3">
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-primary px-3 py-2">
                        {{ ucwords(str_replace('-', ' ', $log->event)) }}
                    </span>
                    <span class="text-muted">{{ $log->log_name }}</span>
                </div>
            </div>

            <!-- Key Information Grid -->
            <div class="card-body">
                <div class="row g-4">
                    <!-- Name/Subject Section -->
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-file-earmark text-primary"></i>
                            <div>
                                <div class="text-muted small">Subject Type</div>
                                <div class="fw-medium">{{ class_basename($log->subject_type) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Performed By Section -->
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-person text-primary"></i>
                            <div>
                                <div class="text-muted small">Performed By</div>
                                <div class="fw-medium">{{ class_basename($log->causer_type) }}</div>
                                @if ($causer_instance)
                                    @if (isset($causer_instance->name))
                                        <div class="small text-muted">{{ $causer_instance->name }}</div>
                                    @elseif(isset($causer_instance->user_name))
                                        <div class="small text-muted">{{ $causer_instance->user_name }}</div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact Section -->
                    @if ($causer_instance)
                        <div class="col-md-4 col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-envelope text-primary"></i>
                                <div>
                                    <div class="text-muted small">Contact</div>
                                    @if (isset($causer_instance->email))
                                        <div class="small">{{ $causer_instance->email }}</div>
                                    @endif
                                    @if (isset($causer_instance->mobile_no))
                                        <div class="small">{{ $causer_instance->mobile_no }}</div>
                                    @elseif(isset($causer_instance->phone_no))
                                        <div class="small">{{ $causer_instance->phone_no }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Description Section -->
                    <div class="col-12">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <div class="text-muted small">Description</div>
                                <div>{{ $log->description }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Batch ID if exists -->
                    @if ($log->batch_uuid)
                        <div class="col-md-4 col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-hash text-primary"></i>
                                <div>
                                    <div class="text-muted small">Batch ID</div>
                                    <div class="small">{{ $log->batch_uuid }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light py-3">
                <h6 class="mb-0">Change Details</h6>
            </div>

            <div class="card-body">
                @if (isset($properties['attributes']))
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-pencil-square me-2"></i>
                            New Values
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 30%">Field</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($properties['attributes'] as $key => $value)
                                        <tr>
                                            <td class="text-muted">
                                                {{ ucwords(str_replace('_', ' ', $key)) }}
                                            </td>
                                            <td>
                                                @if (is_bool($value))
                                                    <span class="badge bg-{{ $value ? 'success' : 'danger' }}">
                                                        {{ $value ? 'Yes' : 'No' }}
                                                    </span>
                                                @elseif(is_null($value))
                                                    <span class="text-muted">Not Set</span>
                                                @elseif(is_array($value))
                                                    <button class="btn btn-sm btn-outline-primary" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#nested-{{ $key }}">
                                                        View Details
                                                    </button>
                                                    <div class="collapse mt-2" id="nested-{{ $key }}">
                                                        <div class="card card-body bg-light">
                                                            <pre class="mb-0"><code>{{ json_encode($value, JSON_PRETTY_PRINT) }}</code></pre>
                                                        </div>
                                                    </div>
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if (isset($properties['old']))
                        <div>
                            <h6 class="text-secondary mb-3">
                                <i class="bi bi-clock-history me-2"></i>
                                Previous Values
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 30%">Field</th>
                                            <th>Old Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($properties['old'] as $key => $value)
                                            <tr>
                                                <td class="text-muted">
                                                    {{ ucwords(str_replace('_', ' ', $key)) }}
                                                </td>
                                                <td>
                                                    @if (is_bool($value))
                                                        <span class="badge bg-{{ $value ? 'success' : 'danger' }}">
                                                            {{ $value ? 'Yes' : 'No' }}
                                                        </span>
                                                    @elseif(is_null($value))
                                                        <span class="text-muted">Not Set</span>
                                                    @elseif(is_array($value))
                                                        <pre class="mb-0"><code>{{ json_encode($value, JSON_PRETTY_PRINT) }}</code></pre>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 30%">Detail</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($properties as $key => $value)
                                    <tr>
                                        <td class="text-muted">
                                            {{ ucwords(str_replace('_', ' ', $key)) }}
                                        </td>
                                        <td>
                                            @if (is_bool($value))
                                                <span class="badge bg-{{ $value ? 'success' : 'danger' }}">
                                                    {{ $value ? 'Yes' : 'No' }}
                                                </span>
                                            @elseif(is_null($value))
                                                <span class="text-muted">Not Set</span>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.activity_logs.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Logs
            </a>
        </div>
    </div>

</x-layout.app>
