<x-layout.app header="{{ __('ejalas::ejalas.ejalas_dashboard') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="d-flex flex-row flex-wrap justify-content-start gap-3">

        <!-- Card 1 -->
        <div class="card card-border-shadow-primary flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="bx bx-list-ul fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{ __('ejalas::ejalas.total_complaint') }}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{ $totalComplaint }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="card card-border-shadow-success flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-secondary">
                            <i class="bx bx-group fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{ __('ejalas::ejalas.total_parties') }}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{ $totalParties }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card card-border-shadow-info flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-warning">
                            <i class="bx bx-time-five fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{ __('ejalas::ejalas.pending_cases') }}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{ $totalPendingComplaint }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="card card-border-shadow-warning flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-success">
                            <i class="bx bx-check-circle fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{ __('ejalas::ejalas.registered_complaint') }}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{ $totalRegisteredComplaint }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="card card-border-shadow-danger flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-danger">
                            <i class="bx bx-check-circle fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{ __('ejalas::ejalas.rejected_complaint') }}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{ $totalRejectedComplaint }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row mt-5">
        <!-- First Chart: Complaint Status Overview -->
        <div class="col-md-6">
            <div class="card p-3" style="width: 100%; height: 320px; margin: 0 auto;">
                <h5 class="mb-3">{{ __('ejalas::ejalas.complaint_status_overview') }}</h5>
                <div class="d-flex justify-content-center align-items-center" style="height: calc(100% - 50px);">
                    <div>
                        <canvas id="complaintChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Chart: Ward-wise Complaint Overview -->
        <div class="col-md-6">
            <div class="card p-3" style="width: 100%; height: 320px; margin: 0 auto;">
                <h5 class="mb-3">{{ __('ejalas::ejalas.wardwise_complaint_overview') }}</h5>
                <canvas id="wardComplaintChart" height="250"></canvas>
            </div>
        </div>
    </div>








    <style>
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }

        .avatar-initial {
            width: 50px;
            height: 50px;
        }

        .dash-card-width {
            max-width: 14rem;
        }
    </style>

    <script>
        const ctx = document.getElementById('complaintChart').getContext('2d');

        const complaintChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Total', 'Pending', 'Registered', 'Rejected'],
                datasets: [{
                    label: 'Complaints',
                    data: [
                        {{ $totalComplaint }},
                        {{ $totalPendingComplaint }},
                        {{ $totalRegisteredComplaint }},
                        {{ $totalRejectedComplaint }}
                    ],
                    backgroundColor: [
                        '#01399a',
                        '#ffc107', // warning - pending
                        '#28a745', // success - registered
                        '#dc3545' // danger - rejected
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    title: {
                        display: true
                    }
                }
            }
        });
    </script>
    <script>
        const wardCtx = document.getElementById('wardComplaintChart').getContext('2d');

        new Chart(wardCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($wardWiseComplaintCount->pluck('ward_no')->toArray()) !!},
                datasets: [{
                    label: 'Registered Complaints',
                    data: {!! json_encode($wardWiseComplaintCount->pluck('complaint_count')->toArray()) !!},
                    backgroundColor: '#007bff',
                    borderColor: '#0056b3',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</x-layout.app>
