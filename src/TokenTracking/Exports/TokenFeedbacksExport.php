<?php

namespace Src\TokenTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TokenTracking\Models\TokenFeedback;

class TokenFeedbacksExport implements FromCollection
{
    public $token_feedbacks;

    public function __construct($token_feedbacks) {
        $this->token_feedbacks = $token_feedbacks;
    }

    public function collection()
    {
        return TokenFeedback::select([
'token_id',
'feedback',
'rating'
])
        ->whereIn('id', $this->token_feedbacks)->get();
    }
}


