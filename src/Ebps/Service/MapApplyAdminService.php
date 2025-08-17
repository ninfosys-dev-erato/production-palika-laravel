<?php

namespace Src\Ebps\Service;

use App\Facades\PdfFacade;
use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\MapApplyAdminDto;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapApplyStepTemplate;
use Src\Settings\Models\Form;

class MapApplyAdminService
{
public function store(MapApplyAdminDto $mapApplyAdminDto){
    
    return MapApply::create([
        'submission_id' => $mapApplyAdminDto->submission_id,
        'registration_date' => $mapApplyAdminDto->registration_date,
        'registration_no' => $mapApplyAdminDto->registration_no,
        'fiscal_year_id' => $mapApplyAdminDto->fiscal_year_id,
        'customer_id' => $mapApplyAdminDto->customer_id,
        'land_detail_id' => $mapApplyAdminDto->land_detail_id,
        'construction_type_id' => $mapApplyAdminDto->construction_type_id,
        'usage' => $mapApplyAdminDto->usage,
        'is_applied_by_customer' => $mapApplyAdminDto->is_applied_by_customer,
        'full_name' => $mapApplyAdminDto->full_name,
        'age' => $mapApplyAdminDto->age,
        'applied_date' => $mapApplyAdminDto->applied_date,
        'signature' => $mapApplyAdminDto->signature,
        'application_type' => $mapApplyAdminDto->application_type,
        'map_process_type' => $mapApplyAdminDto->map_process_type,
        'building_structure' => $mapApplyAdminDto->building_structure,
        'house_owner_id' => $mapApplyAdminDto->house_owner_id,
        'land_owner_id' => $mapApplyAdminDto->land_owner_id,
        'area_of_building_plinth' => $mapApplyAdminDto->area_of_building_plinth,
        'applicant_type' => $mapApplyAdminDto->applicant_type ,
        'no_of_rooms' => $mapApplyAdminDto->no_of_rooms,
        'storey_no'=> $mapApplyAdminDto->storey_no,
        'year_of_house_built'=> $mapApplyAdminDto->year_of_house_built,
        'mobile_no' => $mapApplyAdminDto->mobile_no,
        'province_id' => $mapApplyAdminDto->province_id,
        'district_id' => $mapApplyAdminDto->district_id,
        'local_body_id' => $mapApplyAdminDto->local_body_id,
        'ownership_type' => $mapApplyAdminDto->ownership_type,
        'ward_no' => $mapApplyAdminDto->ward_no,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}
public function update(MapApply $mapApply, MapApplyAdminDto $mapApplyAdminDto){

    return tap($mapApply)->update([
        'submission_id' => $mapApplyAdminDto->submission_id,
        'registration_date' => $mapApplyAdminDto->registration_date,
        'registration_no' => $mapApplyAdminDto->registration_no,
        'fiscal_year_id' => $mapApplyAdminDto->fiscal_year_id,
        'customer_id' => $mapApplyAdminDto->customer_id,
        'land_detail_id' => $mapApplyAdminDto->land_detail_id,
        'construction_type_id' => $mapApplyAdminDto->construction_type_id,
        'usage' => $mapApplyAdminDto->usage,
        'is_applied_by_customer' => $mapApplyAdminDto->is_applied_by_customer,
        'full_name' => $mapApplyAdminDto->full_name,
        'age' => $mapApplyAdminDto->age,
        'applied_date' => $mapApplyAdminDto->applied_date,
        'signature' => $mapApplyAdminDto->signature,
        'ownership_type' => $mapApplyAdminDto->ownership_type,
        'updated_at' => date('Y-m-d H:i:s'),
        // 'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MapApply $mapApply){
    return tap($mapApply)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapApply::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}

public function getLetter(MapApplyStepTemplate $mapApplyStepTemplate, $request = 'web')
    {
        try {
            $html = $mapApplyStepTemplate->template;
            $form = Form::findOrFail($mapApplyStepTemplate->form_id);

            $fileName = "map.pdf";
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Recommendation.recommendation.certificate'),
                file_name: $fileName,
                disk: 'local',
                styles:$form?->styles ?? ""
            );
            if ($request === 'web') {
                return redirect()->away($url);
            }
            return $url;  
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}


