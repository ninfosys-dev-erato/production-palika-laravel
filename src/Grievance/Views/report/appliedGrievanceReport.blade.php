<x-layout.app header="{{ __('grievance::grievance.received_grievance_report') }}">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="text-primary mb-0">{{ __('grievance::grievance.received_grievance_report') }}</h4>
                <div class="d-flex gap-2 ms-auto">
                    <a href="{{ route('admin.grievance.grievanceDetail.export', array_merge(request()->query(), ['type' => 'report'])) }}"
                        class="btn btn-outline-primary btn-sm">
                        {{ __('grievance::grievance.export') }}
                    </a>
                    <a href="{{ route('admin.grievance.download-pdf', array_merge(request()->query(), ['type' => 'report'])) }}"
                        class="btn btn-outline-primary btn-sm">
                        {{ __('grievance::grievance.pdf') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.grievance.grievanceDetail.appliedGrievaceReport') }}"
                    class="row g-3">
                    <div class="col-md-2">
                        <label for="search" class="form-label">{{ __('grievance::grievance.search') }}</label>
                        <input dusk="grievance-search-field" type="text" name="search" id="search" class="form-control"
                            placeholder="{{ __('grievance::grievance.search') }}" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-1">
                        <label for="filter_status" class="form-label">{{ __('grievance::grievance.status') }}</label>
                        <select dusk="grievance-filter_status-field" name="filter_status" id="filter_status" class="form-select">
                            <option value="">{{ __('grievance::grievance.all') }}</option>
                            <option value="unseen" {{ request('filter_status') == 'unseen' ? 'selected' : '' }}>
                                {{ __('grievance::grievance.unseen') }}
                            </option>
                            <option value="investigating"
                                {{ request('filter_status') == 'investigating' ? 'selected' : '' }}>
                                {{ __('grievance::grievance.investigating') }}
                            </option>
                            <option value="replied" {{ request('filter_status') == 'replied' ? 'selected' : '' }}>
                                {{ __('grievance::grievance.replied') }}</option>
                            <option value="closed" {{ request('filter_status') == 'closed' ? 'selected' : '' }}>
                                {{ __('grievance::grievance.closed') }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label for="filter_priority" class="form-label">{{ __('grievance::grievance.priority') }}</label>
                        <select dusk="grievance-filter_priority-field" name="filter_priority" id="filter_priority" class="form-select">
                            <option value="">{{ __('grievance::grievance.all') }}</option>
                            <option value="low" {{ request('filter_priority') == 'low' ? 'selected' : '' }}>
                                {{ __('grievance::grievance.low') }}
                            </option>
                            <option value="medium" {{ request('filter_priority') == 'medium' ? 'selected' : '' }}>
                                {{ __('grievance::grievance.medium') }}
                            </option>
                            <option value="high" {{ request('filter_priority') == 'high' ? 'selected' : '' }}>
                                {{ __('grievance::grievance.high') }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="start_date" class="form-label">{{ __('grievance::grievance.start_date') }}</label>
                        <input dusk="grievance-start_date-field" type="text" name="start_date" id="start_date" class="form-control nepali-date"
                            value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="end_date" class="form-label">{{ __('grievance::grievance.end_date') }}</label>
                        <input dusk="grievance-end_date-field" type="text" name="end_date" id="end_date" class="form-control nepali-date"
                            value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-2 align-self-end">
                        <button type="submit" class="btn btn-primary w-100">{{ __('grievance::grievance.filter') }}</button>
                    </div>

                    <div class="col-md-2 align-self-end">
                        <button type="button" id="clear-filters"
                            class="btn btn-secondary w-100">{{ __('grievance::grievance.clear') }}</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>{{ __('grievance::grievance.customer') }}</th>
                                <th>{{ __('grievance::grievance.grievance_description') }}</th>
                                <th>{{ __('grievance::grievance.subject') }}</th>
                                <th>{{ __('grievance::grievance.suggestions') }}</th>
                                <th>{{ __('grievance::grievance.token_no') }}</th>
                                <th>{{ __('grievance::grievance.created_date') }}</th>
                                <th>{{ __('grievance::grievance.grievance_medium') }}</th>
                                {{-- <th>{{ __('grievance::grievance.action') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>
                                        @include('Grievance::livewire.table.common-customer', [
                                            'row' => $report->customer,
                                        ])
                                    </td>
                                    <td>{{ $report->description }}</td>
                                    <td>{{ $report->subject }}</td>

                                    <td>{{ $report->suggestions }}</td>
                                    <td>{{ $report->token }}</td>
                                    <td>{{ \Carbon\Carbon::parse($report->created_at)->toFormattedDateString() }}</td>
                                    <td>{{ __(Src\Grievance\Enums\GrievanceMediumEnum::from($report->grievance_medium->value)->label()) }}
                                    </td>
                                    {{-- <td>
                                        <a href="{{ route('admin.grievance.grievanceDetail.show', $report->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </td> --}}

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('grievance::grievance.no_records_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Pagination -->

            <div class="pagination-container mt-3">
                <ul class="pagination pagination-lg">
                    {{ $reports->links('pagination::bootstrap-4') }}
                </ul>
            </div>

        </div>
    </div>
</x-layout.app>
