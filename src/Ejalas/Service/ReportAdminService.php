<?php

namespace Src\Ejalas\Service;

use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Src\Wards\Models\Ward;
use App\Facades\GlobalFacade;
use App\Traits\SessionFlash;
use Carbon\Carbon;
use Src\Settings\Traits\AdminSettings;

class ReportAdminService
{
    use SessionFlash, HelperDate, AdminSettings;
    public function commonDataForReport()
    {
        $user = Auth::user();
        $ward = Ward::where('id', GlobalFacade::ward())->first();
        $palika_name = $this->getConstant('palika-name');
        $palika_logo = $this->getConstant('palika-logo');
        $palika_campaign_logo = $this->getConstant('palika-campaign-logo');
        $address = $this->getConstant('palika-district') . ', ' . $this->getConstant('palika-province') . ', ' . 'नेपाल';
        $palika_ward = $ward ? $ward->ward_name_ne : getSetting('office_name');
        $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));

        return compact(
            'user',
            'ward',
            'palika_name',
            'palika_logo',
            'palika_campaign_logo',
            'address',
            'palika_ward',
            'nepaliDate'
        );
    }
    public function getReport($html)
    {
        try {
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Ejalas.ejalas.pdf'),
                file_name: "ejalas" . date('YmdHis'),
                disk: "local",
            );

            return redirect()->away($url);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.')), $e->getMessage());
        }
    }
}
