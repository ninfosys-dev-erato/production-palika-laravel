<?php

namespace Src\Yojana\Service;

use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Src\Settings\Traits\AdminSettings;
use Src\Wards\Models\Ward;

class ReportAdminService
{
    use AdminSettings, HelperDate;
    public function getDownloadData($html)
    {
        try {
            $user = Auth::user();
            $ward = Ward::where('id', GlobalFacade::ward())->first();
            $palika_name = $this->getConstant('palika-name');
            $palika_logo = $this->getConstant('palika-logo');
            $palika_campaign_logo = $this->getConstant('palika-campaign-logo');

            $address = $this->getConstant('palika-district') . ', ' . $this->getConstant('palika-province') . ', ' . 'नेपाल';
            $palika_ward = $ward ? $ward->ward_name_ne : getSetting('office_name');
            $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Yojana.yojana.certificate'),
                file_name: "yojana" . date('YmdHis'),
                disk: "local",
            );
            return redirect()->away($url);
        } catch (\Throwable $e) {
            logger($e->getMessage());
        }
    }
}
