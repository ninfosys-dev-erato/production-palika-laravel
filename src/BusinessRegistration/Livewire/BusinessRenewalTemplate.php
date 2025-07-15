<?php

namespace Src\BusinessRegistration\Livewire;

use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use App\Traits\HelperDate;
use Livewire\Component;
use Livewire\Attributes\On;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Service\BusinessRenewalAdminService;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;

class BusinessRenewalTemplate extends Component
{
    use HelperDate, BusinessRegistrationTemplate;
    public BusinessRenewal $renewal;

    public function mount(BusinessRenewal $businessRenewal)
    {
        $this->renewal = $businessRenewal;
    }

    public function render()
    {
        return view("BusinessRegistration::livewire.renewal.template", [
            'registrationCertificate' => $this->resolveTemplate($this->renewal->registration),
            'renewalCertificate' => $this->getTemplate(),
        ]);
    }

    public function getTemplate()
    {
        return '
        <div style="page-break-before: always;">
        <div style="text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 10px;">
            नवीकरण गरिएको प्रमाण
        </div>
        
        <table border="1" width="100%" style="border-collapse: collapse; text-align: center; border: 2px solid black;">
            <thead>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <th style="padding: 10px; border: 2px solid black;">आर्थिक वर्ष</th>
                    <th style="padding: 10px; border: 2px solid black;">नबिकरण गरेको मिति</th>
                    <th style="padding: 10px; border: 2px solid black;">कर तथा सुल्क र जरिवाना तिरेको रसिद नं </th>
                    <th style="padding: 10px; border: 2px solid black;">रसिदको मिति </th>
                    <th style="padding: 10px; border: 2px solid black;">नबिकरण गर्नेको दस्तखत</th>
                </tr>
            </thead>
            <tbody>
                ' . $this->generateTableRows() . '
            </tbody>
        </table>

        <div style="margin-top: 10px; font-size: 14px;">
            <strong>टिप्पणी:</strong> चालको व्यवसाय अनुसार दर्ता प्रमाणपत्र (लाइसेन्स) वा नवीकरण भएको प्रमाणपत्र सम्बन्धित अवधिको समाप्ति: 
            ५ बर्ष र २ बर्षको लागि हुन्छ। सो अवधि समाप्त भए अनिवार्य रूपमा नवीकरण गराउनुपर्ने छ। यो प्रमाणपत्रको सत्यताका लागि अन्य 
            प्रमाण-पत्र आवश्यक पर्न सक्छ। नवीकरण नगरिएमा व्यवसाय नै प्रमाण-पत्र बिहिन ठहर हुनेछ। सबै प्रमाण-पत्रहरु सम्बन्धित कार्यालयबाट 
            नवीकरण भएको निस्सा राख्नुपर्छ। सावधानी नवीकरण सम्बन्धमा उद्योग दर्ताको धारामा ट्रयाक गर्नुहोस्।
        </div>
        </div>
    ';
    }

    private function generateTableRows(): string
    {
        $renewal = $this->renewal->load('fiscalYear');
        $fiscalYear = $this->renewal->fiscalYear->year ?? '';
        $renewalDate = $this->renewal->renew_date ?? '';
        $billNo = $this->renewal->bill_no ?? '';
        $payment_date = $this->renewal->payment_receipt_date ?? '';

        // $renewDuration = $this->getRenewalDuration();
        // $billNo = $renewal->bill_no ?? 'N/A';
        // $payment_date = $this->convertEnglishToNepali($renewal->payment_receipt_date) ?? 'N/A';
        // $approvedBy = $renewal->approvedBy?->name ?? 'N/A';

        // $acceptorSignature = '______________________';
        // if (!empty($renewal->approved_by) && !empty($renewal->approvedBy?->signature)) {
        //     $acceptorSignature = '<img src="data:image/jpeg;base64,' . base64_encode(ImageServiceFacade::getImage(config('src.Profile.profile.path'), $renewal->approvedBy->signature)) . '"
        //                  alt="Signature" width="80">';
        // }

        return "
    <tr>
        <td style='padding: 10px; border: 2px solid black;'>{$fiscalYear}</td>
        <td style='padding: 10px; border: 2px solid black;'>{$renewalDate}</td>
        <td style='padding: 10px; border: 2px solid black;'>{$billNo}</td>
        <td style='padding: 10px; border: 2px solid black;'>{$payment_date}</td>
        <td style='padding: 10px; border: 2px solid black;'></td>

    </tr>
";
    }


    private function getRenewalDuration()
    {
        $renewal = $this->renewal;
        $renewDate = $renewal->renew_date_en ?? null;
        $dateToBeMaintained = $renewal->date_to_be_maintained_en ?? null;

        if (!$renewDate || !$dateToBeMaintained) {
            return "N/A";
        }

        $startDate = new \DateTime($renewDate);
        $endDate = new \DateTime($dateToBeMaintained);
        $interval = $startDate->diff($endDate);

        $years = $interval->y ? "{$interval->y} बर्ष" : "";
        $months = $interval->m ? "{$interval->m} महिना" : "";
        $days = $interval->d ? "{$interval->d} दिन" : "";

        $parts = array_filter([$years, $months, $days]);
        $durationText = implode(", ", $parts);

        return "({$durationText})";
    }

    #[On('print-renewal')]
    public function print()
    {
        $service = new BusinessRenewalAdminService();
        return $service->getLetter($this->renewal, $this->getTemplate(), 'web');
    }
}
