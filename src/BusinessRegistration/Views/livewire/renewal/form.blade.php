<div>
    <div class="modal fade" id="businessRenewalModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">{{__('businessregistration::businessregistration.business_renewal')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="registrationNumber">{{__('businessregistration::businessregistration.registration_number')}}</label>
                            <input dusk="businessregistration-registrationNumber-field" type="text" class="form-control" id="registrationNumber" readonly>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">{{__('businessregistration::businessregistration.save_changes')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    Livewire.on('showModal', () => {
        $('#businessRenewalModal').modal('show');
    });
</script>
@endscript
