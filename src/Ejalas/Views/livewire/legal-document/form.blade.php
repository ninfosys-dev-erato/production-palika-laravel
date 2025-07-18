<div>
    <form wire:submit.prevent="save">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class='col-md-12 mb-2' wire:ignore>
                        <div class='form-group'>
                            <label for='complaint_registration_id'
                                class="form-label">{{ __('ejalas::ejalas.complaint_registration_id') }}</label>
                            <select wire:model='legalDocument.complaint_registration_id' name='complaint_registration_id'
                                class="form-select form-select-md p-2  @error('complaint_registration_id') is-invalid @enderror"
                                id="complaint_registration_id" wire:change="getComplaintRegistration()"
                                @if ($action === App\Enums\Action::UPDATE) disabled @endif>
                                <option value="" hidden>{{ __('ejalas::ejalas.select_a_complaint') }}</option>
                                @foreach ($complainRegistrations as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('legalDocument.complaint_registration_id')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-end mt-1 mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#legalDocumentModal">{{ __('ejalas::ejalas.add_legal_document_details') }}</button>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('ejalas::ejalas.party_name') }}</th>
                            <th>{{ __('ejalas::ejalas.document_writer') }}</th>
                            <th>{{ __('ejalas::ejalas.document_signer') }}</th>
                            <th>{{ __('ejalas::ejalas.document_date') }}</th>
                            <th>{{ __('ejalas::ejalas.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($temporaryDetails as $index => $detail)
                            <tr>
                                <td>{{ $detail['partyName'] }}</td>
                                <td>{{ $detail['document_writer_name'] }}</td>
                                <td>{{ $detail['statement_giver'] }}</td>
                                <td>{{ $detail['document_date'] }}</td>
                                <td>
                                    <button type="button" wire:click="editTemporaryDetail({{ $index }})"
                                        class="btn btn-primary btn-sm"><i class="bx bx-edit"></i></button>
                                    <button type="button" wire:click="removeTemporaryDetail({{ $index }})"
                                        wire:confirm="Are you sure you want to delete this detail?"
                                        class="btn btn-danger btn-sm">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No data to show</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"
                    wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
                <a href="{{ route('admin.ejalas.legal_documents.index') }}" wire:loading.attr="disabled"
                    class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="legalDocumentModal" tabindex="-1" aria-labelledby="legalDocumentModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="legalDocumentModalLabel">Add Legal Document Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class='col-md-6 mb-2'>
                            <div class='form-group'>
                                <label for='document_date'
                                    class="form-label">{{ __('ejalas::ejalas.document_date') }}</label>
                                <input wire:model='legalDocumentDetail.document_date'id="document_date"
                                    name='document_date' type='text' class='form-control'
                                    placeholder="{{ __('ejalas::ejalas.enter_document_date') }}">
                                <div>
                                    @error('legalDocumentDetail.document_date')
                                        <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6 mb-2'>
                            <div class='form-group'>
                                <label for='party_name'
                                    class="form-label">{{ __('ejalas::ejalas.party_name') }}</label>
                                <select wire:model='legalDocumentDetail.party_name' name='party_name'
                                    class="form-select">
                                    <option value=""hidden>{{ __('ejalas::ejalas.select_a_party_name') }}
                                    </option>
                                    @forelse ($parties as $party)
                                        <option value="{{ $party->id }}">
                                            {{ $party->name }}
                                            @if ($party->pivot)
                                                ({{ $party->pivot->type }})
                                            @endif
                                        </option>
                                    @empty
                                        <option value=""disabled>{{ __('ejalas::ejalas.no_value_available') }}
                                        </option>
                                    @endforelse
                                </select>
                                <div>
                                    @error('legalDocument.party_name')
                                        <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6 mb-2'>
                            <div class='form-group'>
                                <label for='document_writer_name'
                                    class="form-label">{{ __('ejalas::ejalas.document_writer_name') }}</label>
                                <input wire:model='legalDocumentDetail.document_writer_name' name='document_writer_name'
                                    type='text' class='form-control'
                                    placeholder="{{ __('ejalas::ejalas.enter_document_writer_name') }}">
                                <div>
                                    @error('legalDocumentDetail.document_writer_name')
                                        <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6 mb-2'>
                            <div class='form-group'>
                                <label for='statement_giver'
                                    class="form-label">{{ __('ejalas::ejalas.statement_giver_name') }}</label>
                                <input wire:model='legalDocumentDetail.statement_giver' name='statement_giver'
                                    type='text' class='form-control'
                                    placeholder="{{ __('ejalas::ejalas.enter_document_signer') }}">
                                <div>
                                    @error('legalDocumentDetail.statement_giver')
                                        <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class='col-md-12 mb-2'>
                            <div class='form-group'>
                                <label for='document_details'
                                    class="form-label">{{ __('ejalas::ejalas.legal_document_detail') }}</label>
                                <x-form.ck-editor-input id="legalDocument_document_details"
                                    wire:model='legalDocumentDetail.document_details'
                                    name='legalDocumentDetail.document_details' :value="$legalDocumentDetail?->document_details ?? ''" />
                                <div>
                                    @error('legalDocumentDetail.document_details')
                                        <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="saveTemporaryDetail">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this detail?');
    }
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', () => {
            $('#legalDocumentModal').modal('hide');
        });
    });
    $('#legalDocumentModal').on('hidden.bs.modal', function() {
        @this.call('resetModal');
    });

    // Ensure cleanup when the modal is fully closed
    $('#legalDocumentModal').on('hidden.bs.modal', function() {
        $('body').removeClass('modal-open').css({
            'overflow': '',
            'padding-right': ''
        });
        $('.modal-backdrop').remove();
    });

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('legalDocumentModal'));
            modal.show();
        });
    });
</script>
@script
    <script>
        $(document).ready(function() {
            $('#document_date').nepaliDatePicker({
                dateFormat: '%y-%m-%d',
                closeOnDateSelect: true,
            }).on('dateSelect', function() {
                let nepaliDate = $(this).val();
                @this.set('legalDocumentDetail.document_date', nepaliDate);
            });


            $('#complaint_registration_id').select2();
            $('#complaint_registration_id').on('change', function(e) {
                let complaintId = $(this).val();
                @this.set('legalDocument.complaint_registration_id', complaintId);
                @this.call('getComplaintRegistration'); // Call livewire function to get party details
            });
        });
    </script>
@endscript
