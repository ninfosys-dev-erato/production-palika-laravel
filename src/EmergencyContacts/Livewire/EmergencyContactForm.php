<?php

namespace Src\EmergencyContacts\Livewire;

use App\Enums\Action;
use App\Facades\ImageServiceFacade;
use App\Services\ImageService;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\EmergencyContacts\Controllers\EmergencyContactAdminController;
use Src\EmergencyContacts\DTO\EmergencyContactAdminDto;
use Src\EmergencyContacts\DTO\EmergencyServiceAdminDto;
use Src\EmergencyContacts\Enum\ContactPages;
use Src\EmergencyContacts\Models\EmergencyContact;
use Src\EmergencyContacts\Service\EmergencyContactAdminService;
use Src\EmergencyContacts\Service\EmergencyServiceAdminService;

class EmergencyContactForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?EmergencyContact $emergencyContact;
    public ?Action $action;
    public $existingImage;
    public $icon;
    public $contacts;
    public $groups;


    public $emergencyServices = [];

    public function rules(): array
    {
        return [
            'emergencyContact.parent_id' => ['nullable'],
            'emergencyContact.group' => ['nullable'],
            'emergencyContact.service_name' => ['required', 'string'],
            'emergencyContact.service_name_ne' => ['required', 'string'],
            'icon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'], // Optional but better UX
            'emergencyContact.content' => ['nullable', 'string'],
            'emergencyContact.content_ne' => ['nullable', 'string'],
            'emergencyContact.contact_person' => ['required', 'string'],
            'emergencyContact.contact_person_ne' => ['required', 'string'],
            'emergencyContact.address' => ['required', 'string'],
            'emergencyContact.address_ne' => ['required', 'string'],
            'emergencyContact.contact_numbers' => ['required', 'string'],
            'emergencyContact.site_map' => ['required'], 
            'emergencyContact.facebook_url' => ['nullable'], 
            'emergencyContact.website_url' => ['nullable'], 
        ];
    }

    public function messages(): array
    {
        return [
            'emergencyContact.service_name.required' => __('emergencycontacts::emergencycontacts.the_service_name_field_is_required.'),
            'emergencyContact.service_name_ne.required' => __('emergencycontacts::emergencycontacts.the_nepali_service_name_field_is_required.'),
            'icon.image' => __('emergencycontacts::emergencycontacts.the_icon_must_be_an_image_file.'),
            'icon.mimes' => __('emergencycontacts::emergencycontacts.the_icon_must_be_a_file_of_type:_jpeg,_png,_bmp,_gif,_svg,_webp.'),
            'icon.max' => __('emergencycontacts::emergencycontacts.he_icon_field_must_not_be_greater_than_2048_kilobytes.'),
            'emergencyContact.contact_person.required' => __('emergencycontacts::emergencycontacts.the_contact_person_field_is_required.'),
            'emergencyContact.contact_person_ne.required' => __('emergencycontacts::emergencycontacts.the_nepali_contact_person_field_is_required.'),
            'emergencyContact.address.required' => __('emergencycontacts::emergencycontacts.the_address_field_is_required.'),
            'emergencyContact.address_ne.required' => __('emergencycontacts::emergencycontacts.the_nepali_address_field_is_required.'),
            'emergencyContact.contact_numbers.required' => __('emergencycontacts::emergencycontacts.the_contact_numbers_field_is_required.'),
            'emergencyContact.site_map.required' => __('emergencycontacts::emergencycontacts.the_site_map_field_is_required.'),
            'emergencyContact.content.nullable' => __('emergencycontacts::emergencycontacts.the_content_field_is_optional.'),
            'emergencyContact.content_ne.nullable' => __('emergencycontacts::emergencycontacts.the_nepali_content_field_is_optional.'),
        ];
    }

    public function updated()
    {
        $this->skipRender();
        $this->validate();
    }

    public function render()
    {
        return view("EmergencyContacts::livewire.form");
    }


    public function mount(EmergencyContact $emergencyContact, Action $action)
    {
        $this->emergencyContact = $emergencyContact;
        $this->action = $action;
        $this->existingImage = $this->emergencyContact->icon;
        $this->contacts = EmergencyContact::whereNull('deleted_by')->get();
        $this->groups = ContactPages::cases();
    }

    public function save()
    {
        $this->validate();
        
        DB::beginTransaction();
        try{
            if ($this->icon) {
                $this->emergencyContact->icon = ImageServiceFacade::compressAndStoreImage($this->icon, config('src.EmergencyContacts.emergencyContact.icon_path'), getStorageDisk('public'));
            }
            $dto = EmergencyContactAdminDto::fromLiveWireModel($this->emergencyContact);
            $service = new EmergencyContactAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    
                    DB::commit();
                    $this->successFlash(__('emergencycontacts::emergencycontacts.emergency_contact_created_successfully'));
                    return redirect()->route('admin.emergency-contacts.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->emergencyContact, $dto);
                    DB::commit();
                    $this->successFlash(__('emergencycontacts::emergencycontacts.emergency_contact_updated_successfully'));
                    return redirect()->route('admin.emergency-contacts.index');
                    break;
                default:
                    return redirect()->route('admin.emergency-contacts.index');
                    break;
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            DB::rollBack();
            $this->errorFlash((('something_went_wrong_while_saving.' . $e->getMessage())));
        }
    }
}
