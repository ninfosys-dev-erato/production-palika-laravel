<?php

namespace Frontend\BusinessPortal\Ebps\Livewire;

use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Traits\SessionFlash;
use Frontend\BusinessPortal\Ebps\DTO\OrganizationAdminDto;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Ebps\Models\Organization;
use Src\Ebps\Service\OrganizationAdminService;

class OrganizationForm extends Component
{
    use WithFileUploads, SessionFlash;

    public int $currentStep = 1;

    public float $progressPercentage = 0;

    public $districts = [];

    public $provinces = [];
    public $localBodies = [];
    public  $wards = [];
    public array $address = [

        'organizationProvince' => null,
        'organizationDistrict' => null,
        'organizationLocalBody' => null,
        'organizationLocalBodies' => [],
        'organizationWards' => [],
        'organizationDistricts' => [],
    ];

    public array $organizationUser = [
        'name' => null,
        'email' => null,
        'phone' => null,
        'password' => null,
        'password_confirmation' => null,
    ];

    public array $organizationDetail = [
        'org_name_ne' => null,
        'org_name_en' => null,
        'org_email' => null,
        'org_contact' => null,
        'org_registration_no' => null,
        'org_registration_document' => null,
        'company_registration_document' => null,
        'org_pan_no' => null,
        'org_pan_document' => null,
        'logo' => null,
        'province_id' => null,
        'district_id' => null,
        'local_body_id' => null,
        'ward' => null,
        'tole' => null,
        'local_body_registration_no' => null,
        'local_body_registration_date' => null,
        'local_body_file' => null,
    ];

    public array $taxClearance = [
        'document' => null,
        'year' => null,
    ];

  

    protected array $firstStepValidations = [
        'organizationDetail.org_name_ne' => ['required'],
        'organizationDetail.org_name_en' => ['required'],
        'organizationDetail.org_registration_no' => ['required'],
        'organizationDetail.org_contact' => ['required'],
        'organizationDetail.org_pan_no' => ['required'],
        'organizationDetail.org_email' => ['required'],
        'organizationDetail.province_id' => ['required', 'exists:add_provinces,id,deleted_at,NULL'],
        'organizationDetail.district_id' => ['required', 'exists:add_districts,id,deleted_at,NULL'],
        'organizationDetail.local_body_id' => ['required', 'exists:add_local_bodies,id,deleted_at,NULL'],
        'organizationDetail.ward' => ['required'],
        'organizationDetail.tole' => ['nullable'],
    ];

    protected array $secondStepValidations = [
        'organizationDetail.logo' => ['required', 'image'],
        'organizationDetail.org_registration_document' => ['required'],
        'organizationDetail.org_registration_date' => ['required'],
        'organizationDetail.company_registration_document' => ['required'],
        'organizationDetail.org_pan_document' => ['required'],
        'organizationDetail.org_pan_registration_date' => ['required'],
        'taxClearance.document' => ['required'],
        'taxClearance.year' => ['required'],
        'organizationDetail.local_body_registration_no' => ['required'],
        'organizationDetail.local_body_registration_date' => ['required'],
        'organizationDetail.local_body_file' => ['required'],
    ];

    protected array $thirdStepValidations = [
        'organizationUser.name' => ['required'],
        'organizationUser.email' => ['required', 'email', 'unique:org_organization_users,email'],
        'organizationUser.phone' => ['required', 'unique:org_organization_users,phone'],
        'organizationUser.password' => ['required', 'confirmed','min:6'],
    ];

    public function mount(): void
    {
        $this->provinces = getProvinces()->pluck('title', 'id')->toArray();
    }

    public function loadDistricts()
    {
        $this->districts = getDistricts($this->organizationDetail['province_id'])->pluck('title', 'id')->toArray();
        $this->localBodies = [];
        $this->wards = [];
    }

    public function loadLocalBodies(): void
    {
        $this->localBodies = getLocalBodies(district_ids: $this->organizationDetail['district_id'])->pluck('title', 'id')->toArray();
        $this->wards = [];
    }

    public function loadWards(): void
    {
        $this->wards = getWards(getLocalBodies(localBodyId: $this->organizationDetail['local_body_id'])->wards);
    }

    public function nextStep($step): void
    {

        $this->validate();
        $this->currentStep = $step;
        if($step === 2){

            $this->dispatch('step-changed');
        }
    }

    public function backStep($step): void
    {
        $this->currentStep = $step;
    }

    protected function rules(): array
    {
        return match ($this->currentStep) {
            2 => $this->secondStepValidations,
            3 => $this->thirdStepValidations,
            default => $this->firstStepValidations,
        };
    }


