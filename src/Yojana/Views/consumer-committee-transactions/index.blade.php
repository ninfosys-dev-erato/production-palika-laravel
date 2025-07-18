<x-layout.app header="ConsumerCommitteeTransaction List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">ConsumerCommitteeTransaction</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('consumer_committee_transactions create')
                        <a href="{{ route('admin.consumer_committee_transactions.create') }}" class="btn btn-info"><i
                                class="fa fa-plus"></i> Add ConsumerCommitteeTransaction</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:consumer_committee_transactions.consumer_committee_transaction_table
                        theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
