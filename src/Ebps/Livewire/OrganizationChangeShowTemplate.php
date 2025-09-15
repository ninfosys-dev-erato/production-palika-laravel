<?php

namespace Src\Ebps\Livewire;

use App\Facades\PdfFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ebps\Models\HouseOwnerDetail;
use Livewire\Attributes\On;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\Organization;
use Src\Ebps\Models\OrganizationDetail;

class OrganizationChangeShowTemplate extends Component
{
    use SessionFlash;
    public $organizationId;
    public $newOrganization;
    public $mapApplyId;
    public ?Organization $organization;
    public $oldOrganizationDetail;
    public $letter;
    public ?MapApply $mapApply;

    public function render(){
        return view("Ebps::livewire.show-organization-template");
    }

    public function mount(int $organizationId, int $mapApplyId, Organization $organization)
    {

        
        $this->organization = Organization::find($organizationId);
        $this->newOrganization = OrganizationDetail::where('organization_id', $organizationId)->where('map_apply_id', $mapApplyId)->first();

      
        if($this->newOrganization->parent_id){
            $this->oldOrganizationDetail = Organization::find($this->newOrganization->parent_id);
        }
        $this->mapApply = MapApply::where('id', $mapApplyId)->first();
      
    }

    #[On('print-organization-template')]
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
