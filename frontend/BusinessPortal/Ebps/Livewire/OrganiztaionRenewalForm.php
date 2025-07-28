<?php

namespace Frontend\BusinessPortal\Ebps\Livewire;

use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ebps\Models\Organization;
use App\Facades\ImageServiceFacade;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Src\Ebps\Models\TaxClearance;

class OrganiztaionRenewalForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?Organization $organization;
    public $document = null;

    protected $rules = [
        'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
    ];

    public function render()
    {
        return view("BusinessPortal.Ebps::livewire.organization-renewal");
    }

    public function mount(Organization $organization)
    {
        $this->organization = $organization;
    }

    public function save()
    {
        $this->validate();
            try {
                $filePath = $this->processFiles($this->document);
                
               
                if (!$this->organization || !$this->organization->id) {
                    throw new \Exception('Organization not found or invalid.');
                }
                
                $tax = TaxClearance::create([
                    'organization_id' => $this->organization->id,
                    'document' => $filePath,
                    'year' => getSetting('fiscal-year'),
                ]);
                
                $this->successFlash(__('Tax clearance document uploaded successfully!'));
                $this->document = null;
                

                return redirect()->route('organization.profile');
                
            }  catch (\Exception $e) {
                logger($e);
                $this->errorFlash(__("An error occurred during operation. Please try again later"));
            }
        
    }

    private function processFiles($file)
    {
        if ($file instanceof TemporaryUploadedFile) {
            return FileFacade::saveFile(config('src.Ebps.ebps.path'), "", $file, 'local');
        } else {
            return $file;
        }
    }

    private function storeFile($file): string
    {
        return ImageServiceFacade::compressAndStoreImage($file, config('src.Ebps.ebps.path'));
    }
}
