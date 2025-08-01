<?php

namespace Src\Settings\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;
use Src\Settings\DTO\FormTemplateAdminDto;
use Src\Settings\Models\Form;
use Src\Settings\Service\FormAdminService;
use App\Enums\Action;

class FormTemplate extends Component
{

    public ?Form $form;
    public Action $action;
    public array $dynamicFields = [];
    public $modules;
    public $path;

    public function rules(): array
    {
        return [
            'form.template' => ["required", "string"],
            'form.styles' => ["nullable"],
        ];
    }

    public function mount(Action $action, Form $form, $modules = null): void
    {
        $this->action = $action;
        $this->form = $form;
        $this->modules = $modules;
        $this->path =  request()->path();
        $this->dynamicFields = [
            [
                'title' => __('settings::settings.global_fields'),
                'fields' => [
                    'global.letter-head' => __('settings::settings.letter_head'),
                    'global.province' => __('settings::settings.province'),
                    'global.district' => __('settings::settings.district'),
                    'global.local-body' => __('settings::settings.local_body'),
                    'global.ward' => __('settings::settings.ward'),
                    'global.today_date_ad' => __('settings::settings.today_date_ad'),
                    'global.today_date_bs' => __('settings::settings.today_date_bs'),
                    'global.reviewer_sign' => __('settings::settings.reviewer_sign'),
                    'global.acceptor_sign' => __('settings::settings.acceptor_sign'),
                    'global.palika_name' => __('settings::settings.palika_name'),
                    'global.office_name' => __('settings::settings.office_name'),
                    'global.fiscal_year' => __('settings::settings.fiscal_year'),
                    'global.address' => __('settings::settings.palika_address'),
                    'global.chalani_no' => __('settings::settings.chalani_no'),
                    'global.darta_no' => __('settings::settings.darta_no'),
                    'global.acceptor_name' => __('settings::settings.acceptor_name'),
                    'global.palika_email' => __('settings::settings.palika_email'),
                    'global.palika_phone' => __('settings::settings.palika_phone'),
                    'global.palika_logo' => __('settings::settings.palika_logo'),
                    'global.palika_campaign_logo' => __('settings::settings.palika_campaign_logo'),
                ]
            ],
            [
                'title' => __('settings::settings.customer_fields'),
                'fields' => [
                    'customer.name' => __('settings::settings.name'),
                    'customer.email' => __('settings::settings.email'),
                    'customer.mobile_no' => __('settings::settings.mobile'),
                    'customer.gender' => __('settings::settings.gender'),
                    'customer.nepali_date_of_birth' => __('settings::settings.date_of_birth_ad'),
                    'customer.english_date_of_birth' => __('settings::settings.date_of_birth_bs'),
                    'customer.grandfather_name' => __('settings::settings.grand_father_name'),
                    'customer.father_name' => __('settings::settings.father_name'),
                    'customer.mother_name' => __('settings::settings.mother_name'),
                    'customer.spouse_name' => __('settings::settings.spouse_name'),
                    'customer.permanent_province_id' => __('settings::settings.permanent_province'),
                    'customer.permanent_district_id_en' => __('settings::settings.permanent_district_en'),
                    'customer.permanent_local_body_id_en' => __('settings::settings.permanent_local_body_en'),
                    'customer.permanent_district_id' => __('settings::settings.permanent_district'),
                    'customer.permanent_local_body_id' => __('settings::settings.permanent_local_body'),
                    'customer.permanent_ward' => __('settings::settings.permanent_ward'),
                    'customer.permanent_tole' => __('settings::settings.permanent_tole'),
                    'customer.temporary_province_id' => __('settings::settings.temporary_province'),
                    'customer.temporary_district_id' => __('settings::settings.temporary_district'),
                    'customer.temporary_local_body_id' => __('settings::settings.temporary_local_body'),
                    'customer.temporary_ward' => __('settings::settings.temporary_ward'),
                    'customer.temporary_tole' => __('settings::settings.temporary_tole'),
                    'customer.document_issued_date_nepali' => __('settings::settings.document_issued_date_ad'),
                    'customer.document_issued_date_english' => __('settings::settings.document_issued_date_bs'),
                    'customer.document_number' => __('settings::settings.document_no'),
                    'customer.document_image1' => __('settings::settings.document_image_front'),
                    'customer.document_image2' => __('settings::settings.document_image_back'),
                    'customer.expiry_date_nepali' => __('settings::settings.document_expiry_date_ad'),
                    'customer.expiry_date_english' => __('settings::settings.document_expiry_date_bs'),
                ]
            ],
            [
                'title' => __('settings::settings.form_fields'),
                'fields' => $this->formatData(json_decode($form->fields, true), 'form')
            ]
        ];
        if (str_contains($this->path, 'admin/ebps')) {
            $this->dynamicFields[] = [
                'title' => __('settings::settings.ebps_customer_fields'),
                'fields' => [
                    'mapApply.customer.name' => __('settings::settings.customer_name'),
                    'mapApply.landDetail.ward_no' => __('settings::settings.land_detail_ward'),
                    'mapApply.landDetail.tole' => __('settings::settings.land_detail_tole'),
                    'mapApply.landDetail.former_ward' => __('settings::settings.land_detail_former_ward'),
                    'mapApply.landDetail.former_localBody' => __('Land Detail Former Local Body'),
                    'mapApply.landDetail.plot_no' => __('settings::settings.land_detail_plot_no'),
                    'mapApply.landDetail.area' => __('settings::settings.land_detail_area'),
                    'mapApply.landDetail.ownership_type' => __('settings::settings.ownership_detail'),
                    'mapApply.usage' => __('settings::settings.usage'),
                    'mapApply.landDetail.fourForts:name,direction,distance_to,plot_no' => __('settings::settings.fourforts'),
                    'mapApply.constructionType.title' => __('settings::settings.construction_type'),
                    'mapApply.signature' => __('settings::settings.customer_signature'),
                    'mapApply.customer.customerDetail.age' => __('settings::settings.customer_age'),
                    'mapApply.customer.customerDetail.permanentLocalBody.title' => __('settings::settings.local_body'),
                    'mapApply.customer.customerDetail.permanent_ward' => __('settings::settings.permanent_ward'),
                    'mapApply.customer.phone' => __('settings::settings.customer_phone'),
                    'mapApply.appliedDate' => __('Applied Date'),
                    'mapApply.houseOwnerName' => __('House Owner Name'),
                    'mapApply.houseOwnerMobileNo' => __('House Owner Mobile No'),
                    'mapApply.houseOwnerFatherName' => __('House Owner Father Name'),
                    'mapApply.houseOwnerGrandFatherName' => __('GrandFather Name'),
                    'mapApply.houseOwnerCitizenshipNo' => __('Citizenship No'),
                    'mapApply.houseOwnerProvince' => __('House Owner Province'),
                    'mapApply.houseOwnerDistrict' => __('House Owner District'),
                    'mapApply.houseOwnerLocalBody' => __('House Owner Local Body'),
                    'mapApply.houseOwnerWard' => __('House Owner Ward'),
                    'mapApply.houseOwnerTole' => __('House Owner Tole'),
                    'mapApply.landOwnerName' => __('Land Owner Name'),
                    'mapApply.landOwnerMobileNo' => __('Land Owner Mobile No'),
                    'mapApply.landOwnerFatherName' => __('Land Owner Father Name'),
                    'mapApply.landOwnerGrandFatherName' => __('Land Owner GrandFather Name'),
                    'mapApply.landOwnerCitizenshipNo' => __('Land Owner Citizenship No'),
                    'mapApply.landOwnerProvince' => __('Land Owner Province'),
                    'mapApply.landOwnerDistrict' => __('Land Owner District'),
                    'mapApply.landOwnerLocalBody' => __('Land Owner Local Body'),
                    'mapApply.landOwnerWard' => __('Land Owner Ward'),
                    'mapApply.landOwnerTole' => __('Land Owner Tole'),
                    'mapApply.applicantName' => __('Applicant Name'),
                    'mapApply.applicantMobileNo' => __('Applicant Mobile No'),
                    'mapApply.applicantFatherName' => __('Applicant Father Name'),
                    'mapApply.applicantGrandFatherName' => __('Applicant GrandFather Name'),
                    'mapApply.applicantCitizenshipNo' => __('Applicant Citizenship No'),
                    'mapApply.applicantProvince' => __('Applicant Province'),
                    'mapApply.applicantDistrict' => __('Applicant District'),
                    'mapApply.applicantLocalBody' => __('Applicant Local Body'),
                    'mapApply.applicantWard' => __('Applicant Ward'),
                    'mapApply.area_of_building_plinth' => __('Area of Building Plinth'),
                    'mapApply.no_of_rooms' => __('No of Rooms'),
                    'mapApply.storey_no' => __('Storey No'),
                    'mapApply.year_of_house_built' => __('Year Of House Built'),
                    'mapApply.building_structure' => __('Building Structure')
                ]
            ];

            $this->dynamicFields[] = [
                'title' => __('settings::settings.customer_fields'),
                'fields' => [
                    'form.approver.signature' => __('settings::settings.approver'),

                ]
            ];
        }

        if (str_contains($this->path, 'admin/business-registration')) {
            $this->dynamicFields[] = [
                'title' => __('settings::settings.business_fields'),
                'fields' => [
                    'business.registration_type_id' => __('settings::settings.registration_type'),
                    'business.entity_name' => __('settings::settings.entity_name'),
                    'business.amount' => __('settings::settings.amount'),
                    'business.bill_no' => __('settings::settings.bill_no'),
                    'business.application_date' => __('settings::settings.application_date_bs'),
                    'business.application_date_en' => __('settings::settings.application_date_ad'),
                    'business.registration_date' => __('settings::settings.registration_date_bs'),
                    'business.registration_date_en' => __('settings::settings.registration_date_ad'),
                    'business.registration_number' => __('settings::settings.registration_number'),
                    'business.certificate_number' => __('settings::settings.certificate_number'),
                    'business.province_id' => __('settings::settings.province'),
                    'business.district_id' => __('settings::settings.district'),
                    'business.local_body_id' => __('settings::settings.local_body'),
                    'business.ward_no' => __('settings::settings.ward_no'),
                    'business.way' => __('settings::settings.way'),
                    'business.tole' => __('settings::settings.tole'),
                    'business.data' => __('settings::settings.data'),
                    'business.bill' => __('settings::settings.bill'),
                    'business.mobile_no' => __('settings::settings.mobile_no'),
                    'business.fiscal_year_id' => __('settings::settings.fiscal_year'),
                    'business.business_owner_name' => __('settings::settings.business_owner_name'),
                    'business.business_owner_number' => __('settings::settings.business_owner_number'),
                    'business.business_reg_no' => __('settings::settings.business_reg_no'),
                    'business.business_nature' => __('settings::settings.business_nature'),
                ],
            ];
        }
    }

