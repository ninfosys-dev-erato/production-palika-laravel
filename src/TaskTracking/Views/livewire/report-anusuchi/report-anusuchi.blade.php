<form wire:submit.prevent="save">

    <div class="col-12">
        <h5 class="text-center">
            <select name="" id="" class="text-center rounded" wire:model="anusuchi"
                wire:change="getAnusuchiValue" @if ($action === App\Enums\Action::UPDATE) disabled @endif>
                <option value="" hidden>{{ __('tasktracking::tasktracking.select_an_option') }}</option>

                @foreach ($anusuchis as $record)
                    <option value="{{ $record->id }}">{{ $record->name }}</option>
                @endforeach
            </select>
        </h5>
        <p class="text-center">{{ $selectedAnusuchi?->description }}</p>
        <p class="text-center">निर्देशन तथा परिपत्रको पालना र यथ कामकाजमा खटिने कर्मचारीलाई कार्यसम्पादनको
            आधारमा</p>
        <p class="text-center">प्रमुख प्रशासकीय अधिकृतले अङ्क प्रदान गर्ने फाराम</p>

        <div class="d-flex justify-content-between mb-2">
            <div>
                <input class="form-input" type="text" wire:model="employeeMarking.fiscal_year" disabled>
            </div>
            <div class="d-flex align-items-center">
                <label for="" class="me-1">महिनाः-</label>
                <div class="form-group">
                    <select name="" id="" class="form-control" width="100%"
                        wire:model="selectedMonth">
                        <option value="">{{ __('Select Month') }}</option>
                        @foreach ($nepaliMonths as $month)
                            <option value="{{ $month->value }}">{{ __($month->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" class="align-middle">क्र.स.</th>
                        <th rowspan="2" class="align-middle red-text">शाखा/ कार्यालय</th>
                        <th rowspan="2" class="align-middle red-text">कर्मचारीको नाम्बर</th>
                        <th rowspan="2" class="align-middle">पद</th>
                        @if ($selectedAnusuchi?->criterion && $selectedAnusuchi->criterion->count())
                            @foreach ($selectedAnusuchi->criterion as $criterion)
                                <th colspan="2" class="align-middle">{{ $criterion->name }}</th>
                            @endforeach
                        @endif
                        <th rowspan="2" class="align-middle">कुल प्रदान गरिएको अङ्क</th>
                        <th rowspan="2" class="align-middle">कैफियत</th>
                    </tr>
                    <tr>
                        @if ($selectedAnusuchi?->criterion && $selectedAnusuchi->criterion->count())
                            @foreach ($selectedAnusuchi->criterion as $criterion)
                                <th>पूर्णाङ्क</th>
                                <th>प्राप्ताङ्को अंक</th>
                            @endforeach
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ replaceNumbers($loop->iteration, true) }}</td>
                            <td>{{ $employee->branch?->title }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->designation?->title }}</td>

                            @if ($selectedAnusuchi?->criterion && $selectedAnusuchi->criterion->count())
                                @foreach ($selectedAnusuchi->criterion as $criterion)
                                    <td>
                                        <input type="number" class="form-control"
                                            wire:model="formData.{{ $employee->id }}.{{ $criterion->id }}.full"
                                            value="{{ $criterion->max_score }}" readonly />
                                    </td>
                                    <td>
                                        <input type="number" class="form-control"
                                            wire:model.live="formData.{{ $employee->id }}.{{ $criterion->id }}.obtained"
                                            wire:input="updateTotal({{ $employee->id }})" />
                                    </td>
                                @endforeach
                            @endif

                            <td>
                                <input type="number" class="form-control"
                                    wire:model="formData.{{ $employee->id }}.total" readonly />
                            </td>
                            <td>
                                <input type="text" class="form-control"
                                    wire:model="formData.{{ $employee->id }}.remarks" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>


            </table>
        </div>

        <div class="mt-4">

            <div class="col-md-6">
                <p>प्रमुख प्रशासकीय अधिकृतको / Signee</p>
                @if ($action === App\Enums\Action::CREATE)
                    <livewire:signee-select />
                @else
                    <livewire:signee-select :selectedUserId="$selectedSignee" />
                @endif

            </div>
            <div class="col-md-6 my-3">
                <p>{{ 'Sign' }}</p>
            </div>
            <div class="col-md-6">
                <div class="signature-line">मितिः
                    <input type="text" class="form-control nepali-date" id="anusuchiDate" wire:model="anusuchiDate">
                </div>
            </div>

        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('tasktracking::tasktracking.save') }}</button>
        <a href="{{ route('admin.anusuchis.report') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('tasktracking::tasktracking.back') }}</a>
    </div>
</form>
