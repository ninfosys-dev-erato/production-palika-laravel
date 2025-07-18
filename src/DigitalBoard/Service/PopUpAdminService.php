<?php

namespace Src\DigitalBoard\Service;

use Illuminate\Support\Facades\Auth;
use Src\DigitalBoard\DTO\PopUpAdminDto;
use Src\DigitalBoard\Models\PopUp;

class PopUpAdminService
{
    public function store(PopUpAdminDto $popUpAdminDto)
    {
        return PopUp::create([
            'title' => $popUpAdminDto->title,
            'photo' => $popUpAdminDto->photo,
            'is_active' => $popUpAdminDto->is_active,
            'display_duration' => $popUpAdminDto->display_duration,
            'iteration_duration' => $popUpAdminDto->iteration_duration,
            'can_show_on_admin' => $popUpAdminDto->can_show_on_admin,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(PopUp $popUp, PopUpAdminDto $popUpAdminDto)
    {
        return tap($popUp)->update([
            'title' => $popUpAdminDto->title,
            'photo' => $popUpAdminDto->photo,
            'is_active' => $popUpAdminDto->is_active,
            'display_duration' => $popUpAdminDto->display_duration,
            'iteration_duration' => $popUpAdminDto->iteration_duration,
            'can_show_on_admin' => $popUpAdminDto->can_show_on_admin,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(PopUp $popUp)
    {
        return tap($popUp)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        PopUp::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function storePopupWards(PopUp $popup, array $wards)
    {
        $popup->wards()->delete();
        $wardData = array_map(fn($wardId) => ['ward' => $wardId], $wards);
        $popup->wards()->createMany($wardData);
    }

    public function toggleCanShowOnAdmin(PopUp $popUp): void
    {
        $canShowOnAdmin = !$popUp->can_show_on_admin;

        $popUp->update([
            'can_show_on_admin' => $canShowOnAdmin,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);
    }

    public function toggleIsActive(Popup $popUp)
    {
        $isActive = !$popUp->is_active;

        $popUp->update([
            'is_active' => $isActive,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);
    }
}
