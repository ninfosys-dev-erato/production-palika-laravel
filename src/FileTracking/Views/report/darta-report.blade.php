<x-layout.app header="{{ __('filetracking::filetracking.register_file_report') }}">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="text-primary mb-0">{{ __('filetracking::filetracking.register_file_report') }}</h4>
                <div class="d-flex gap-2 ms-auto">
                    <a href="{{ route('admin.register_files.export', array_merge(request()->query(), ['type' => 'report'])) }}"
                        class="btn btn-outline-primary btn-sm">
                        {{ __('filetracking::filetracking.export') }}
                    </a>
                    <a href="{{ route('admin.register_files.download-pdf', array_merge(request()->query(), ['type' => 'report'])) }}"
                        class="btn btn-outline-primary btn-sm" target="_blank">
                        {{ __('filetracking::filetracking.pdf') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.register_files.report') }}" class="row g-3">
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
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <td>{{ __('filetracking::filetracking.reg_no') }}</td>
                                <td>{{ __('filetracking::filetracking.register_date') }}</td>
                                <td colspan="3" class="text-center">
                                    {{ __('filetracking::filetracking.letter_received') }}</td>
                                <td>{{ __('filetracking::filetracking.file_sender') }}</td>
                                <td>{{ __('filetracking::filetracking.address') }}</td>
                                <td>{{ __('filetracking::filetracking.subject') }}</td>
                                <td>{{ __('filetracking::filetracking.department') }}</td>
                                <td>{{ __('filetracking::filetracking.fursayat_branch') }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{ __('filetracking::filetracking.letter_no') }}</td>
                                <td>{{ __('filetracking::filetracking.chno') }}</td>
                                <td>{{ __('filetracking::filetracking.date') }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>{{ $report->reg_no }}</td>
                                    <td>
                                        {{--                                    {{ \Carbon\Carbon::parse($report->created_at)->toFormattedDateString() }} --}}
                                        {{ replaceNumbers(Anuzpandey\LaravelNepaliDate\LaravelNepaliDate::from($report->registration_date)->toNepaliDate(), true) }}
                                    </td>
                                    <td>
                                        {{ $report->fiscalYear->year ?? getSetting('year') }}
                                    </td>
                                    <td>
                                        {{ $report->sender_document_number }}
                                    </td>
                                    <td>
                                        {{--                                    {{ \Carbon\Carbon::parse($report->created_at)->toFormattedDateString() }} --}}
                                        {{ replaceNumbers($report->received_date, true) }}
                                    </td>
                                    <td>
                                        {{ $report->applicant_name }}
                                    </td>
                                    <td>{{ $report->applicant_address }}</td>
                                    <td>
                                        {{ $report->title }}
                                    </td>
                                    {{-- बुझाउने शाखा वा फाँट --}}
                                    <td>
                                        @php
                                            $recipient = $report->recipient ?? null;
                                        @endphp

                                        @if (is_null($recipient))
                                            {{ $report->recipient_department ?? 'N/A' }}
                                        @elseif ($recipient instanceof \Src\Wards\Models\Ward)
                                            {{ $recipient->ward_name_ne ?? 'N/A' }}
                                        @elseif ($recipient instanceof \Src\Employees\Models\Branch)
                                            {{ $recipient->title ?? 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $farsyaut = $report->farsyaut ?? null;
                                        @endphp

                                        @if (is_null($farsyaut))
                                            {{ $report->recipient_department ?? 'N/A' }}
                                        @elseif ($farsyaut instanceof \Src\Wards\Models\Ward)
                                            {{ $farsyaut->ward_name_ne ?? 'N/A' }}
                                        @elseif ($farsyaut instanceof \Src\Employees\Models\Branch)
                                            {{ $farsyaut->title ?? 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">
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
