 <div class="card shadow-sm border-0 rounded-lg bg-light h-30 p-4 mb-3">
     <div class="row">
         <div class="col-md-12">
             <h5 class="fw-bold text-primary mb-3">{{ __('ebps::ebps.organization_renewal') }}</h5>
             <div class="row align-items-end">
                 <div class="col-md-8 mb-3">
                     <input type="file" class="form-control" id="renewal_document" name="renewal_document"
                         wire:model="document" accept=".pdf,.jpg,.jpeg,.png" required>

                 </div>
                 <div class="col-md-4 mb-3">
                     <button type="submit" wire:click="save" class="btn btn-primary w-100">
                         <i class="bx bx-upload"></i> {{ __('ebps::ebps.upload_renewal') }}
                     </button>
                 </div>
             </div>
         </div>
     </div>
 </div>
