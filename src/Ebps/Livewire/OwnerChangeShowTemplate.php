<?php

namespace Src\Ebps\Livewire;

use App\Facades\PdfFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ebps\Models\HouseOwnerDetail;
use Livewire\Attributes\On;

class OwnerChangeShowTemplate extends Component
{
    use SessionFlash;
    public $houseOwnerId;
    public ?HouseOwnerDetail $houseOwnerDetail;
    public $oldHouseOwnerDetail;
    public $letter;

    public function render(){
        return view("Ebps::livewire.show-owner-template");
    }

    public function mount(int $houseOwnerId, HouseOwnerDetail $houseOwnerDetail)
    {
        $this->houseOwnerDetail = HouseOwnerDetail::find($houseOwnerId);
        if($this->houseOwnerDetail->parent_id){
            $this->oldHouseOwnerDetail = HouseOwnerDetail::find($this->houseOwnerDetail->parent_id);
        }
      
    }

    #[On('print-owner-template')]
    public function  printTemplate($html)
    {
        try {
            // Read the Bootstrap CSS file from the public directory
            $bootstrapCSS = file_get_contents(public_path('home/css/bootstrap.min.css'));

            $fullHtml =
                '<!DOCTYPE html>
                <html lang="ne">
                <head>
                    <meta charset="UTF-8">
                    <style>' . $bootstrapCSS . '</style>
                    <style>
                        /* Custom styles */
                        body { font-family: "Mangal", sans-serif; font-size: 14px; }
                    </style>
                </head>
                <body>'
                . $html .
                '</body>
                </html>';

            // Generate the PDF and stream it
            $url = PdfFacade::saveAndStream(
                content: $fullHtml,
                file_path: config('src.Ebps.ebps.pdf'),
                file_name: "ejalas" . date('YmdHis'),
                disk: getStorageDisk('private'),
            );

            return redirect()->away($url);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash('Something went wrong while saving.', $e->getMessage());
        }
    }

}
