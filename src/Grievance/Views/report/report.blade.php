<x-layout.app header="{{ __('grievance::grievance.grievance_report') }}">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="text-primary mb-0">{{ __('grievance::grievance.grievance_report') }}</h4>
                <div class="d-flex gap-2 ms-auto">
                    <a href="{{ route('admin.grievance.grievanceDetail.export', array_merge(request()->query(), ['type' => 'report'])) }}"
                        class="btn btn-outline-primary btn-sm" target="_blank">
                        {{ __('grievance::grievance.export') }}
                    </a>
                    <a href="{{ route('admin.grievance.download-pdf', array_merge(request()->query(), ['type' => 'report'])) }}"
                        class="btn btn-outline-primary btn-sm" target="_blank">
                        {{ __('grievance::grievance.pdf') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.grievance.grievanceDetail.report') }}" class="row g-3">
                    <div class="col-md-3">
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

                    <div class="col-md-1">
                        <label for="filter_ward" class="form-label">{{ __('grievance::grievance.ward') }}</label>
                        <select dusk="grievance-filter_ward-field" name="filter_ward" id="filter_ward" class="form-select">
                            <option value="" hidden>{{ __('grievance::grievance.ward') }}</option>
                            @foreach ($wards as $ward)
                                <option value="{{ $ward }}"
                                    {{ request('filter_ward') == $ward ? 'selected' : '' }}>
                                    {{ $ward }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label for="filter_year" class="form-label">{{ __('grievance::grievance.fiscal_year') }}</label>
                        <select dusk="grievance-filter_year-field" name="filter_year" id="filter_year" class="form-select">
                            <option value="" hidden>{{ __('grievance::grievance.year') }}</option>
                            @foreach ($fiscalYear as $year)
                                <option value="{{ $year->id }}"
                                    {{ request('filter_year') == $year->id ? 'selected' : '' }}>
                                    {{ $year->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label for="filter_type" class="form-label">{{ __('grievance::grievance.type') }}</label>
                        <select dusk="grievance-filter_type-field" name="filter_type" id="filter_type" class="form-select">
                            <option value="" hidden>{{ __('grievance::grievance.type') }}</option>
                            @foreach ($grievanceType as $item)
                                <option value="{{ $item->id }}"
                                    {{ request('filter_type') == $item->id ? 'selected' : '' }}>
                                    {{ $item->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="start_date" class="form-label">{{ __('grievance::grievance.start_date') }}</label>
                        <input dusk="grievance-start_date-field" type="text" name="start_date" id="start_date" class="form-control nepali-date"
                            value="{{ request('start_date') }}" placeholder="{{ __('grievance::grievance.select_start_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="end_date" class="form-label">{{ __('grievance::grievance.end_date') }}</label>
                        <input dusk="grievance-end_date-field" type="text" name="end_date" id="end_date" class="form-control nepali-date"
                            value="{{ request('end_date') }}" placeholder="{{ __('grievance::grievance.select_end_date') }}">
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
                                <th>{{ __('grievance::grievance.token_no') }}</th>
                                <th>{{ __('grievance::grievance.customer') }}</th>
                                <th>{{ __('grievance::grievance.grievance_against') }}</th>
                                <th>{{ __('grievance::grievance.subject') }}</th>
                                <th>{{ __('grievance::grievance.assigned_users') }}</th>
                                <th>{{ __('grievance::grievance.suggestions') }}</th>
                                {{-- <th>{{ __('grievance::grievance.action') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>{{ $report->token }}</td>
                                    <td>
                                        @include('Grievance::livewire.table.common-customer', [
                                            'row' => $report->customer,
                                        ])
                                    </td>
                                    <td>{{ $report->grievanceType?->title }}</td>
                                    <td>{{ $report->subject }}</td>
                                    <td>
                                        @include('Grievance::livewire.table.col-assign-history', [
                                            'row' => $report->histories->load('fromUser', 'toUser'),
                                        ])
                                    </td>
                                    <td>{{ $report->suggestions }}</td>
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
    </div>
</x-layout.app>



<script>
    document.getElementById('clear-filters').addEventListener('click', function() {
        document.getElementById('search').value = '';

        document.getElementById('filter_status').value = '';
        document.getElementById('filter_priority').value = '';
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
        document.getElementById('filter_ward').value = '';
        document.getElementById('filter_type').value = '';
        document.getElementById('filter_year').value = '';

        this.closest('form').submit();
    });
</script>
