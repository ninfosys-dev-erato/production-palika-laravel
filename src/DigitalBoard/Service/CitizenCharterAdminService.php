<?php

namespace Src\DigitalBoard\Service;

use Illuminate\Support\Facades\Auth;
use Src\DigitalBoard\DTO\CitizenCharterAdminDto;
use Src\DigitalBoard\Models\CitizenCharter;

class CitizenCharterAdminService
{
    public function store(CitizenCharterAdminDto $citizenCharterAdminDto): CitizenCharter | bool
    {
        return CitizenCharter::create([
            'branch_id' => $citizenCharterAdminDto->branch_id,
            'service' => $citizenCharterAdminDto->service,
            'required_document' => $citizenCharterAdminDto->required_document,
            'amount' => $citizenCharterAdminDto->amount,
            'time' => $citizenCharterAdminDto->time,
            'responsible_person' => $citizenCharterAdminDto->responsible_person,
            'can_show_on_admin' => $citizenCharterAdminDto->can_show_on_admin,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(CitizenCharter $citizenCharter, CitizenCharterAdminDto $citizenCharterAdminDto): CitizenCharter | bool
    {
        return tap($citizenCharter)->update([
            'branch_id' => $citizenCharterAdminDto->branch_id,
            'service' => $citizenCharterAdminDto->service,
            'required_document' => $citizenCharterAdminDto->required_document,
            'amount' => $citizenCharterAdminDto->amount,
            'time' => $citizenCharterAdminDto->time,
            'responsible_person' => $citizenCharterAdminDto->responsible_person,
            'can_show_on_admin' => $citizenCharterAdminDto->can_show_on_admin,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(CitizenCharter $citizenCharter): CitizenCharter | bool
    {
        return tap($citizenCharter)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        CitizenCharter::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function storeCitizenCharterWard(CitizenCharter $citizenCharter, array $wards): void
    {
        $citizenCharter->wards()->delete();
        $wardData = array_map(fn($wardId) => ['ward' => $wardId], $wards);
        $citizenCharter->wards()->createMany($wardData);
    }

    public function toggleCanShowOnAdmin(CitizenCharter $citizenCharter): void
    {
        $canShowOnAdmin = !$citizenCharter->can_show_on_admin;

        $citizenCharter->update([
            'can_show_on_admin' => $canShowOnAdmin,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);
    }
}
