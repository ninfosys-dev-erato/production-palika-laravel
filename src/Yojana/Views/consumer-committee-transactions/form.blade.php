<x-layout.app header="ConsumerCommitteeTransaction  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">ConsumerCommitteeTransaction</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($consumerCommitteeTransaction))
                        Create
                    @else
                        Edit
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($consumerCommitteeTransaction))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($consumerCommitteeTransaction) ? __('yojana::yojana.create_consumercommitteetransactions') : __('yojana::yojana.update_consumercommitteetransactions') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.consumer_committee_transactions.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.consumercommitteetransactions_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($consumerCommitteeTransaction))
            <livewire:consumer_committee_transactions.consumer_committee_transaction_form  :$action :$consumerCommitteeTransaction />
        @else
            <livewire:consumer_committee_transactions.consumer_committee_transaction_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
