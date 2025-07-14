<?php

namespace App\Services;

use App\Facades\FileFacade;
use Illuminate\Support\Facades\File;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class PdfService
{
    const STYLE = "<style>

    @font-face {
  font-family: 'Kokila';
  font-style: normal;
  font-weight: normal;
  src: url('{{ public_path('fonts/Kokila.ttf') }}') format('truetype');
}
    
      * {
    font-family: 'Kokila', sans-serif !important;
  }
       body {
            font-family: Kokila;
      
        }
.text-center {
    text-align: center;
}

.text-justify {
    text-align: justify;
}

.text-right {
    text-align: right;
}
.full {
  width: 100%;
}.full {
  width: 100%;
}
.sm{
font-size: 1.7rem;
}
.text-justify {
  text-align: justify;
  text-justify: inter-word;
  text-align-last: justify;
  hyphens: auto;
}
.border-top:{
border-top: 1px solid black;
}
.sign{
width: 10rem;
}
.red{
color: red;
}
.black{
color: black;
}
.mt{
margin-top:1.5rem;
}
.underline{
text-decoration: underline;
}


</style>";

    public function savePdf(string $content, string $file_path, string $file_name = 'document.pdf', string $disk = 'public', bool $is_draft = false, $styles = ""): string
    {
        $pdf = PDF::loadView('template.print', ['html' => "<html><head>{$styles}</head>" . self::STYLE . "<body>" . $this->replacePTagsWithBr($content) . "</body></html>"]);

        if ($is_draft) {
            $pdf->getMpdf()->SetWatermarkText('DRAFT');
            $pdf->getMpdf()->showWatermarkText = true;
        }
        $file = $pdf->getMpdf()->output('document.pdf', 'S');
        $storedFileName = FileFacade::saveFile(
            $file_path,
            $file_name,
            $file,
            $disk
        );
        return $storedFileName;
    }

    public function saveAndStream(string $content, string $file_path, string $file_name = 'document.pdf', string $disk = 'public', bool $is_draft = false, $styles = ""): string
    {

        $content = preg_replace('/<p>\s*&nbsp;\s*<\/p>/i', '', $content, 1);
        $html = "<html><head><meta charset='UTF-8'/>{$styles}" . self::STYLE . "</head><body>{$content}</body></html>";



        $pdf = PDF::loadView('template.print', ['html' => $html]);
        if ($is_draft) {
            $pdf->getMpdf()->SetWatermarkText('DRAFT');
            $pdf->getMpdf()->showWatermarkText = true;
        }
        $pdf->getMpdf()->shrink_tables_to_fit = 1;
        //        $pdf->getMpdf()->ignore_table_width =true;
        $file = $pdf->getMpdf()->output('document.pdf', 'S');
        $storedFileName = FileFacade::saveFile(
            $file_path,
            $file_name,
            $file,
            $disk
        );
        return FileFacade::getTemporaryUrl($file_path, $storedFileName, $disk);
    }

    public function addToPdf(File $file, string $content, string $file_path, string $file_name = 'document.pdf', string $disk = 'public') {}

    function remotePTags($html)
    {
        // Unwrap all <p> tags — keep their inner content but remove the tags
        $html = preg_replace('/<p[^>]*>(.*?)<\/p>/is', '$1', $html);

        return $html;
    }

    function replacePTagsWithBr($html)
    {
        // Replace <p> opening tags with nothing (remove them)
        $html = preg_replace('/<p[^>]*>/i', '', $html);
        // Replace </p> closing tags with <br>
        $html = preg_replace('/<\/p>/i', '<br>', $html);
        return $html;
    }
}
