<?php

namespace Src\Beruju\Service;

use Illuminate\Support\Facades\Auth;
use Src\Beruju\DTO\SubCategoryAdminDto;
use Src\Beruju\Models\SubCategory;

class SubCategoryAdminService
{
    public function store(SubCategoryAdminDto $subCategoryAdminDto){
        return SubCategory::create([
            'name_eng' => $subCategoryAdminDto->name_eng,
            'name_nep' => $subCategoryAdminDto->name_nep,
            'slug' => $subCategoryAdminDto->slug,
            'parent_id' => $subCategoryAdminDto->parent_id,
            'parent_name_eng' => $subCategoryAdminDto->parent_name_eng,
            'parent_name_nep' => $subCategoryAdminDto->parent_name_nep,
            'parent_slug' => $subCategoryAdminDto->parent_slug,
            'remarks' => $subCategoryAdminDto->remarks,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(SubCategory $subCategory, SubCategoryAdminDto $subCategoryAdminDto){
        return tap($subCategory)->update([
            'name_eng' => $subCategoryAdminDto->name_eng,
            'name_nep' => $subCategoryAdminDto->name_nep,
            'slug' => $subCategoryAdminDto->slug,
            'parent_id' => $subCategoryAdminDto->parent_id,
            'parent_name_eng' => $subCategoryAdminDto->parent_name_eng,
            'parent_name_nep' => $subCategoryAdminDto->parent_name_nep,
            'parent_slug' => $subCategoryAdminDto->parent_slug,
            'remarks' => $subCategoryAdminDto->remarks,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(SubCategory $subCategory){
        return tap($subCategory)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids){
         $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        SubCategory::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
