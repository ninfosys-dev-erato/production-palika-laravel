<?php

namespace Src\TaskTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TaskTracking\DTO\AnusuchiAdminDto;
use Src\TaskTracking\Models\Anusuchi;

class AnusuchiAdminService
{
    public function store(AnusuchiAdminDto $anusuchiAdminDto)
    {
        return Anusuchi::create([
            'name' => $anusuchiAdminDto->name,
            'name_en' => $anusuchiAdminDto->name_en,
            'description' => $anusuchiAdminDto->description,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Anusuchi $anusuchi, AnusuchiAdminDto $anusuchiAdminDto)
    {
        return tap($anusuchi)->update([
            'name' => $anusuchiAdminDto->name,
            'name_en' => $anusuchiAdminDto->name_en,
            'description' => $anusuchiAdminDto->description,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Anusuchi $anusuchi)
    {
        return tap($anusuchi)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Anusuchi::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function storeReport() {}
}
