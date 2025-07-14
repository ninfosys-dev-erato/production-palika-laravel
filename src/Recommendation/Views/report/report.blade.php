<x-layout.app header="{{ __('recommendation::recommendation.recommendation_report') }}">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="text-primary mb-0">{{ __('recommendation::recommendation.recommendation_report') }}</h4>
                <div class="d-flex gap-2 ms-auto">
                    <a href="{{ route('admin.recommendations.export', request()->query()) }}"
                        class="btn btn-outline-primary btn-sm" target="_blank">
                        {{ __('recommendation::recommendation.export') }}
                    </a>
                    <a href="{{ route('admin.recommendations.download-pdf', request()->query()) }}"
                        class="btn btn-outline-primary btn-sm" target="_blank">
                        {{ __('recommendation::recommendation.pdf') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('admin.recommendations.report') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="search"
                            class="form-label">{{ __('recommendation::recommendation.search') }}</label>
                        <input dusk="recommendation-search-field" type="text" name="search" id="search"
                            class="form-control" placeholder="{{ __('recommendation::recommendation.search') }}"
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-1">
                        <label for="filter_status"
                            class="form-label">{{ __('recommendation::recommendation.status') }}</label>
                        <select dusk="recommendation-filter_status-field" name="filter_status" id="filter_status"
                            class="form-select">
                            <option value="" hidden>{{ __('recommendation::recommendation.all') }}</option>
                            <option value="pending" {{ request('filter_status') == 'pending' ? 'selected' : '' }}>
                                {{ __('recommendation::recommendation.pending') }}</option>
                            <option value="rejected" {{ request('filter_status') == 'rejected' ? 'selected' : '' }}>
                                {{ __('recommendation::recommendation.rejected') }}</option>
                            <option value="sent for payment"
                                {{ request('filter_status') == 'sent for payment' ? 'selected' : '' }}>
                                {{ __('recommendation::recommendation.sent_for_payment') }}</option>
                            <option value={{ __('recommendation::recommendation.bill_uploaded') }}
                                {{ request('filter_status') == 'bill uploaded' ? 'selected' : '' }}>
                                {{ __('recommendation::recommendation.bill_uploaded') }}</option>
                            <option value="sent for approval"
                                {{ request('filter_status') == 'sent for approval' ? 'selected' : '' }}>
                                {{ __('recommendation::recommendation.sent_for_approval') }}</option>
                            <option value="accepted" {{ request('filter_status') == 'accepted' ? 'selected' : '' }}>
                                {{ __('recommendation::recommendation.accepted') }}</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="filter_ward"
                            class="form-label">{{ __('recommendation::recommendation.ward') }}</label>
                        <select dusk="recommendation-filter_ward-field" name="filter_ward" id="filter_ward"
                            class="form-select">
                            <option value="" hidden>{{ __('recommendation::recommendation.ward') }}</option>
                            @foreach ($wards as $ward)
                                <option value="{{ $ward }}"
                                    {{ request('filter_ward') == $ward ? 'selected' : '' }}>
                                    {{ $ward }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="filter_year"
                            class="form-label">{{ __('recommendation::recommendation.fiscal_year') }}</label>
                        <select dusk="recommendation-filter_year-field" name="filter_year" id="filter_year"
                            class="form-select">
                            <option value="" hidden>{{ __('recommendation::recommendation.select_year') }}
                            </option>
                            @foreach ($fiscalYear as $year)
                                <option value="{{ $year->id }}"
                                    {{ request('filter_year') == $year->id ? 'selected' : '' }}>
                                    {{ $year->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="filter_recommendation"
                            class="form-label">{{ __('recommendation::recommendation.recommendation') }}</label>
                        <select dusk="recommendation-filter_recommendation-field" name="filter_recommendation"
                            id="filter_recommendation" class="form-select">
                            <option value="" hidden>
                                {{ __('recommendation::recommendation.select_recommendation') }}</option>
                            @foreach ($recommendation as $item)
                                <option value="{{ $item->id }}"
                                    {{ request('filter_recommendation') == $item->id ? 'selected' : '' }}>
                                    {{ $item->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="filter_recommendationCategory"
                            class="form-label">{{ __('recommendation::recommendation.category') }}</label>
                        <select dusk="recommendation-filter_recommendationCategory-field"
                            name="filter_recommendationCategory" id="filter_recommendationCategory" class="form-select">
                            <option value="" hidden>{{ __('recommendation::recommendation.select_category') }}
                            </option>
                            @foreach ($recommendationCategory as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('filter_recommendationCategory') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="start_date"
                            class="form-label">{{ __('recommendation::recommendation.start_date') }}</label>
                        <input dusk="recommendation-start_date-field" type="text" name="start_date" id="start_date"
                            class="form-control nepali-date" value="{{ request('start_date') }}"
                            placeholder="{{ __('recommendation::recommendation.select_start_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="end_date"
                            class="form-label">{{ __('recommendation::recommendation.end_date') }}</label>
                        <input dusk="recommendation-end_date-field" type="text" name="end_date" id="end_date"
                            class="form-control nepali-date" value="{{ request('end_date') }}"
                            placeholder="{{ __('recommendation::recommendation.select_end_date') }}">
                    </div>

                    <div class="col-md-2 align-self-end">
                        <button type="submit"
                            class="btn btn-primary w-100">{{ __('recommendation::recommendation.filter') }}</button>
                    </div>

                    <div class="col-md-2 align-self-end">
                        <button type="button" id="clear-filters"
                            class="btn btn-secondary w-100">{{ __('recommendation::recommendation.clear') }}</button>
                    </div>
                </form>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>{{ __('recommendation::recommendation.customer_detail') }}</th>
                                <th>{{ __('recommendation::recommendation.status') }}</th>
                                <th>{{ __('recommendation::recommendation.ward') }}</th>
                                <th>{{ __('recommendation::recommendation.recommendation') }}</th>
                                <th>{{ __('recommendation::recommendation.recommendation_category') }}</th>
                                <th>{{ __('recommendation::recommendation.medium') }}</th>
                                <th>{{ __('recommendation::recommendation.remarks') }}</th>
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
                                    <td>{{ __($report->status->value) }}</td>
                                    <td> <strong>{{ __('recommendation::recommendation.ward') }}:
                                        </strong>{{ $report->ward_id }}</td>
                                    <td>{{ $report->recommendation->title ?? __('recommendation::recommendation.na') }}
                                    </td>
                                    <td>{{ $report->recommendation->recommendationCategory->title ?? __('recommendation::recommendation.na') }}
                                    </td>
                                    <td>{{ $report->recommedation_medium ?? __('recommendation::recommendation.na') }}
                                    </td>
                                    <td>{{ $report->remarks ?? __('recommendation::recommendation.na') }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        {{ __('recommendation::recommendation.no_records_found') }}</td>
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
        document.getElementById('filter_recommendation').value = '';
        document.getElementById('filter_recommendationCategory').value = '';
        document.getElementById('filter_ward').value = '';
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';

        // Submit the form
        this.closest('form').submit();
    });
</script>
