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

        if (getSetting('show-letter-watermark')) {
            $this->setWatermarkImage($pdf);
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

        if (getSetting('show-letter-watermark')) {
            $this->setWatermarkImage($pdf);
        }

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


    private function setWatermarkImage($pdf): void
    {
        try {
            $campaignLogo = getSetting('palika-campaign-logo');

            if (empty($campaignLogo)) {
                return; // No watermark if no image available
            }

            // Check if it's a base64 image
            if (strpos($campaignLogo, 'data:image/') === 0) {
                $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $campaignLogo);
                // Clean the base64 string to remove any null bytes or invalid characters
                $base64Image = preg_replace('/[^A-Za-z0-9+\/=]/', '', $base64Image);
                $imageData = base64_decode($base64Image, true); // Use strict mode

                if ($imageData !== false && !empty($imageData)) {
                    $tempFile = tempnam(sys_get_temp_dir(), 'watermark_');
                    if (file_put_contents($tempFile, $imageData) !== false) {
                        $pdf->getMpdf()->SetWatermarkImage($tempFile, 0.3);
                        $pdf->getMpdf()->showWatermarkImage = true;
                        // Clean up temp file after PDF generation
                        register_shutdown_function(function () use ($tempFile) {
                            if (file_exists($tempFile)) {
                                unlink($tempFile);
                            }
                        });
                    }
                }
            } else {
                // Handle file path/image URL
                if (filter_var($campaignLogo, FILTER_VALIDATE_URL)) {
                    // It's a URL, download the image
                    $imageData = file_get_contents($campaignLogo);
                    if ($imageData !== false && !empty($imageData)) {
                        // Create a temporary file to avoid null byte issues
                        $tempFile = tempnam(sys_get_temp_dir(), 'watermark_');
                        if (file_put_contents($tempFile, $imageData) !== false) {
                            $pdf->getMpdf()->SetWatermarkImage($tempFile, 0.3);
                            $pdf->getMpdf()->showWatermarkImage = true;
                            // Clean up temp file after PDF generation
                            register_shutdown_function(function () use ($tempFile) {
                                if (file_exists($tempFile)) {
                                    unlink($tempFile);
                                }
                            });
                        }
                    }
                } else {
                    // It's a local file path
                    $fullPath = public_path($campaignLogo);
                    if (file_exists($fullPath)) {
                        $pdf->getMpdf()->SetWatermarkImage($fullPath, 0.3);
                        $pdf->getMpdf()->showWatermarkImage = true;
                    }
                }
            }
        } catch (\Exception $e) {
            // Silently fail - no watermark if there's an error
        }
    }
}
