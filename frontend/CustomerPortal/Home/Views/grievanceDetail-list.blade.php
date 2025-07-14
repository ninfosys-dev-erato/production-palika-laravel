@extends('home.layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('home') }}/gunasoStyle.css">
    <main class="container">
        <div class="d-flex justify-content-between">
            <p class="title">सार्वजनिक गरिएका गुनासो/उजुरीहरु</p>
            <a href="{{ route('services') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                गुनासो दर्ता गर्नुहोस्</a>
        </div>

        <div class="complaints">
            @foreach ($grievances as $grievance)
                <div class="indv-complaint">
                    <div class="comp-left">
                        <p class="comp-title">गुनासो/उजुरी प्रकृति</p>
                        <p class="comp-detail">{{ $grievance->subject }}</p>
                    </div>

                    <div class="comp-right">
                        <div class="comp-date">
                            <p class="date">{{ \Carbon\Carbon::parse($grievance->created_at)->format('Y-m-d') }}</p>
                            <p class="time">{{ \Carbon\Carbon::parse($grievance->created_at)->format('H:i:s') }}</p>
                        </div>
                        <button
                            onclick="openModal(
                    {{ $grievance->id }},
                    '{{ $grievance->subject }}',
                    '{{ $grievance->description }}',
                    '{{ $grievance->token }}',
                    '{{ $grievance->created_at }}',
                    '{{ $grievance->status->value }}',
                    '{{ $grievance->customer->name ??  'Anonymous User'}}'
                )"
                            class="comp-view" style="color: #fafafa; text-decoration: none; cursor: pointer;">
                            <i class="bx bx-show"></i> View
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="pagination-container">
            <ul class="pagination pagination-lg">
                {{ $grievances->links('pagination::bootstrap-4') }}
            </ul>
        </div>
    </main>

    <!-- Modal Container -->
    <div id="grievanceModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">गुनासो/उजुरी विवरण</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>

                            <tr>
                                <td class="text-primary">टिकट नम्बर</td>
                                <td><span id="grievanceToken"></span></td>
                            </tr>

                            <tr>
                                <td class="text-primary">ग्राहकको नाम</td>
                                <td><span id="grievanceCustomer"></span></td>
                            </tr>

                            <tr>
                                <td class="text-primary">विषय</td>
                                <td><span id="grievanceSubject"></span></td>
                            </tr>
                            <tr>
                                <td class="text-primary">विवरण</td>
                                <td><span id="grievanceDescription"></span></td>
                            </tr>
                            <tr>
                                <td class="text-primary">मिति</td>
                                <td><span id="grievanceDate"></span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openModal(id, subject, description, token, created_at, status, customerName) {
            document.getElementById('grievanceSubject').innerText = subject;
            document.getElementById('grievanceDescription').innerText = description;
            document.getElementById('grievanceToken').innerText = token;
            document.getElementById('grievanceDate').innerText = created_at;
            document.getElementById('grievanceCustomer').innerText = customerName;
            // document.getElementById('grievanceBranch').innerText = branchTitle;

            var myModal = new bootstrap.Modal(document.getElementById('grievanceModal'));
            myModal.show();
        }
    </script>
@endsection
