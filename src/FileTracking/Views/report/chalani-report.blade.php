<x-layout.app header="{{ __('filetracking::filetracking.chalani_report') }}">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="text-primary mb-0">{{ __('filetracking::filetracking.chalani_report') }}</h4>
                <div class="d-flex gap-2 ms-auto">
                    <a href="{{ route('admin.chalani.export', array_merge(request()->query(), ['type' => 'report'])) }}"
                        class="btn btn-outline-primary btn-sm">
                        {{ __('filetracking::filetracking.export') }}
                    </a>
                    <a href="{{ route('admin.chalani.download-pdf', array_merge(request()->query(), ['type' => 'report'])) }}"
                        class="btn btn-outline-primary btn-sm" target="_blank">
                        {{ __('filetracking::filetracking.pdf') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.chalani.report') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">{{ __('filetracking::filetracking.search') }}</label>
                        <input type="text" name="search" id="search" class="form-control"
                            placeholder="{{ __('filetracking::filetracking.search') }}" value="{{ request('search') }}">
                    </div>

                    <div class="col-md-1">
                        <label for="filter_ward" class="form-label">{{ __('filetracking::filetracking.ward') }}</label>
                        <select name="filter_ward" id="filter_ward" class="form-select">
                            <option value="" hidden>{{ __('filetracking::filetracking.ward') }}</option>
                            @foreach ($wards as $ward)
                                <option value="{{ $ward }}"
                                    {{ request('filter_ward') == $ward ? 'selected' : '' }}>
                                    {{ $ward }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="end_date"
                            class="form-label">{{ __('filetracking::filetracking.fiscal_year') }}</label>
                        <select name="fiscal_year" id="fiscal year" class="form-select">
                            <option value="">{{ __('filetracking::filetracking.select_a_fiscal_year') }}</option>
                            @foreach ($fiscalYears as $id => $value)
                                <option value="{{ $id }}"
                                    {{ request('fiscal_year') == $id ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="start_date"
                            class="form-label">{{ __('filetracking::filetracking.start_date') }}</label>
                        <input type="text" name="start_date" id="start_date" class="form-control nepali-date"
                            value="{{ request('start_date') }}"
                            placeholder="{{ __('filetracking::filetracking.select_start_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="end_date"
                            class="form-label">{{ __('filetracking::filetracking.end_date') }}</label>
                        <input type="text" name="end_date" id="end_date" class="form-control nepali-date"
                            value="{{ request('end_date') }}"
                            placeholder="{{ __('filetracking::filetracking.select_end_date') }}">
                    </div>

                    <div class="col-md-2 align-self-end">
                        <button type="submit"
                            class="btn btn-primary w-100">{{ __('filetracking::filetracking.filter') }}</button>
                    </div>

                    <div class="col-md-2 align-self-end">
                        <button type="button" id="clear-filters"
                            class="btn btn-secondary w-100">{{ __('filetracking::filetracking.clear') }}</button>
                    </div>
                </form>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" style="--bs-table-striped-bg: #f5f5f5;">
                        <thead>
                            <tr>
                                <th>{{ __('filetracking::filetracking.chalani_reg_no') }}</th>
                                <th>{{ __('filetracking::filetracking.date') }}</th>
                                <th>{{ __('filetracking::filetracking.receipt_no') }}</th>
                                <th>{{ __('filetracking::filetracking.chalani_receipent_name') }}</th>
                                {{-- <th>{{ __('filetracking::filetracking.chalani_receipent_address') }}</th> --}}
                                {{-- <th>{{ __('filetracking::filetracking.chalani_receipent_address') }}</th> --}}
                                <th>{{ __('filetracking::filetracking.chalani_title') }}</th>
                                <th>{{ __('filetracking::filetracking.chalani_sender_medium') }}</th>
                                {{-- <th>{{ __('filetracking::filetracking.chalani_receipent_department') }}</th> --}}
                                <th>{{ __('filetracking::filetracking.chalani_signee_name') }}</th>
                                {{-- <th>{{ __('filetracking::filetracking.chalani_signee_postition') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>{{ $report->reg_no }}</td>
                                    <td>
                                        {{ replaceNumbers($report->created_at_bs, true) }}
                                        {{-- {{ \Carbon\Carbon::parse($report->created_at)->toFormattedDateString() }} --}}
                                    </td>
                                    <td>
                                        {{ $report->fiscalYear->year ?? getSetting('year') }}
                                    </td>
                                    <td>
                                        {{ $report->recipient_name }}
                                    </td>
                                    <td>
                                        {{ $report->title ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ \Src\FileTracking\Enums\SenderMediumEnum::tryFrom($report->sender_medium)?->nepaliLabel() ?? \Src\FileTracking\Enums\SenderMediumEnum::THROUGH_PERSONAL->nepaliLabel() }}
                                    </td>
                                    <td>
                                        {{ $report->signee_name }}
                                    </td>
                                    {{-- <td>
                                        {{ $report->signee_position }}
                                    </td> --}}

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        {{ __('filetracking::filetracking.no_records_found') }}</td>
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

        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
        document.getElementById('filter_ward').value = '';

        this.closest('form').submit();
    });
</script>
