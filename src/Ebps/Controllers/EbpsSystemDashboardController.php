<?php

namespace Src\Ebps\Controllers;

use App\Facades\PdfFacade;
use App\Http\Controllers\Controller;
use App\Traits\HelperTemplate;
use App\Traits\MapApplyTrait;
use Illuminate\Http\Request;
use Src\Ebps\Models\Organization;
use Src\Ebps\Models\MapApply;
use Illuminate\Support\Facades\DB;
use Src\Ebps\Models\MapStep;
use Src\Settings\Models\Form;

class EbpsSystemDashboardController extends Controller
{
    use MapApplyTrait, HelperTemplate;
    function index(Request $request)
    {
        try {
            $OrganizationCount = Organization::whereNull('deleted_at')->count();
            $MapApply = MapApply::whereNull('deleted_at')->count();

            $totalSteps = MapStep::whereNull('deleted_at')->count();

            $CompletedMapApply = DB::table('ebps_map_apply_steps')
                ->select('map_apply_id')
                ->groupBy('map_apply_id')
                ->havingRaw('COUNT(DISTINCT map_step_id) = ?', [$totalSteps])
                ->count();

            $ProcessingMapApply = DB::table('ebps_map_apply_steps')
                ->select('map_apply_id')
                ->groupBy('map_apply_id')
                ->havingRaw('COUNT(DISTINCT map_step_id) < ?', [$totalSteps])
                ->count();

            // 👇 Fetch application count per map step
            $stepCounts = DB::table('ebps_map_apply_steps')
                ->select('map_step_id', DB::raw('COUNT(DISTINCT map_apply_id) as application_count'))
                ->groupBy('map_step_id')
                ->pluck('application_count', 'map_step_id');

            $allSteps = MapStep::whereNull('deleted_at')->orderBy('id')->pluck('title', 'id');


            $EbpsChart = [];
            foreach ($allSteps as $id => $stepTitle) {
                $EbpsChart[$stepTitle] = $stepCounts[$id] ?? 0;
            }



        } catch (\Exception $e) {
         
            return redirect()->route('admin.storey_details.index');
        }

        return view('Ebps::dashboard', compact(
            'OrganizationCount',
            'MapApply',
            'CompletedMapApply',
            'ProcessingMapApply',
            'EbpsChart'
        ));
    }

    function report()
    {
        return view('Ebps::report');
    }

    function template($formId)
    {
        $form = Form::where('id', $formId)->first();
        $formStyle = $form->style ?? '';

        return view('Ebps::template')->with(compact('form', 'formStyle'));
    }

    public function print( $formId)
    {
        
         try {
            $form = Form::findOrFail($formId);
            $html = $form->template;

            $letterHeadHtml = $this->getLetterHeader(
            ward_no: $form->ward_no ?? null,
            date: now()->format('Y-m-d'),
            reg_no: $form->registration_number ?? '1',
            is_darta: true,
            fiscal_year: getSetting('fiscal-year') ?? ''
            );

    
            $html = str_replace('{{global.letter-head}}', $letterHeadHtml, $html);


            $fileName = "map.pdf";
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Recommendation.recommendation.certificate'),
                file_name: $fileName,
                disk: getStorageDisk('private'),
                styles:$form?->styles ?? ""
            );
           
                return redirect()->away($url);
          
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function requestedChange()
    {
        return view('Ebps::requested-change.index');
    }


}
