<div class="row">
    <div class="col-md-12">
        <div class="card-header text-white">
            <h4 class="align-items-left mb-0">
                <span>{{ __('grievance::grievance.grievance_details_log') }}</span>
            </h4>
        </div>
        <div class="card-body p-0">
            <div class="timeline p-4">
                @if ($groupedLogs->isEmpty())
                    <div>
                        <p class="text-primary"> {{ __('grievance::grievance.no_logs_available') }} </p>
                    </div>
                @else
                    @foreach ($groupedLogs as $date => $logs)
                        <div class="timeline-item position-relative mb-4 pb-4"
                            style="border-left: 2px solid #dee2e6; padding-left: 20px;">
                            <div class="position-absolute"
                                style="left: -8px; top: 0; width: 16px; height: 16px; background-color: #007bff; border-radius: 50%;">
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-dark">
                                    {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="card border shadow-sm bg-light" style="border-radius: 10px;">
                                <div class="card-body">
                                    @foreach ($logs as $log)
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span
                                                    class="text-muted small">{{ $log->created_at->format('h:i A') }}</span>
                                            </div>
                                            @if ($log->old_status !== $log->new_status)
                                                <div class="d-flex align-items-center mb-2">
                                                    <strong class="text">{{ strtoupper(__($log->old_status)) }}</strong>
                                                    <span class="text-muted">→</span>
                                                    <strong class="text">{{ strtoupper(__($log->new_status)) }}</strong>
                                                </div>
                                                @if ($log->new_status == 'investigating')
                                                    <div class="card border-info mb-2" style="max-width">
                                                        <div class="card-header bg-info text-white py-2">
                                                            <i class="bi bi-search"></i>
                                                            {{ __('grievance::grievance.investigation_details') }}
                                                        </div>
                                                        <div class="card-body text-dark p-2">
                                                            @if ($log->grievanceDetail->investigationTypes->isNotEmpty())
                                                                <ul class="list-unstyled mb-0">
                                                                    @foreach ($log->grievanceDetail->investigationTypes as $type)
                                                                        <li>
                                                                            <i
                                                                                class="bi bi-check-circle text-success me-2"></i>
                                                                            {{ app()->getLocale() === 'en' ? $type->title_en : $type->title }}

                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <p class="card-text mb-0 text-muted">
                                                                    {{ __('grievance::grievance.no_investigation_types_associated') }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                            @if ($log->from_user_id !== $log->to_user_id)
                                                <div class="d-flex align-items-center mb-2">
                                                    <strong class="text">{{ $log->fromUser->name }}</strong>
                                                    <span class="text-muted">→</span>
                                                    <strong class="text">{{ $log->toUser->name }}</strong>
                                                </div>
                                                <p class="card-text small mb-1">
                                                    @php
                                                        $locale = App::getLocale();

                                                    @endphp

                                                <p class="card-text small mb-1">
                                                    {{ $locale === 'ne'
                                                        ? 'गुनासो ' . $log->fromUser->name . ' बाट ' . $log->toUser->name . ' लाई तोकिएको छ।'
                                                        : 'Grievance has been assigned from ' . $log->fromUser->name . ' to ' . $log->toUser->name . '.' }}
                                                </p>
                                                <p class="text-danger">{{ __('grievance::grievance.assigned_user_has_been_changed') }}</p>
                                            @endif

                                            @if ($log->suggestions)
                                                <p class="card-text small mb-0">
                                                    <strong>{{ __('grievance::grievance.suggestions') }}:</strong> {{ $log->suggestions }}
                                                </p>
                                            @endif

                                            @if ($log->documents)
                                                <div class="document-list mt-2">
                                                    @foreach ($log->documents as $index => $document)
                                                        @php
                                                            $documentUrl = customAsset(
                                                                config('src.Grievance.grievance.document_path'),
                                                                $document,
                                                                'local',
                                                            );
                                                            $extension = strtolower(
                                                                pathinfo($document, PATHINFO_EXTENSION),
                                                            );
                                                            $documentName = 'Document ' . ($index + 1);
                                                        @endphp
                                                        <div class="document-item d-flex align-items-center mb-2 p-2 border rounded"
                                                            style="background-color: #f8f9fa;">
                                                            @if (in_array($extension, ['png', 'jpeg', 'jpg']))
                                                                <i class="bi bi-image text-primary me-2"></i>
                                                                <a href="{{ $documentUrl }}" target="_blank">
                                                                    <p class="text mb-0">{{ $documentName }}
                                                                        ({{ $extension }})
                                                                    </p>
                                                                </a>
                                                            @elseif ($extension === 'pdf')
                                                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                                <a href="{{ $documentUrl }}" target="_blank">
                                                                    <p class="text mb-0">{{ $documentName }}
                                                                        ({{ $extension }})</p>
                                                                </a>
                                                            @else
                                                                <i class="bi bi-file-earmark text-secondary me-2"></i>
                                                                <p class="text mb-0">{{ $documentName }}
                                                                    ({{ $extension }})</p>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        @if (!$loop->last)
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
