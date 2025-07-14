<?php

namespace Src\Ebps\Livewire;

use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Ebps\Enums\MapApplyStatusEnum;
use Src\Ebps\Models\BuildingRegistrationDocument;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapStep;

class EbpsUploadFile extends Component
{
    use SessionFlash, WithFileUploads;

    public ?MapApply $mapApply;
    public ?MapStep $mapStep;
    public $files =[];
    public $title;

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'files' => ['required'],
        ];
    }


    public function render(){
        return view("Ebps::livewire.upload-file");
    }

    public function mount(MapStep $mapStep, MapApply $mapApply, BuildingRegistrationDocument $buildingRegistrationDocument )
    {
        $this->mapStep = $mapStep;
        $this->mapApply = $mapApply;
        $this->buildingRegistrationDocument = $buildingRegistrationDocument;
    }

    public function saveDocument()
    {
        $this->validate();
        try{

            foreach ($this->files as $file) 
            {
                $processedFile = $this->processFiles($file);

                BuildingRegistrationDocument::create([
                    'map_step_id' => $this->mapStep->id,
                    'map_apply_id' => $this->mapApply->id,
                    'title' => $this->title,
                    'file' => $processedFile,
                ]);
                if($this->mapStep->form && $this->mapStep->form->isEmpty())
                {                  
                    MapApplyStep::create([
                        'map_apply_id' => $this->mapApply->id,
                        'form_id' => null,
                        'map_step_id' =>  $this->mapStep->id,
                        'reviewed_by' =>null ,
                        'template' => null,
                        'status' =>  MapApplyStatusEnum::PENDING->value,
                        'reason' => null,
                        'sent_to_approver_at' => null,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                }

                $this->successToast(__('ebps::ebps.document_added_sucessfully'));
                $this->dispatch('document-uploaded');
            }
            $this->successToast(__("Document Added Sucessfully."));
            $this->dispatch('document-uploaded', ['modalId' => 'documentEditModal' . $this->mapStep->id,]);

             $this->reset(['title', 'files']);

        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
        
    }

    private function processFiles($file)
    {
        if($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
        {
           return FileFacade::saveFile( config('src.Ebps.ebps.path'), "", $file, 'local');
        }else{
            return $file;
        }
    }
}
