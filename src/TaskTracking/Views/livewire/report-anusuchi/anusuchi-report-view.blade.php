<div class="card">
    <div class="card-body">
        <div class="col-12">
            <h2 class="text-center">
                {{ $employeeMarking->anusuchi->name }}
            </h2>
            <p class="text-center">(दफा ४ को उपदफा (१) र (२) संग सम्बन्धित)</p>
            <p class="text-center">निर्देशन तथा परिपत्रको पालना र यथ कामकाजमा खटिने कर्मचारीलाई कार्यसम्पादनको आधारमा
            </p>
            <p class="text-center">प्रमुख प्रशासकीय अधिकृतले अङ्क प्रदान गर्ने फाराम</p>

            <div class="d-flex justify-content-between mb-2">
                <div>
                    <p>सालः-{{ $employeeMarking->fiscal_year }}</p>
                </div>
                <div class="d-flex align-items-center">
                    <p>महिनाः- {{ nepaliMonthName($employeeMarking->month) }}</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">क्र.स.</th>
                            <th rowspan="2">शाखा/ कार्यालय</th>
                            <th rowspan="2">कर्मचारीको नाम</th>
                            <th rowspan="2">पद</th>

                            @foreach ($employeeMarking->anusuchi->criterion as $criterion)
                                <th colspan="2">{{ $criterion->name }}</th>
                            @endforeach

                            <th rowspan="2">कुल प्राप्ताङ्क</th>
                            <th rowspan="2">कैफियत</th>
                        </tr>
                        <tr>
                            @foreach ($employeeMarking->anusuchi->criterion as $criterion)
                                <th>पूर्णाङ्क</th>
                                <th>प्राप्ताङ्क</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedScores as $employeeId => $scores)
                            @php
                                $employee = $scores->first()->employee;
                                $totalObtained = $scores->sum('score_obtained');
                                $remarks = $scores->first()->remarks;
                            @endphp
                            <tr>
                                <td>{{ replaceNumbers($loop->iteration, true) }}</td>
                                <td>{{ $employee->branch?->title }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->designation?->title }}</td>

                                @foreach ($employeeMarking->anusuchi->criterion as $criterion)
                                    @php
                                        $score = $scores->firstWhere('criteria_id', $criterion->id);
                                    @endphp
                                    <td>{{ $score?->score_out_of ?? '-' }}</td>
                                    <td>{{ $score?->score_obtained ?? '-' }}</td>
                                @endforeach

                                <td>{{ $totalObtained }}</td>
                                <td>{{ $remarks }}</td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>

            <div class="mt-4">

                <div class="col-md-6">
                    <p>प्रमुख प्रशासकीय अधिकृतको / Signee</p>
                    <p>{{ $employeeMarking->employee->name }}</p>
                </div>
                <div class="col-md-6">
                    <p>{{ 'Sign' }}</p>
                </div>
                <div class="col-md-6">
                    <div class="signature-line">मितिः
                        {{ $employeeMarking->date_from }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
