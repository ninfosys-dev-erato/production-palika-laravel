<x-layout.app header="{{ __('Fuel Dashboard') }}">

    <div class="d-flex flex-row flex-wrap justify-content-start gap-4">

        <!-- Card 1 -->
        <div class="card card-border-shadow-primary flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            <i class="bx bxs-car fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{__('Vehicle Categories')}}</h6>
                        <h3 class="mb-0 text-dark fw-bold">20</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card card-border-shadow-success flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-success">
                            <i class="bx bxs-car-mechanic fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{__('Total Vehicles')}}</h6>
                        <h3 class="mb-0 text-dark fw-bold">154</h3>

                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card card-border-shadow-info flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-info">
                            <i class="bx bx-credit-card fs-1"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{__('Token Requests')}}</h6>
                        <h3 class="mb-0 text-dark fw-bold">42</h3>

                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="card card-border-shadow-warning flex-fill hover-scale dash-card-width">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-warning">
                            <i class="bx bx-time fs-1"></i>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-uppercase">{{__('Pending Tokens')}}</h6>
                        <h3 class="mb-0 text-dark fw-bold">15</h3>

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
                        <h6 class="mb-1 text-uppercase">{{__('Accepted Tokens')}}</h6>
                        <h3 class="mb-0 text-dark fw-bold">27</h3>
                    </div>
                </div>
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

</x-layout.app>
