<x-layout.app header="{{ __('Consumer Committee ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.consumer_committees.index') }}">{{ __('yojana::yojana.consumer_committee') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($consumerCommittee))
                    {{ __('yojana::yojana.edit') }}
                @else
                    {{ __('yojana::yojana.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($consumerCommittee))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($consumerCommittee) ? __('yojana::yojana.create_consumer_committee') : __('yojana::yojana.update_consumer_committee') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.consumer_committees.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.consumer_committee_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($consumerCommittee))
                    <livewire:yojana.consumer_committee_form :$action :$consumerCommittee />
                @else
                    <livewire:yojana.consumer_committee_form :$action />
                @endif
            </div>
        </div>

        @if (isset($consumerCommittee))
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header  d-flex justify-content-between">
                        <div class="d-flex justify-content-between card-header">
                            <h5 class="text-primary fw-bold mb-0">
                                {{ __('yojana::yojana.consumer_committee_member_list') }}</h5>
                        </div>
                        <div>
                            @perm('consumer_committee_members create')
                                <a href="{{ route('admin.consumer_committee_members.create', $consumerCommittee->id) }}"
                                    class="btn btn-info"><i class="bx bx-plus"></i>
                                    {{ __('yojana::yojana.add_consumer_committee_member') }}</a>
                            @endperm
                        </div>
                    </div>
                    <div class="card-body">
                        <livewire:yojana.consumer_committee_member_table theme="bootstrap-4" :$consumerCommittee />
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout.app>
