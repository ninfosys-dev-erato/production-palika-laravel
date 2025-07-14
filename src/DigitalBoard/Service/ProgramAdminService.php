<?php

namespace Src\DigitalBoard\Service;

use Illuminate\Support\Facades\Auth;
use Src\DigitalBoard\DTO\ProgramAdminDto;
use Src\DigitalBoard\Models\Program;

class ProgramAdminService
{
    public function store(ProgramAdminDto $programAdminDto)
    {
        return Program::create([
            'title' => $programAdminDto->title,
            'photo' => $programAdminDto->photo,
            'can_show_on_admin' => $programAdminDto->can_show_on_admin,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Program $program, ProgramAdminDto $programAdminDto)
    {
        return tap($program)->update([
            'title' => $programAdminDto->title,
            'photo' => $programAdminDto->photo,
            'can_show_on_admin' => $programAdminDto->can_show_on_admin,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Program $program)
    {
        return tap($program)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Program::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function toggleCanShowOnAdmin(Program $program): void
    {
        $canShowOnAdmin = !$program->can_show_on_admin;

        $program->update([
            'can_show_on_admin' => $canShowOnAdmin,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);
    }


    public function storeProgramWard(Program $program, array $wards): void
    {
        $program->wards()->delete();
        $wardData = array_map(fn($wardId) => ['ward' => $wardId], $wards);
        $program->wards()->createMany($wardData);
    }

    public function deleteProgramWards(Program $program)
    {
        $program->wards()?->delete();
    }
}
