<div>

    <div class="d-flex justify-content-between">
        <div class="d-flex justify-content-between card-header">
            <h5 class="text-primary fw-bold mb-0">
                {{ $showSettlementForm ? __('ejalas::ejalas.create_settlement') : __('ejalas::ejalas.settlement_list') }}
            </h5>
        </div>
        <div>
            @perm('jms_judicial_management create')
                <button wire:click="toggleSettlementForm" class="btn {{ $showSettlementForm ? 'btn-danger' : 'btn-info' }}">
                    <i class="bx {{ $showSettlementForm ? 'bx-arrow-back' : 'bx-plus' }}"></i>
                    {{ $showSettlementForm ? __('ejalas::ejalas.back') : __('ejalas::ejalas.create_settlement') }}
                </button>
            @endperm

        </div>
    </div>
    @if (!$showSettlementForm)
        <div class="card mt-2">

            <div class="card-body">
                <livewire:ejalas.settlement_table theme="bootstrap-4" :complaintRegistration="$complaintRegistration" />
            </div>
        </div>
    @else
        <div>
            <div class="card mt-2">

                <div class="card-body">
                    <div class="divider divider-primary text-start text-primary mb-2">
                        <div class="divider-text fw-bold fs-6">
                            {{ __('ejalas::ejalas.detail') }}
                        </div>
                    </div>
                    <form wire:submit.prevent="save" id="form1">

                        <div class="row">

                            <div class='col-md-6 mb-3' wire:ignore>
                                <div class='form-group'>
                                    <label for='complaint_registration_id'
                                        class="form-label ">{{ __('ejalas::ejalas.complaint_no') }}</label>
                                    <input wire:model='settlement.complaint_registration_id'
                                        name='complaint_registration_id' type='text' class='form-control' readonly>
                                </div>
                            </div>
                            <div class='col-md-6 mb-3'>
                                <div class='form-group'>
                                    <label for='discussion_date'
                                        class="form-label">{{ __('ejalas::ejalas.discussion_date') }}</label>
                                    <input wire:model='settlement.discussion_date' id="discussion_date"
                                        name='discussion_date' type='text' class='form-control nepali-date'
                                        placeholder="{{ __('ejalas::ejalas.enter_discussion_date') }}">
                                    <div>
                                        @error('settlement.discussion_date')
                                            <small class='text-danger'>{{ __($message) }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-6 mb-3'>
                                <div class='form-group'>
                                    <label for='settlement_date'
                                        class="form-label">{{ __('ejalas::ejalas.settlement_date') }}</label>
                                    <input wire:model='settlement.settlement_date' id="settlement_date"
                                        name='settlement_date' type='text' class='form-control nepali-date'
                                        placeholder="{{ __('ejalas::ejalas.enter_settlement_date') }}">
                                    <div>
                                        @error('settlement.settlement_date')
                                            <small class='text-danger'>{{ __($message) }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class='col-md-6 mb-3'>
                                <div class='form-group'>
                                    <label for='present_members'
                                        class="form-label">{{ __('ejalas::ejalas.present_members') }}</label>
                                    <select wire:model='settlement.present_members' name='present_members'
                                        class="form-control">
                                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_member') }}
                                        </option>
                                        @foreach ($judicialMembers as $id => $value)
                                            <option value="{{ $id }}">{{ $value }}</option>
                                        @endforeach
                                    </select>

                                    <div>
                                        @error('settlement.present_members')
                                            <small class='text-danger'>{{ __($message) }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class='col-md-6 mb-3'>
                                <div class='form-group'>
                                    <label for='reconciliation_center_id'
                                        class="form-label">{{ __('ejalas::ejalas.reconciliation_center') }}</label>
                                    <select wire:model='settlement.reconciliation_center_id'
                                        name='reconciliation_center_id' class="form-control">
                                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_option') }}
                                        </option>
                                        @foreach ($reconciliationCenters as $id => $value)
                                            <option value="{{ $id }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('settlement.reconciliation_center_id')
                                            <small class='text-danger'>{{ __($message) }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('ejalas::ejalas.settlement_detail_list') }}</h5>
                    </div>
                    <div>
                        @perm('jms_judicial_management create')
                            <button data-bs-toggle="modal" data-bs-target="#modalSettlementDetail" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('ejalas::ejalas.add_settlement_detail') }}</button>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:ejalas.settlement_detail_table theme="bootstrap-4" :complaintRegistration="$complaintRegistration" />
                </div>
            </div>

            <div class="card mt-4">

                <div class="card-body">
                    <div class="divider divider-primary text-start text-primary mb-2">
                        <div class="divider-text fw-bold fs-6">
                            {{ __('ejalas::ejalas.settlement_detail') }}
                        </div>
                    </div>
                    <form id="form2" wire:submit.prevent="save">
                        <div class="row">
                            <div class='col-md-12'>
                                <div class='form-group'>
                                    <label for='settlement_details'
                                        class="form-label">{{ __('ejalas::ejalas.settlement_details') }}</label>
                                    <textarea wire:model='settlement.settlement_details' name='settlement_details' type='text' class='form-control'
                                        placeholder="{{ __('ejalas::ejalas.enter_settlement_details') }}" rows="5"></textarea>
                                    <div>
                                        @error('settlement.settlement_details')
                                            <small class='text-danger'>{{ __($message) }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- <div class='col-md-12 mt-4'>
                                <div class='form-group'>
                                    <label for='is_settled'>{{ __('ejalas::ejalas.is_settled') }}</label>
                                    <input wire:model='settlement.is_settled' name='is_settled' type='checkbox'
                                        class="form-check-input border-dark p-2 mt-1">
                                    <div>
                                        @error('settlement.is_settled')
                                            <small class='text-danger'>{{ __($message) }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="saveAllBtn"
                                wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
                            <a href="{{ route('admin.ejalas.settlements.index') }}" wire:loading.attr="disabled"
                                class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="modalSettlementDetail" data-bs-backdrop="static" tabindex="-1"
                aria-labelledby="ModalLabel" aria-hidden="true" data-bs-keyboard="false" wire:ignore.self>
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">
                                {{ __('ejalas::ejalas.add_settlement_detail') }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                onclick="resetSettlementDetailForm()" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="saveSettlementDetail">
                                <div class="row">

                                    <div class="col-md-6 mb-3 ">
                                        <div class="form-group">
                                            <label for="party_name" class="form-label">
                                                {{ __('ejalas::ejalas.party_name') }}
                                            </label>
                                            <select wire:model="settlementDetail.party_id" name="party_name"
                                                class="form-select">
                                                <option value="" hidden>
                                                    {{ __('ejalas::ejalas.select_a_party_name') }}
                                                </option>
                                                @forelse ($parties as $party)
                                                    <option value="{{ $party['id'] }}">
                                                        {{ $party['name'] }} ({{ ucfirst($party['type']) }})
                                                    </option>
                                                @empty
                                                    <option value="" disabled>
                                                        {{ __('ejalas::ejalas.no_value_available') }}
                                                    </option>
                                                @endforelse
                                            </select>
                                            <div>
                                                @error('settlementDetail.party_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="deadline_set_date"
                                            class="form-label">{{ __('ejalas::ejalas.fulfillment_deadline') }}</label>
                                        <input type="text" id="deadline_set_date" class="form-control"
                                            wire:model.defer="settlementDetail.deadline_set_date" wire:ignore.self>
                                        <div>
                                            @error('settlementDetail.deadline_set_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="detail"
                                            class="form-label">{{ __('ejalas::ejalas.condition_detail') }}</label>
                                        <textarea class="form-control" id="detail" wire:model="settlementDetail.detail" rows="4" required></textarea>
                                        <div>
                                            @error('settlementDetail.detail')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @perm('jms_judicial_management create')
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('ejalas::ejalas.save') }}
                                    </button>
                                @endperm
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-settlement-detail-modal', () => {
            $('#modalSettlementDetail').modal('hide');
        });
    });

    $('#modalSettlementDetail').on('hidden.bs.modal', function() {
        $('body').removeClass('modal-open').css({
            'overflow': '',
            'padding-right': ''
        });
        $('.modal-backdrop').remove();
    });

    function resetSettlementDetailForm() {
        Livewire.dispatch('resetSettlementDetailForm');
    }
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-modal-settlementDetail', () => {
            var modal = new bootstrap.Modal(document.getElementById('modalSettlementDetail'));
            modal.show();
        });
    });
    document.getElementById('saveAllBtn').addEventListener('click', function() {
        Livewire.emit('save');
    });
</script>
