 <div>

     <div class="modal-body">
         <div class="form-group">
             <label class="form-label" for="organization">{{__('ebps::ebps.select_organization')}}</label>
             <select wire:model="mapApplyDetail.organization_id" class="form-control" id="organization">
                 <option value="">-- {{__('ebps::ebps.select_organization')}} --</option>
                 @foreach ($organizations as $organization)
                     <option value="{{ $organization->id }}">{{ $organization->org_name_ne }}
                     </option>
                 @endforeach
             </select>
         </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('ebps::ebps.close')}}</button>
         <button type="button" wire:click="saveOrganization" class="btn btn-primary">{{__('ebps::ebps.save')}}</button>
     </div>
 </div>
