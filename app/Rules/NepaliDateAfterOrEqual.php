<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Traits\HelperDate;

class NepaliDateAfterOrEqual implements Rule
{
    use HelperDate;

    protected $startDate;
    protected $message;

    public function __construct($startDate)
    {
        $this->startDate = $startDate;
    }

    public function passes($attribute, $value)
    {
        if (!$this->startDate || !$value) {
            return false;
        }

        try {


            // Convert BS to AD using HelperDate trait
            $startDateAD = $this->bsToAd($this->startDate, "Y-m-d");
            $endDateAD = $this->bsToAd($value, "Y-m-d");

            // Compare the converted dates
            return strtotime($endDateAD) >= strtotime($startDateAD);
        } catch (\Exception $e) {
            $this->message = "Invalid Nepali date format.";
            return false;
        }
    }

    public function message()
    {
        return $this->message ?? 'The recurrence end date must be after or equal to the start date.';
    }
}
