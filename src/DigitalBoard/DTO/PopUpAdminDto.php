<?php

namespace Src\DigitalBoard\DTO;

use Src\DigitalBoard\Models\PopUp;

class PopUpAdminDto
{
    public function __construct(
        public string $title,
        public string $photo,
        public bool $is_active,
        public int $display_duration,
        public int $iteration_duration,
        public bool $can_show_on_admin
    ) {}

    public static function fromLiveWireModel(PopUp $popUp): PopUpAdminDto
    {
        return new self(
            title: $popUp->title,
            photo: $popUp->photo,
            is_active: $popUp->is_active,
            display_duration: $popUp->display_duration,
            iteration_duration: $popUp->iteration_duration,
            can_show_on_admin: $popUp->can_show_on_admin
        );
    }
}
