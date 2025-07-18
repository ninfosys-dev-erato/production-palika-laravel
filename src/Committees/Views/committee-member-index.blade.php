<x-layout.app header="CommitteeMember List">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Committee Member') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('List') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold">{{ __('Committee Member List') }}</h5>

                    @perm('committee_member_create')
                        <div>
                            <a href="{{ route('admin.committee-members.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('Add Committee Member') }}</a>
                        </div>
                    @endperm

                </div>
                <div class="card-body">
                    <livewire:committees.committee_member_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
