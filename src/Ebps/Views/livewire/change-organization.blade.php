<div>
    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="javascript:history.back()" class="btn btn-outline-primary">
            <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-primary fw-bold mb-0">{{ __('ebps::ebps.organization') }}</h5>
        </div>
        <form wire:submit.prevent="save">
            <div class="card-body">

                <div class="row">

                    <div class="form-group col-md-6">
                        <label for="registration_date">{{ __('ebps::ebps.registration_date') }}</label>
                        <input type="text" wire:model="organizationDetail.registration_date" id="registration_date"
                            class="form-control nepali-date" />
                        @error('organizationDetail.registration_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="organization_id">{{ __('ebps::ebps.select_organization') }}</label>
                        <select wire:model="organizationDetail.organization_id" id="organization_id"
                            class="form-control">
                            <option value="">{{ __('ebps::ebps.select_organization') }}</option>
                            @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}">{{ $organization->org_name_ne }}</option>
                            @endforeach
                        </select>
                        @error('organizationDetail.organization_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="divider divider-primary text-start text-primary font-14">
                        <div class="divider-text">{{ __('ebps::ebps.reason_of_owner_change') }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="reason" class="form-label">
                                {{ __('ebps::ebps.reason') }}
                            </label>
                            <span class="text-danger">*</span>
                            <textarea id="reason_of_organization_change" name="organizationDetail.reason_of_organization_change"
                                class="form-control" rows="4" wire:model="organizationDetail.reason_of_organization_change"></textarea>

                            @error('organizationDetail.reason_of_organization_change')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary">{{ __('ebps::ebps.save') }}</button>
                    </div>
                </div>
        </form>

        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title text-primary fw-bold mb-0">{{ __('ebps::ebps.old_consultancy_detail') }}</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3">क्र.सं</th>
                                <th class="py-3">Organization Name</th>
                                <th class="py-3">Registration Date</th>
                                <th class="py-3">Phone Number</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $serial = 1;
                            @endphp

                            @if ($mapApply->organizationDetails->isNotEmpty())
                                @foreach ($mapApply->organizationDetails as $organization)
                                    @php
                                        $current = $organization;
                                    @endphp

                                    @while ($current)
                                        <tr>
                                            <td class="py-3">{{ $serial++ }}</td>
                                            <td class="py-3">{{ $current->name }}</td>
                                            <td class="py-3">{{ $current->registration_date }}</td>
                                            <td class="py-3">{{ $current->contact_no }}</td>
                                        </tr>

                                        @php
                                            $current = $current->relationLoaded('parentRecursive')
                                                ? $current->parentRecursive
                                                : null;
                                        @endphp
                                    @endwhile
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="bx bx-info-circle me-2 fs-4"></i>
                                        तालिकामा कुनै डाटा उपलब्ध छैन !!!
                                    </td>
                                </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
