<x-layout.app header="Ward List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">Ward</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('wards::wards.ward_list') }}
                    <div>
                        @perm('wards create')
                            <a href="{{ route('admin.wards.create') }}" class="btn btn-info"><i class="bx bx-plus"></i> Add
                                Ward</a>
                        @endperm
                    </div>
                </div>

                <hr class="m-0">

                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-start gap-5">
                        @foreach ($wards as $ward)
                            <div class="card icon-card cursor-pointer shadow-sm"
                                style="width: 20rem; border-radius: 12px; min-height: 9rem;position: relative;">
                                <a href="{{ route('admin.wards.showusers', $ward->id) }}"
                                    class="p-2 stretched-link"></a>
                                <div class="d-flex h-100 w-100">
                                    <!-- Image Column (30%) -->
                                    <div class="d-flex flex-column align-items-center justify-content-center"
                                        style="width: 30%; background-color: #f8f9fa;">

                                        <img src="{{ asset('assets/icons/DigitalLgProfileIcon.png') }}" alt="logo"
                                            class="img-fluid" style="width: 50px; height: 50px;">
                                        <p class="mb-0 text-muted small">{{ __('wards::wards.ward') . ' ' . $ward->id }}
                                        </p>
                                    </div>
                                    <!-- Content Column (70%) -->
                                    <div class="d-flex flex-column align-items-end justify-content-center p-3"
                                        style="width: 70%;">
                                        <h6 class="mb-1 fw-bold text-break text-end"
                                            style="font-size: 0.95rem; line-height: 1.3; max-height: 5em; overflow: hidden;">
                                            {{ $ward->title }}
                                        </h6>
                                        <p class="mb-2 text-muted small text-end">{{ $ward->phone }}</p>
                                        <div class="d-flex justify-content-end gap-2 mt-1"
                                            style="position: relative; z-index: 2;">
                                            <a href="{{ route('admin.wards.edit', $ward->id) }}"
                                                class="btn btn-primary btn-sm px-2 py-1">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.wards.destroy', $ward->id) }}"
                                                class="btn btn-danger btn-sm px-2 py-1">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout.app>
