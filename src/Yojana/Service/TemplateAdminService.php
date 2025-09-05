<?php

namespace Src\Yojana\Service;

use App\Facades\PdfFacade;
class TemplateAdminService
{
    public function getLetter($letter, $model): mixed
    {
        try {
            $html = $letter;

            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Yojana.yojana.certificate'),
                file_name: "yojana_{$model->id}",
                disk: getStorageDisk('private'),
            );
            
           return $url;
        } catch (\Exception $exception) {
          return false;
        }
    }
}
