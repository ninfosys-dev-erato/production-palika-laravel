<x-layout.app header="{{__('yojana::yojana.plan_management_dashboard')}}">

    <div class="d-flex flex-row flex-wrap justify-content-start gap-4">

        <!-- Card 1: Total Yojana -->
        <div class="card card-border-shadow-primary flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="bx bxs-folder fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{ __('yojana::yojana.total_plans') }}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{replaceNumbersWithLocale($total_plans,true)}}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Plans Pending Agreement -->
        <div class="card card-border-shadow-success flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-success">
                            <i class="bx bxs-file-find fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{ __('yojana::yojana.total_agreed_plans') }}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{replaceNumbersWithLocale($total_agreed_plans,true)}}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Plan Handed -->
        <div class="card card-border-shadow-info flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-info">
                            <i class="bx bx-task fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{ __('yojana::yojana.total_completed_plans') }}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{replaceNumbersWithLocale($total_completed_plans,true)}}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Payment Recommended -->
        <div class="card card-border-shadow-warning flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-warning">
                            <i class="bx bx-money fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{ __('yojana::yojana.total_extended_plans') }}</h6>
                        <h3 class="mb-0 text-dark fw-bold">{{replaceNumbersWithLocale($total_extended_plans,true)}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-border-shadow-secondary mt-4">
        <div class="card-body">
            <h5 class="card-title text-uppercase mb-4">{{ __('yojana::yojana.plans_and_programs_according_to_implementation_methods') }}</h5>
            <div style="position: relative; height: 300px;">
                <canvas id="planProgramChart"></canvas>
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
            max-width: 17rem;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartLabels = @json($chartdata['labels']);
        const planData = @json(array_values($chartdata['plan']));
        const programData = @json(array_values($chartdata['program']));

        const ctx = document.getElementById('planProgramChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: '{{ __("yojana::yojana.plan") }}',
                        data: planData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: '{{ __("yojana::yojana.program") }}',
                        data: programData,
                        backgroundColor: 'rgba(255, 206, 86, 0.7)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // ✅ Required to respect container height
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }

        });
    </script>

</x-layout.app>



