<?php

namespace Src\BusinessRegistration\Service;

use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\DTO\CertificatePratilipiLogDto;
use Src\BusinessRegistration\Models\CertificatePratilipiLog;

class CertificatePratilipiLogService
{
    use HelperDate;
    public function store(CertificatePratilipiLogDto $dto): CertificatePratilipiLog|bool
    {
        $certificatePratilipiLog = CertificatePratilipiLog::create([
            'user_id' => $dto->user_id,
            'business_registration_id' => $dto->business_registration_id,
            'damage_reason' => $dto->damage_reason,
            'entry_date' => replaceNumbers($this->adToBs(date('Y-m-d')), true),
            'created_at' => date('Y-m-d'),
            'created_by' => $dto->created_by ?? Auth::user()?->id,
        ]);

        return $certificatePratilipiLog;
    }

    public function update(CertificatePratilipiLog $certificatePratilipiLog, CertificatePratilipiLogDto $dto): CertificatePratilipiLog|bool
    {
        $certificatePratilipiLog = tap($certificatePratilipiLog)->update([
            'user_id' => $dto->user_id,
            'business_registration_id' => $dto->business_registration_id,
            'damage_reason' => $dto->damage_reason,
            'entry_date' => replaceNumbers($this->adToBs(date('Y-m-d')), true),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $dto->updated_by ?? Auth::user()?->id,
        ]);

        return $certificatePratilipiLog;
    }

    public function delete(CertificatePratilipiLog $certificatePratilipiLog): CertificatePratilipiLog|bool
    {
        $certificatePratilipiLog = tap($certificatePratilipiLog)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()?->id
        ]);

        return $certificatePratilipiLog;
    }
}
