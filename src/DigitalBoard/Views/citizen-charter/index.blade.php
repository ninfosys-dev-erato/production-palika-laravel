<x-layout.app header="{{ __('digitalboard::digitalboard.citizen_charter_list') }}">


    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('digitalboard::digitalboard.citizen_charter') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('digitalboard::digitalboard.list') }}</li>
        </ol>
    </nav>

    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="text-primary fw-bold mb-0">{{ __('digitalboard::digitalboard.citizen_charters') }}
                        </h5>
                        <div>
                            @perm('citizencharter_create')
                                <a href="{{ route('admin.digital_board.citizen_charters.create') }}" class="btn btn-info"><i
                                        class="bx bx-plus"></i>
                                    {{ __('digitalboard::digitalboard.add_citizen_charter') }}</a>
                            @endperm
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <livewire:digital_board.citizen_charter_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
