<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('home') }}/gunasoStyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>सार्वजनिक गुनासो</title>
</head>

<body>
    <main class="container">
        <div class="d-flex justify-content-between">
            <h2 class="title text-primary">सार्वजनिक गरिएका गुनासो/उजुरीहरु</h2>
            <a href="{{ route('services') }}" class="btn btn-primary mb-3"><i class="bx bx-plus"></i>
                गुनासो दर्ता गर्नुहोस्</a>
        </div>

        <div class="complaints">
            @foreach ($grievances as $grievance)
                <div class="indv-complaint">
                    <div class="comp-left">
                        <p class="comp-title">{{ $grievance->grievanceType->title }}</p>
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
                    '{{ $grievance->branch->title ?? 'N/A' }}',
                    '{{ $grievance->customer->name ?? 'Anonymous User' }}'
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
                                <td class="text-primary">शाखा</td>
                                <td><span id="grievanceBranch"></span></td>
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

</body>
<script>
    function openModal(id, subject, description, token, created_at, status, branchTitle, customerName) {
        document.getElementById('grievanceSubject').innerText = subject;
        document.getElementById('grievanceDescription').innerText = description;
        document.getElementById('grievanceToken').innerText = token;
        document.getElementById('grievanceDate').innerText = created_at;
        document.getElementById('grievanceCustomer').innerText = customerName;
        document.getElementById('grievanceBranch').innerText = branchTitle;

        var myModal = new bootstrap.Modal(document.getElementById('grievanceModal'));
        myModal.show();
    }
</script>
<script src="{{ asset('home') }}/js/jquery.min.js"></script>
<script src="{{ asset('home') }}/js/custom.min.js"></script>
<script src="{{ asset('home') }}/js/simplyScroll.js"></script>
<script src="{{ asset('home') }}/js/owl/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>

</html>
