<?php

namespace Src\DigitalBoard\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\DigitalBoard\Models\Video;

class VideosExport implements FromCollection
{
    public $videos;

    public function __construct($videos)
    {
        $this->videos = $videos;
    }

    public function collection()
    {
        return Video::select([
            'title',
            'url',
            'can_show_on_admin'
        ])
            ->whereIn('id', $this->videos)->get();
    }
}
