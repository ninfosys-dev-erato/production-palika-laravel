<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\ComplaintRegistrationAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\DisputeArea;
use Src\Ejalas\Models\DisputeMatter;
use Src\Ejalas\Models\Priotity;
use Src\Ejalas\Service\ComplaintRegistrationAdminService;
use Src\Ejalas\Service\ReportAdminService;
use Src\FiscalYears\Models\FiscalYear;
use Src\Ejalas\Models\Party;
use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Src\Wards\Models\Ward;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use Src\Settings\Traits\AdminSettings;
use Carbon\Carbon;

class ComplaintRegistrationLetter extends Component
{
    use SessionFlash, HelperDate, AdminSettings;


    public ComplaintRegistration $complaintRegistration;
    public  $complainers;
    public  $defenders;

    public function render()
    {
        return view("Ejalas::livewire.complaint-registration.letter");
    }

    public function mount($id)
    {
        $this->complaintRegistration = ComplaintRegistration::with(['disputeMatter', 'priority', 'fiscalYear', 'parties.permanentDistrict', 'parties.permanentLocalBody', 'parties.temporaryDistrict', 'parties.temporaryLocalBody', 'disputeMatter.disputeArea'])->findOrFail($id);;
        $this->complainers = $this->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
        $this->defenders =  $this->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');
        $this->complaintRegistration->reg_date_nepali = replaceNumbers($this->adToBs($this->complaintRegistration->reg_date), true);
    }

    public function downloadPdf($html)
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
                file_path: config('src.Ejalas.ejalas.pdf'),
                file_name: "ejalas" . date('YmdHis'),
                disk: "local",
            );

            return redirect()->away($url);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash('Something went wrong while saving.', $e->getMessage());
        }
    }
}
