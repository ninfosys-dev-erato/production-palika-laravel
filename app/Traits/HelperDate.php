<?php

namespace App\Traits;

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use App\Services\NepaliCalendarService;
use Anuzpandey\LaravelNepaliDate\Enums\NepaliMonth;
use Illuminate\Support\Facades\Cache;

trait HelperDate
{
    protected $service;
    public function __construct()
    {
        $this->service = new NepaliCalendarService();
    }

    public function adToBs(\DateTime|string $inputDate, $format = "yyyy-mm-dd"): bool | string
    {
        try {
            $inputDate = $this->convertNepaliToEnglish($inputDate);
            return LaravelNepaliDate::from($inputDate)->toNepaliDate();
            // Parse the input date into a DateTime object
//            $date = new \DateTime($inputDate);
//            // Extract year, month, and day
//            $yy = $date->format('Y');
//            $mm = $date->format('m');
//            $dd = $date->format('d');
//
//            // Call the service method with parsed date components
//            return $this->_formatDate($this->service->get_nepali_date(year: $yy, month: $mm, day: $dd), $format);
        } catch (\Exception $e) {
            // Handle invalid date formats
            return false;
        }
    }

    public function bsToAd(\DateTime|string $inputDate, $format = "yyyy-mm-dd"): bool | string
    {
        try {
            $inputDate = $this->convertNepaliToEnglish($inputDate);
            [$yy, $mm, $dd] = explode('-', $inputDate);

//            return LaravelNepaliDate::from($inputDate)->toEnglishDate();
            // Parse the input date into a DateTime object
//            $date = new \DateTime($inputDate);
//
//            // Extract year, month, and day
//            $yy = $date->format('Y');
//            $mm = $date->format('m');
//            $dd = $date->format('d');
//
//            // Call the service method with parsed date components
            return  $this->_formatDate($this->service->get_eng_date(year: $yy, month: $mm, day: $dd), $format);
        } catch (\Exception $e) {
            // Handle invalid date formats
            return false;
        }
    }

    function _formatDate($date, $format): string
    {
        $formattedDate = str_replace("yyyy", $date['y'], $format);
        $formattedDate = str_replace("mm", str_pad($date['m'], 2, '0', STR_PAD_LEFT), $formattedDate);
        $formattedDate = str_replace("dd", str_pad($date['d'], 2, '0', STR_PAD_LEFT), $formattedDate);
        $formattedDate = str_replace("MM", $date['M'], $formattedDate);
        $formattedDate = str_replace("l", $date['l'], $formattedDate);
        return $formattedDate;
    }

    private function convertNepaliToEnglish($date): string
    {
        $nepaliNumbers = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($nepaliNumbers, $englishNumbers, $date);
    }

    private function convertEnglishToNepali($date): string
    {
        $nepaliNumbers = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($englishNumbers, $nepaliNumbers, $date);
    }

    private function getNepaliMonths(){
// month can be NepaliMonth::XXX or month number (1-12)
        return NepaliMonth::cases();
    }

    public function getNepaliYearMonthRanges(int $bsYear = 0): array
    {
        if ($bsYear === 0) {
            $bsYear = $this->getCurrentNepaliYear();
        }

        return Cache::remember("nepali_month_ranges_{$bsYear}", now()->addDays(365), function () use ($bsYear) {
            $months = $this->getNepaliMonths();
            $monthRanges = [];

            foreach ($months as $index => $month) {
                $monthNumber = is_numeric($month) ? (int)$month : $month->value;
                $bsStartDate = sprintf('%04d-%02d-01', $bsYear, $monthNumber);
                $adStart = $this->bsToAd($bsStartDate);

                // Find valid last day of this month in BS
                $endAd = null;
                for ($day = 32; $day >= 28; $day--) {
                    $bsEndDate = sprintf('%04d-%02d-%02d', $bsYear, $monthNumber, $day);
                    $converted = $this->bsToAd($bsEndDate);
                    if ($converted !== false) {
                        $endAd = $converted;
                        break;
                    }
                }

                $monthRanges[] = [
                    'bs_month'  => $month->name,
                    'bs_year'   => $bsYear,
                    'start_ad'  => $adStart,
                    'end_ad'    => $endAd,
                ];
            }

            return $monthRanges;
        });
    }
    public function getCurrentNepaliYear(): int
    {
        $today = now(); // or new \DateTime()
        $yy = $today->format('Y');
        $mm = $today->format('m');
        $dd = $today->format('d');

        $bsDate = $this->service->get_nepali_date($yy, $mm, $dd);
        return (int) $bsDate['y']; // assuming it returns ['year' => 2081, ...]
    }

}