    public function submitFormData()
    {       
        $this->organizationDetail['org_registration_document'] = $this->storeFile($this->organizationDetail['org_registration_document']);
        $this->organizationDetail['company_registration_document'] = $this->storeFile($this->organizationDetail['company_registration_document']);
        $this->organizationDetail['org_pan_document'] = $this->storeFile($this->organizationDetail['org_pan_document']);
        $this->organizationDetail['logo'] = $this->storeFile($this->organizationDetail['logo']);
        $this->organizationDetail['local_body_file'] = $this->storeFile($this->organizationDetail['local_body_file']);
        $this->taxClearance['document'] = $this->storeFile($this->taxClearance['document']);

        $organizationDto = OrganizationAdminDto::fromLiveWireModel($this->organizationDetail);

        $organizationService = new OrganizationAdminService();
        DB::beginTransaction();

        try{
            $organization = $organizationService->store($organizationDto);
          
            $organization->taxClearances()->create($this->taxClearance);
            $this->organizationUser['is_organization'] = true;
            $this->organizationUser['is_active'] = true;
            $this->organizationUser['can_work'] = true;
            $this->organizationUser['password'] =  Hash::make( $this->organizationUser['password']);
            $organization->user()->create($this->organizationUser);
            DB::commit();
            $this->successFlash(__("तपाईंको संस्था/परामर्शदाता सफलतापूर्वक दर्ता गरिएको छ। सेवा प्रयोग गर्न कृपया प्रमाणीकरण इमेलको प्रतीक्षा गर्नुहोस्।"));
            return redirect(url('organization/login'));
        }  catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__("An error occurred during operation. Please try again later"));
        }
    }

    public function render(): Factory|View|Application
    {
        return view("BusinessPortal.Ebps::livewire.form");
    }

    private function calculateProgressPercentage()
    {
        $this->reset('progressPercentage');
        $this->progressPercentage = $this->currentStep / 4 * 100;
    }

    private function storeFile($file): string
    {
        if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
                return ImageServiceFacade::compressAndStoreImage($file, config('src.Ebps.ebps.path'), 'local');
            }
    
            return FileFacade::saveFile(
                path: config('src.Ebps.ebps.path'),
                filename: null,
                file: $file,
                disk: 'local'
            );
        }
    
        return '';
    }
    
    public function messages(): array
    {
        return [

            'organizationDetail.org_name_ne.required' => 'संस्था/परामर्शदाताको नाम नेपालीमा आवश्यक छ । ',
            'organizationDetail.org_name_en.required' => 'संस्था/परामर्शदाताको नाम अंग्रेजीमा आवश्यक छ । ',
            'organizationDetail.org_email.required' => 'संस्था/परामर्शदाताको इमेल आवश्यक छ । ',
            'organizationDetail.org_contact.required' => 'संस्था/परामर्शदाताको सम्पर्क नं आवश्यक छ । ',
            'organizationDetail.org_registration_no.required' => 'संस्था/परामर्शदाता दर्ता भएको नं आवश्यक छ ।',
            'organizationDetail.org_pan_no.required' => 'संस्था/परामर्शदाताको पाना नं आवश्यक छ । ',
            'organizationDetail.province_id.required' => 'प्रदेश आवश्यक छ ।',
            'organizationDetail.district_id.required' => 'जिल्ला आवश्यक छ ।',
            'organizationDetail.local_body_id.required' => 'पालिका आवश्यक छ ।',
            'organizationDetail.ward.required' => 'वडा नं आवश्यक छ ।',
            'organizationDetail.org_registration_document.required' => 'संस्था/परामर्शदाता दर्ता भएको कागजात आवश्यक छ ।',
            'organizationDetail.org_registration_document.max' => 'कागजात अधिकतम साइज ३०० केबी ।',
            'organizationDetail.org_registration_document.image' => 'फाइल फोटोमा हुनुपर्छ ।',
            'organizationDetail.company_registration_document.required' => 'कम्पनी दर्ता भएको कागजात आवश्यक छ ।',
            'organizationDetail.company_registration_document.max' => 'कागजात अधिकतम साइज ३०० केबी ।',
            'organizationDetail.company_registration_document.image' => 'फाइल फोटोमा हुनुपर्छ ।',
            'organizationDetail.org_pan_document.required' => 'संस्था/परामर्शदाताको पाना नं को कागजात आवश्यक छ ।',
            'organizationDetail.org_pan_document.max' => 'कागजात अधिकतम साइज ३०० केबी ।',
            'organizationDetail.org_pan_document.image' => 'फाइल फोटोमा हुनुपर्छ ।',
            'organizationDetail.logo.required' => 'संस्था/परामर्शदाताको लोगो आवश्यक छ ।',
            'organizationDetail.logo.max' => 'कागजात अधिकतम साइज २०० केबी ।',
            'organizationDetail.logo.image' => 'फाइल फोटोमा हुनुपर्छ ।',
            'taxClearance.document.required' => 'संस्था/परामर्शदाताले कर तिरेको कागजात आवश्यक छ ।',
            'taxClearance.document.max' => 'कागजात अधिकतम साइज २०० केबी ।',
            'taxClearance.year.required' => 'संस्था/परामर्शदाताले कर तिरेको वर्ष आवश्यक छ ।',
            'organizationUser.name.required' => 'प्रयोगकर्ताको नाम आवश्यक छ ।',
            'organizationUser.name.unique' => 'यो संस्था/परामर्शदाता पहिल्यै भई सकेको छ ।',
            'organizationUser.email.required' => 'इमेल आवश्यक छ ।',
            'organizationUser.email.unique' => 'यो इमेल पहिल्यै दर्ता भई सकेको छ ।',
            'organizationUser.email.email' => 'इमेल मान्य छैन ।',
            'organizationUser.phone.required' => 'सम्पर्क नं आवश्यक छ ।',
            'organizationUser.phone.unique' => 'यो सम्पर्क नं पहिल्यै प्रयोग भई सकेको छ ।',
            'organizationUser.password.required' => 'पासवर्ड आवश्यक छ ।',
        ];
    }
}
