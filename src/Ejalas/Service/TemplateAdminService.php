<?php

namespace Src\Ejalas\Service;

use App\Facades\PdfFacade;

class TemplateAdminService
{
    public function getLetter($letter, $model, $style)
    {
        try {
            $html = $letter;
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Ejalas.ejalas.certificate'),
                file_name: "ejalas_" . class_basename($model) . "_{$model->id}",
                disk: "local",
                styles: $style
            );

            // return redirect()->away($url);
            return $url;
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