    public function updated(): void
    {
        $this->skipRender();
        $this->validate();
    }

    public function formatData(array $data, ?string $prefix = null): array
    {
        $formattedData = [];

        foreach ($data as $item) {
            if (isset($item['type']) && $item['type'] === 'group') {
                foreach ($item as $k => $values) {
                    if (is_numeric($k)) {
                        $formattedData[$prefix ? "{$prefix}.{$values['slug']}" : $values['slug']] = $values['label'];
                    }
                }
            } else {
                if (isset($item['slug'], $item['label'])) {
                    $formattedData[$prefix ? "{$prefix}.{$item['slug']}" : $item['slug']] = $item['label'];
                }
            }
        }
        return $formattedData;
    }

    public function render()
    {
        return view("Settings::livewire.form.template");
    }

    public function save()
    {
        $this->validate();
        $dto = FormTemplateAdminDto::fromLiveWireModel([
            'template' => $this->form->template,
            'styles' => $this->form->styles,
        ]);

        $service = new FormAdminService();

        switch ($this->action) {
            case Action::UPDATE:
                $service->template($this->form, $dto);
                break;
        }


        foreach ($this->modules as $key => $module) {
            if (str_contains(strtolower($this->path), strtolower($module))) {
                $moduleName = Str::before(Str::after($this->path, 'admin/'), '/');
                return redirect()->route('admin.' . $moduleName . '.form-template.index');
                break;
            }
        }

        return redirect()->route('admin.setting.form.index');
    }


    // 
}
