<?php

use Anuzpandey\LaravelNepaliDate\Enums\NepaliMonth;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Facades\VideoServiceFacade;
use App\Models\User;
use App\Services\NepaliCalendarService;
use App\Traits\SessionFlash;
use Domains\CustomerGateway\Crawler\Spiders\NoticeSpider;
use Domains\CustomerGateway\Crawler\Spiders\PhotoGallerySpider;
use Domains\CustomerGateway\Crawler\Spiders\SliderSpider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use RoachPHP\Roach;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapStep;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\DisputeDeadline;
use Src\Ejalas\Models\DisputeRegistrationCourt;
use Src\Ejalas\Models\JudicialMeeting;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Settings\Models\FiscalYear;
use Src\Settings\Models\Form;
use Src\Settings\Models\LetterHead;
use Src\Settings\Models\MstSetting;
use Src\Settings\Models\Setting;
use Src\Wards\Models\Ward;
use Src\Yojana\Models\WorkOrder;
use Src\FileTracking\Models\FileRecord;


if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin(): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        $cacheKey = "user:{$user->id}:is_super_admin";

        return Cache::remember($cacheKey, now()->addDay(), function () use ($user) {
            return $user->hasRole('super-admin');
        });
    }
}

if (!function_exists('isModuleEnabled')) {
    function isModuleEnabled(string $key): bool
    {
        $modules = explode(',', env('ENABLED_MODULES', ''));
        return in_array($key, array_map('trim', $modules));
    }
}

if (!function_exists('can')) {
    function can(...$permissions): bool
    {
        static $permissionMap = [];
        static $isSuperAdmin = [];

        $user = Auth::user();

        if (!$user) {
            return false;
        }

        $userId = $user->id;

        if (!isset($isSuperAdmin[$userId])) {
            $isSuperAdmin[$userId] = $user->hasRole('super-admin');
        }

        if ($isSuperAdmin[$userId]) {
            return true;
        }

        if (!isset($permissionMap[$userId])) {
            $permissionMap[$userId] = Cache::remember(
                "permissions_for_user_{$userId}",
                now()->addMinutes(env('PERMISSION_CACHE_MINUTES', 60)),
                fn () => array_fill_keys($user->getAllPermissions()->pluck('name')->toArray(), true)
            );
        }

        foreach ($permissions as $permission) {
            if (isset($permissionMap[$userId][$permission])) {
                return true;
            }
        }

        return false;
    }

}

function canController($permission)
{
    if (!can($permission)) {
        SessionFlash::WARNING_FLASH("You Dont Have Permission to Access this resource", "Access Denied");
        return redirect()->route('admin.home');
    }
}

function getConstant($key = null)
{
    return cache($key) ?? "";
}

if (!function_exists('getFiscalYears')) {
    function getFiscalYears(): array|Collection
    {
        if (!Cache::has('fiscalYears')) {
            Cache::rememberForever('fiscalYears', function () {
                if (Schema::hasTable('mst_fiscal_years')) {
                    $arr = FiscalYear::get()->toArray();
                    return json_encode($arr);
                }
                return [];
            });
        }
        return collect(json_decode(Cache::get('fiscalYears'))) ?? [];
    }
}

if (!function_exists('getCurrentFiscalYear')) {
    function getCurrentFiscalYear(): ?FiscalYear
    {
        if (!Cache::has('currentFiscalYear')) {
            Cache::rememberForever('currentFiscalYear', function () {
                if (Schema::hasTable('mst_fiscal_years')) {
                    return FiscalYear::first(); // Assuming first record on table mst_fiscal_years represents the current fiscal year record
                }
                return null;
            });
        }

        return Cache::get('currentFiscalYear');
    }
}

function getSetting(string $key)
{
    return Cache::remember("setting_{$key}", now()->addHour(), function () use ($key) {
        $row = MstSetting::where('key', $key)->first();
        return $row ? $row->value : false;
    });
}

function getLetterHeaderTest(
        ?int $ward_no = null,
        string $date = '',     // default inside function if empty
        string|null $reg_no = '',
        bool $is_darta = true,
        string|null $fiscal_year = ''
    ): string {
        $date = $date ?: getFormattedBsDate() ?? '';
        $fiscal_year = $fiscal_year ?: (getSetting('fiscal-year'));



        // Ward or fallback office name
        $office_name = null;
        if ($ward_no) {
            $office_name = Ward::where('id', $ward_no)->value('ward_name_ne');
        }
        $office_name = $office_name ?: getSetting('office-name')  ;

        $palika_name = getSetting('palika-name')  ;
        $palika_logo = getSetting('palika-logo') ?: "";
        $palika_campaign_logo = getSetting('palika-campaign-logo') ?: "";
        $district = getSetting('palika-district')  ;
        $province = getSetting('palika-province')  ;
        $address = trim("{$district}, {$province}, नेपाल", ', ');

        // Darta/Chalani label
        $label = $is_darta ? 'दर्ता नं.' : 'चलानी नं.';

        // Escape dynamic values
        $palika_name = htmlspecialchars($palika_name, ENT_QUOTES, 'UTF-8');
        $office_name = htmlspecialchars($office_name, ENT_QUOTES, 'UTF-8');
        $address = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
        $fiscal_year = htmlspecialchars($fiscal_year, ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($date, ENT_QUOTES, 'UTF-8');
        $reg_no = htmlspecialchars(replaceNumbers($reg_no, true), ENT_QUOTES, 'UTF-8');
        $label = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');

        return <<<HTML
        <div class="main-container" style="">
            <table class="main-table" width="100%" cellpadding="0" cellspacing="0" style="padding: 0; margin:0;">
                <tr>
                    <td width="80">
                        <img class="logo" src="{$palika_logo}" alt="Logo" width="80">
                    </td>
                    <td class="title" align="center" valign="middle">
                        <span style="color: red;">
                            <span style="font-size: 1.6rem; font-weight: bold">{$palika_name}</span><br>
                            <span style="font-size: 1.6rem; font-weight: bold">{$office_name}</span><br>
                            <span style="font-size: 1.2rem">{$address}</span>
                        </span>
                    </td>
                    <td width="80">
                        <img class="campaign_logo" src="{$palika_campaign_logo}" alt="Campaign Logo" width="80">
                    </td>
                </tr>
            </table>

            <table width="100%" style="font-size: 0.9rem; margin-top: 0.3rem;">
                <tr>
                    <td width="34%">पत्र संख्या: {$fiscal_year}</td>
                    <td width="33%" rowspan="2" style="text-align: right;">मिति: {$date}</td>

                </tr>
                <tr>
                <td width="33%">चलानी नं./Dis. No.: {$reg_no}</td>
    </tr>
            </table>
            <hr style="margin: 0.5rem 0;">
        </div>
    HTML;
    }

function getSettingWithKey(string $key): array
{
    return Cache::remember("setting_with_key_{$key}", now()->addHour(), function () use ($key) {
        $row = MstSetting::where('key', $key)->first();
        return $row ? [$row->key_id => $row->value] : [];
    });
}

if (!function_exists('getProvinces')) {
    function getProvinces(?int $provinceId = null): array|Collection
    {
        if (!Cache::has('provinces')) {
            Cache::rememberForever('provinces', function () {
                if (Schema::hasTable('add_provinces')) {
                    $arr = Province::select('title', 'title_en', 'id')->get()->toArray();
                    return json_encode($arr);
                }
                return [];
            });
        }
        $provinces = Cache::get('provinces');
        if ($provinceId !== null) {
            $provinces = $provinces->where('id', $provinceId)->first();
        }
        return collect(json_decode($provinces)) ?? [];
    }
}

if (!function_exists('getDistricts')) {
    function getDistricts($province_ids = [], ?int $districtId = null)
    {
        if (!Cache::has('districts')) {
            Cache::rememberForever('districts', function () {
                if (Schema::hasTable('add_districts')) {
                    $arr = District::select('id', 'title', 'title_en', 'province_id')->orderBy('province_id')->get()->toArray();
                    return json_encode($arr);
                }
                return [];
            });
        }
        $allDistricts = collect(json_decode(Cache::get('districts')));
        $province_ids = is_array($province_ids) ? $province_ids : [$province_ids];
        if (!empty($province_ids)) {
            $allDistricts = $allDistricts->whereIn('province_id', $province_ids);
        }
        if ($districtId !== null) {
            $allDistricts = $allDistricts->where('id', $districtId)->first();
        }
        return $allDistricts ?? [];
    }
}

if (!function_exists('getLocalBodies')) {
    function getLocalBodies($district_ids = [], ?int $localBodyId = null)
    {
        if (!Cache::has('localBodies')) {
            Cache::rememberForever('localBodies', function () {
                $arr = LocalBody::select('id', 'title', 'title_en', 'district_id', 'wards')->get()->toArray();
                return json_encode($arr);
            });
        }
        $allLocalBodies = collect(json_decode(Cache::get('localBodies')));
        $district_ids = is_array($district_ids) ? $district_ids : [$district_ids];
        if (!empty($district_ids)) {
            $allLocalBodies = $allLocalBodies->whereIn('district_id', $district_ids);
        }
        if ($localBodyId !== null) {
            $allLocalBodies = $allLocalBodies->where('id', $localBodyId)->first();
        }

        return $allLocalBodies ?? [];
    }
}

function getWards($number): array
{
    return range(1, $number);
}

function getSliders(): Collection
{
    if (!Cache::has('web_crawl_sliders')) {
        Cache::remember('web_crawl_sliders', now()->addHours(24), function () {
            return json_encode(crawlerMapItem(Roach::collectSpider(SliderSpider::class)));
        });
    }
    return collect(json_decode(Cache::get('web_crawl_sliders')));
}

function getNotices(): Collection
{
    if (!Cache::has('web_crawl_notices')) {
        Cache::remember('web_crawl_notices', now()->addHours(24), function () {
            return json_encode(crawlerMapItem(Roach::collectSpider(NoticeSpider::class)));
        });
    }
    return collect(json_decode(Cache::get('web_crawl_notices')));
}

function getGalleries(): Collection
{
    if (!Cache::has('web_crawl_galleries')) {
        Cache::remember('web_crawl_galleries', now()->addHours(24), function () {
            return json_encode(crawlerMapItem(Roach::collectSpider(PhotoGallerySpider::class)));
        });
    }
    return collect(json_decode(Cache::get('web_crawl_galleries')));
}

function crawlerMapItem(mixed $crawledItem): array
{
    return collect($crawledItem)
        ->flatMap(fn($item) => $item->all())
        ->toArray();
}

function getFormattedBsDate() 
{
    $bsDate = ne_date(date('Y-m-d'), 'yyyy,MM,dd');
    dd($bsDate);
    [$year, $monthName, $day] = explode(',', $bsDate);
    $monthName = preg_replace('/[^\p{L}\p{M}]/u', '', $monthName);

    $monthMap = [
        'बैशाख' => '०१',
        'जेठ' => '०२',
        'असार' => '०३',
        'साउन' => '०४',
        'भदौ' => '०५',
        'असोज' => '०६',
        'कार्तिक' => '०७',
        'मंसिर' => '०८',
        'पुष' => '०९',
        'माघ' => '१०',
        'फाल्गुण' => '११',
        'चैत्र' => '१२',
    ];

    $monthNepaliNum = $monthMap[$monthName] ?? replaceNumbers('0', toNepali: true);
    return replaceNumbers("{$year}/", toNepali: true) . $monthNepaliNum . '/' . replaceNumbers($day, toNepali: true);
}

function resolveTemplate(ApplyRecommendation $applyRecommendation): string
{
    $applyRecommendation->load('recommendation.form', 'recommendation.acceptedBy', 'recommendation.notifyTo', 'customer.kyc', 'reviewedBy', 'acceptedBy');
    $acceptorSignature = '{{global.acceptor_sign}}';
    $acceptorName = '{{global.acceptor_name}}';

    $signatures = '';

    $signee = $applyRecommendation->signee;

    if ($signee && $signee->name) {
        // $signatures = '<img src="data:image/jpeg;base64,' . base64_encode(
        //     ImageServiceFacade::getImage(config('src.Profile.profile.path'), $signee->signature)
        // ) . '" alt="Signature" width="80"><br>';

        $acceptorName = $signee->name;
    } else {
        $acceptorName = "";
    }

    // $acceptorSignature = $signatures;
    $reviewerSignature = '{{global.reviewer_sign}}';
    if (!empty($applyRecommendation->reviewed_by)) {
        if (!empty($applyRecommendation->reviewedBy?->signature)) {
            $reviewerSignature = '<img src="data:image/jpeg;base64,' . base64_encode(ImageServiceFacade::getImage(config('src.Profile.profile.path'), $applyRecommendation->reviewedBy?->signature)) . '"
                         alt="Signature" width="80">';
        } else {
            $reviewerSignature = '______________________';
        }
    }
    $wardId = $applyRecommendation->is_ward ? $applyRecommendation->ward_id : null;

    $letter = [
        'header' => getLetterHeader($wardId),
        'footer' => getLetterFooter($wardId),
    ];

    $fileRecord = FileRecord::where('subject_id',  $applyRecommendation->id)->whereNull('deleted_at')->first();
    $regNo = $fileRecord && $fileRecord->reg_no ? replaceNumbers($fileRecord->reg_no, true) : ' ';

    $data = [
        '{{global.letter-head}}' => $letter['header'],
        '{{global.letter-head-footer}}' => $letter['header'],
        '{{global.province}}' => getSetting('palika-province'),
        '{{global.district}}' => getSetting('palika-district'),
        '{{global.local-body}}' => getSetting('palika-local-body'),
        '{{global.ward}}' => getSetting('palika-ward'),
        '{{global.today_date_ad}}' => today()->toDateString(),
        '{{global.today_date_bs}}' => getFormattedBsDate(),
        '{{global.reviewer_sign}}' => $reviewerSignature,
        '{{global.acceptor_sign}}' => $acceptorSignature,
        '{{global.acceptor_name}}' => $acceptorName,
        '{{global.palika_name}}' => getSetting('palika-name'),
        '{{global.office_name}}' => getSetting('office-name'),
        '{{global.fiscal_year}}' => getSetting('fiscal-year'),
        '{{global.palika_address}}' => getSetting('palika-address'),
        '{{global.darta_no}}' => $regNo,
        '{{global.chalani_no}}' => $regNo,
        ...getResolvedFormData(is_array($applyRecommendation->data) ?  $applyRecommendation->data : json_decode($applyRecommendation->data, true))
    ];

    if (isset($applyRecommendation->customer)) {
        $data = array_merge($data, [
            '{{customer.name}}' => $applyRecommendation->customer->name,
            '{{customer.email}}' => $applyRecommendation->customer->email,
            '{{customer.mobile_no}}' => $applyRecommendation->customer->mobile_no,
            '{{customer.gender}}' => $applyRecommendation->customer->gender?->label(),
            '{{customer.nepali_date_of_birth}}' => $applyRecommendation->customer->kyc->nepali_date_of_birth,
            '{{customer.english_date_of_birth}}' => $applyRecommendation->customer->kyc->english_date_of_birth,
            '{{customer.grandfather_name}}' => $applyRecommendation->customer->kyc->grandfather_name,
            '{{customer.father_name}}' => $applyRecommendation->customer->kyc->father_name,
            '{{customer.mother_name}}' => $applyRecommendation->customer->kyc->mother_name,
            '{{customer.spouse_name}}' => $applyRecommendation->customer->kyc->spouse_name,
            '{{customer.permanent_province_id}}' => $applyRecommendation->customer->kyc->permanentProvince?->title,
            '{{customer.permanent_district_id}}' => $applyRecommendation->customer->kyc->permanentDistrict?->title,
            '{{customer.permanent_local_body_id}}' => $applyRecommendation->customer->kyc->permanentLocalBody?->title,
            '{{customer.permanent_ward}}' => $applyRecommendation->customer->kyc->permanent_ward,
            '{{customer.permanent_tole}}' => $applyRecommendation->customer->kyc->permanent_tole,
            '{{customer.temporary_province_id}}' => $applyRecommendation->customer->kyc->temporaryProvince?->title,
            '{{customer.temporary_district_id}}' => $applyRecommendation->customer->kyc->temporaryDistrict?->title,
            '{{customer.temporary_local_body_id}}' => $applyRecommendation->customer->kyc->temporaryLocalBody?->title,
            '{{customer.temporary_ward}}' => $applyRecommendation->customer->kyc->temporary_ward,
            '{{customer.temporary_tole}}' => $applyRecommendation->customer->kyc->temporary_tole,
            '{{customer.document_issued_date_nepali}}' => $applyRecommendation->customer->kyc->document_issued_date_nepali,
            '{{customer.document_issued_date_english}}' => $applyRecommendation->customer->kyc->document_issued_date_english,
            '{{customer.document_number}}' => $applyRecommendation->customer->kyc->document_number,
            '{{customer.document_image1}}' => "data:image/jpeg;base64," . base64_encode(ImageServiceFacade::getImage(config('src.CustomerKyc.customerKyc.path'), (string)$applyRecommendation->customer->kyc->document_image1)),
            '{{customer.document_image2}}' => "data:image/jpeg;base64," . base64_encode(ImageServiceFacade::getImage(config('src.CustomerKyc.customerKyc.path'), (string)$applyRecommendation->customer->kyc->document_image2)),
            '{{customer.expiry_date_nepali}}' => $applyRecommendation->customer->kyc->expiry_date_nepali,
            '{{customer.expiry_date_english}}' => $applyRecommendation->customer->kyc->expiry_date_english,
        ]);
    }
    if (isset($applyRecommendation->customer->kyc)) {
        $data = array_merge($data, [
            '{{customer.nepali_date_of_birth}}' => $applyRecommendation->customer->kyc->nepali_date_of_birth,
            '{{customer.english_date_of_birth}}' => $applyRecommendation->customer->kyc->english_date_of_birth,
            '{{customer.grandfather_name}}' => $applyRecommendation->customer->kyc->grandfather_name,
            '{{customer.father_name}}' => $applyRecommendation->customer->kyc->father_name,
            '{{customer.mother_name}}' => $applyRecommendation->customer->kyc->mother_name,
            '{{customer.spouse_name}}' => $applyRecommendation->customer->kyc->spouse_name,
            '{{customer.permanent_province_id}}' => $applyRecommendation->customer->kyc->permanentProvince?->title,
            '{{customer.permanent_district_id}}' => $applyRecommendation->customer->kyc->permanentDistrict?->title,
            '{{customer.permanent_local_body_id}}' => $applyRecommendation->customer->kyc->permanentLocalBody?->title,
            '{{customer.permanent_ward}}' => $applyRecommendation->customer->kyc->permanent_ward,
            '{{customer.permanent_tole}}' => $applyRecommendation->customer->kyc->permanent_tole,
            '{{customer.temporary_province_id}}' => $applyRecommendation->customer->kyc->temporaryProvince?->title,
            '{{customer.temporary_district_id}}' => $applyRecommendation->customer->kyc->temporaryDistrict?->title,
            '{{customer.temporary_local_body_id}}' => $applyRecommendation->customer->kyc->temporaryLocalBody?->title,
            '{{customer.temporary_ward}}' => $applyRecommendation->customer->kyc->temporary_ward,
            '{{customer.temporary_tole}}' => $applyRecommendation->customer->kyc->temporary_tole,
            '{{customer.document_issued_date_nepali}}' => $applyRecommendation->customer->kyc->document_issued_date_nepali,
            '{{customer.document_issued_date_english}}' => $applyRecommendation->customer->kyc->document_issued_date_english,
            '{{customer.document_number}}' => $applyRecommendation->customer->kyc->document_number,
            '{{customer.document_image1}}' => "data:image/jpeg;base64," . base64_encode(ImageServiceFacade::getImage(config('src.CustomerKyc.customerKyc.path'), $applyRecommendation->customer->kyc->document_image1, getStorageDisk('private'))),
            '{{customer.document_image2}}' => "data:image/jpeg;base64," . base64_encode(ImageServiceFacade::getImage(config('src.CustomerKyc.customerKyc.path'), $applyRecommendation->customer->kyc->document_image2, getStorageDisk('private'))),
            '{{customer.expiry_date_nepali}}' => $applyRecommendation->customer->kyc->expiry_date_nepali,
            '{{customer.expiry_date_english}}' => $applyRecommendation->customer->kyc->expiry_date_english,
        ]);
    }
    return \Illuminate\Support\Str::replace(array_keys($data), array_values($data), $applyRecommendation->recommendation?->form?->template);
}

function resolveBusinessRegistrationTemplate(BusinessRegistration $businessRegistration): string
{

    $businessRegistration->load('registrationType', 'fiscalYear', 'province', 'district', 'localBody');
    $acceptorSignature = '{{global.acceptor_sign}}';
    $acceptorDesignation = '{{global.acceptor_designation}}';
    $acceptorName = '';
    if (!empty($businessRegistration->approved_by)) {
        if (!empty($businessRegistration->approvedBy?->signature)) {
            $acceptorSignature = '<img src="' . App\Services\ImageService::getImage(config('src.Profile.profile.path'), $businessRegistration->approvedBy?->signature) . '"
                         alt="Signature" width="80">';
        }
        $acceptorDesignation = $businessRegistration->approvedBy?->designation?->title ?? '______________________';

        $acceptorName = $businessRegistration->approvedBy?->name;
    } else {
        $acceptorDesignation = '______________________';
        $acceptorName = '______________________';
        $acceptorSignature = '______________________';
    }


    $letter = [
        'header' => getLetterHeader(null),
        'footer' => getLetterFooter(null),
    ];

    $decodedData = is_array($businessRegistration->data) ? $businessRegistration->data : json_decode($businessRegistration->data, true) ?? [];
    $resolvedData = $decodedData ? getResolvedFormData($decodedData) : "";

    // Convert arrays to JSON or comma-separated values
    array_walk_recursive($resolvedData, function (&$value) {
        if (is_array($value)) {
            $value = implode(', ', $value); // Convert array to string
        }
    });

    $data = [
        '{{global.letter-head}}' => $letter['header'] ?? '',
        '{{global.letter-head-footer}}' => $letter['footer'] ?? '',
        '{{global.province}}' => getSetting('palika-province'),
        '{{global.district}}' => getSetting('palika-district'),
        '{{global.local-body}}' => getSetting('palika-local-body'),
        '{{global.ward}}' => getSetting('palika-ward'),
        '{{global.today_date_ad}}' => today()->toDateString(),
        '{{global.today_date_bs}}' => replaceNumbers(today()->toDateString(), true),
        '{{global.business_status}}' => $businessRegistration->business_status ?? '',
        '{{global.registration_number}}' => $businessRegistration->registration_number ?? '',
        '{{global.registration_date}}' => $businessRegistration->registration_date ?? '',
        '{{global.rejected_reason}}' => $businessRegistration->application_rejection_reason ?? '',
        '{{global.acceptor_sign}}' => $acceptorSignature,
        '{{global.acceptor_designation}}' => $acceptorDesignation,
        '{{global.acceptor_name}}' => $acceptorName,
        '{{global.palika_name}}' => getSetting('palika-name'),
        '{{global.office_name}}' => getSetting('office-name'),
        '{{global.fiscal_year}}' => getSetting('fiscal-year'),
        '{{global.palika_address}}' => getSetting('palika-address'),
        ...$resolvedData
    ];

    $data = array_merge($data, [
        '{{business.registration_type_id}}' => $businessRegistration->registrationType?->title,
        '{{business.entity_name}}' => $businessRegistration->entity_name,
        '{{business.amount}}' => $businessRegistration->amount,
        '{{business.bill_no}}' => $businessRegistration->bill_no,
        '{{business.application_date}}' => $businessRegistration->application_date,
        '{{business.application_date_en}}' => $businessRegistration->application_date_en,
        '{{business.registration_date}}' => replaceNumbers($businessRegistration->registration_date, true),
        '{{business.registration_date_en}}' => $businessRegistration->registration_date_en,
        '{{business.registration_number}}' => $businessRegistration->registration_number,
        '{{business.certificate_number}}' => $businessRegistration->certificate_number,
        '{{business.province_id}}' => $businessRegistration->province?->title,
        '{{business.district_id}}' => $businessRegistration->district?->title,
        '{{business.local_body_id}}' => $businessRegistration->localBody?->title,
        '{{business.ward_no}}' => $businessRegistration->ward_no,
        '{{business.way}}' => $businessRegistration->way,
        '{{business.tole}}' => $businessRegistration->tole,
        '{{business.data}}' => $businessRegistration->data,
        '{{business.bill}}' => $businessRegistration->bill,
        '{{business.mobile_no}}' => $businessRegistration->mobile_no,
        '{{business.fiscal_year_id}}' => $businessRegistration->fiscalYear?->title,
        '{{business.business_owner_name}}' => $businessRegistration->applicant_name,
        '{{business.business_owner_number}}' => $businessRegistration->applicant_number,
    ]);

    // Convert all values in $data to strings
    $data = array_map(fn($value) => is_array($value) ? json_encode($value) : (string) $value, $data);
    //form ko nam 
    // Replace placeholders with actual values
    return \Illuminate\Support\Str::replace(array_keys($data), array_values($data), $businessRegistration->registrationType?->form?->template ?? '');
}

/**
 * @param int|null $ward_no
 */
function getLetterHeader(?int $ward_no = null)
{
    $office_name = $ward_no
        ? Ward::where('id', $ward_no)->value('ward_name_ne')
        : getSetting('office-name');

    $palika_name = getSetting('palika-name');
    $palika_logo = getSetting('palika-logo');
    $palika_campaign_logo = getSetting('palika-campaign-logo');
    $address = getSetting('palika-district') . ', ' . getSetting('palika-province') . ', ' . 'नेपाल';

    $header = '<div class="main-container">
    <table class="main-table" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="80">
                <img class="logo" src="' . $palika_logo . '" alt="Logo" width="80">
            </td>
            <td class="title" align="center" valign="middle">
                <span style="color: red;">
                    <span style="font-size: 1.6rem; font-weight: bold">' . $palika_name . '</span> <br>
                    <span style="font-size: 1.6rem; font-weight: bold">' . $office_name . ' </span><br>
                    <span style="font-size: 1.2rem">' . $address . '</span>
                </span>
            </td>
            <td width="80">
                <img class="campaign_logo" src="' . $palika_campaign_logo . '" alt="Campaign Logo" width="80">
            </td>
        </tr>
    </table>
</div>';

    return $header;
}

function getLetterFooter(?int $ward_no = null)
{
    if ($ward_no) {
        $letterRecord = LetterHead::where('ward_no', 1)->first() ?? '';
        if (!$letterRecord) {
            return '';
        }
    } else {
        return LetterHead::first()->footer;
    }
}

/**
 * @param array $submittedData
 * @return array
 */
function getResolvedFormData(array $submittedData): array
{
    foreach ($submittedData as $key => $field) {
        if (($field['type'] ?? null) === 'group' && isset($field['fields']) && is_array($field['fields'])) {
            foreach ($field['fields'] as $childKey => $childField) {
                $submittedData[$childKey] = $childField;
            }
            unset($submittedData[$key]);
        }
    }
    return collect($submittedData)
        ->mapWithKeys(function ($data) {
            $slug = $data['slug'];

            if ($data['type'] === 'table') {
                $tableHtml = generateTableHtml($data['fields'] ?? []);
                return ["{{form.{$slug}}}" => $tableHtml];
            } elseif ($data['type'] === 'file') {
                $fileHtml = getFiles($data['value'] ?? null);
                return ["{{form.{$slug}}}" => $fileHtml];
            } else {
                return ["{{form.{$slug}}}" => $data['value'] ?? ''];
            }
        })
        ->toArray();
}

function getFiles(array|string|null $files): string
{
    if (is_null($files)) {
        return '';
    }

    $files = is_array($files) ? $files : [$files];

    return collect($files)->reduce(function ($carry, $file) {
        $file = FileFacade::getFile(config('src.Recommendation.recommendation.path'), $file, getStorageDisk('private'));
        if ($file) {
            $image = base64_encode($file) ?? '';
            return $carry . "<img alt='File' width='50' src='data:image/jpeg;base64,{$image}'>";
        }
        return false;
    }, '');
}

function generateTableHtml(array $fields): string
{
    if (empty($fields)) {
        return '';
    }

    $tableHtml = '<table border="1" style="border-collapse: collapse; width: 100%; border: 1px solid black;"   class="custom-table">';

    // Generate table headers
    $tableHtml .= '<thead><tr class="custom-tr" style="background-color: #f2f2f2;">';
    foreach ($fields[0] as $key => $headerField) {
        $label = $headerField['label'] ?? ucfirst($key);
        $tableHtml .= "<th style='border: 1px solid black; padding: 8px;'>{$label}</th>";
    }
    $tableHtml .= '</tr></thead>';

    // Generate table rows
    $tableHtml .= '<tbody>';
    foreach ($fields as $row) {
        $tableHtml .= '<tr class="custom-tr">';
        foreach ($row as $column) {
            if (key_exists('type', $column)) {
                $value = $column['type'] === 'file'
                    ? getFiles($column['value'] ?? null)
                    : (isset($column['value'])
                        ? (is_array($column['value'])
                            ? (!empty($column['value']) ? implode(', ', $column['value']) : 'N/A')
                            : $column['value'])
                        : 'N/A');
            }
            $tableHtml .= "<td  class=\"custom-td\" style='border: 1px solid black; padding: 8px;'>{$value}</td>";
        }
        $tableHtml .= '</tr>';
    }
    $tableHtml .= '</tbody>';

    $tableHtml .= '</table>';

    return $tableHtml;
}

function getAppLanguage(): string
{
    $currentLanguage = Cookie::get('language', config('app.locale'));

    return $currentLanguage;
}

function fiscalYear()
{
    return FiscalYear::find(key(getSettingWithKey('fiscal-year')))->toArray();
}
function ne_date($date, $format = "yyyy-mm-dd")
{
    $date = new \DateTime(replaceNumbers($date));
    $service  = new NepaliCalendarService();
    $yy = $date->format('Y');
    $mm = $date->format('m');
    $dd = $date->format('d');
    // Call the service method with parsed date components
    return formatDate($service->get_nepali_date(year: $yy, month: $mm, day: $dd), $format);
}

function replaceNumbers($text, $toNepali = false)
{
    $englishToNepali = [
        '0' => '०',
        '1' => '१',
        '2' => '२',
        '3' => '३',
        '4' => '४',
        '5' => '५',
        '6' => '६',
        '7' => '७',
        '8' => '८',
        '9' => '९'
    ];
    $nepaliToEnglish = array_flip($englishToNepali);
    $conversionMap = $toNepali ? $englishToNepali : $nepaliToEnglish;
    return strtr($text, $conversionMap);
}

function replaceNumbersWithLocale($text, $toNepali = false)
{
    if (app()->getLocale() !== 'ne') {
        return $text;
    }
    return replaceNumbers($text, $toNepali);
}

function formatDate($date, $format): string
{
    $formattedDate = str_replace("yyyy", $date['y'], $format);
    $formattedDate = str_replace("mm", str_pad($date['m'], 2, '0', STR_PAD_LEFT), $formattedDate);
    $formattedDate = str_replace("dd", str_pad($date['d'], 2, '0', STR_PAD_LEFT), $formattedDate);
    $formattedDate = str_replace("MM", $date['M'], $formattedDate);
    $formattedDate = str_replace("l", $date['l'], $formattedDate);
    return $formattedDate;
}

function customAsset(string|null $file_path, string|null $file_name, string $disk = 'public')
{
    if (
        empty($file_name)
        || empty($file_path)
    ) {
        return false;
    }
    return ImageServiceFacade::getImage($file_path, $file_name, $disk ?: getStorageDisk());
}

function getWardsArray(): array
{
    $localBodyId = key(getSettingWithKey('palika-local-body'));
    $localBody = LocalBody::findOrFail($localBodyId);

    $wards = $localBody ? getWards($localBody->wards) : [];

    return array_combine($wards, $wards);
}

function customVideoAsset(string|null $file_path, string|null $file_name, string $disk = 'public')
{
    if (
        empty($file_name)
        || empty($file_path)
    ) {
        return false;
    }
    return VideoServiceFacade::getVideo($file_path, $file_name, $disk ?: getStorageDisk());
}


function customFileAsset(string|null $file_path, string|null $file_name, string $disk = 'public', string $type = "getFile")
{
    if (
        empty($file_name)
        || empty($file_path)
    ) {
        return false;
    }
    
    // Always use Backblaze for file operations if configured
    $preferredDisk = getStorageDisk($disk === 'public' ? 'public' : 'private');
    
    if($type === 'tempUrl')
    {
         return FileFacade::getTemporaryUrl($file_path, $file_name, $preferredDisk, 60); // 1 hour expiration
    }
    return FileFacade::getFile($file_path, $file_name, $preferredDisk);
    
}

function getVideoThumbnail($video)
{
    if ($video->file) {
        return asset('digitalBoard/icons/video-thumbnail.png');
    }

    if ($video->url && (strpos($video->url, 'youtube.com') !== false || strpos($video->url, 'youtu.be') !== false)) {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $video->url, $matches);
        if (!empty($matches[1])) {
            return "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
        }
    }

    return asset('digitalBoard/icons/video-thumbnail.png');
}

function resolveEjalasTemplate($model, $value = null)
{
    if (!$model) {
        return ['template' => '', 'styles' => ''];
    }

    $data = [
        '{{global.letter-head}}' => getLetterHeader(null),
        '{{global.letter-head-footer}}' => getLetterFooter(null),
        '{{global.province}}' => getSetting('palika-province'),
        '{{global.officeName}}' => getSetting('palika-name'),
        '{{global.district}}' => getSetting('palika-district'),
        '{{global.local-body}}' => getSetting('palika-local-body'),
        '{{global.ward}}' => getSetting('palika-ward'),
        '{{global.today_date_ad}}' => today()->toDateString(),
        '{{global.today_date_bs}}' => today()->toDateString(),
    ];
    // Load relationships dynamically based on model type
    if ($model instanceof ComplaintRegistration) {
        // Load related data for ComplaintRegistration
        $model->load([
            'disputeMatter',
            'priority',
            'fiscalYear',
            'parties',
            'parties.permanentDistrict',
            'parties.permanentLocalBody',
            'parties.temporaryDistrict',
            'parties.temporaryLocalBody',
            'disputeMatter.disputeArea'
        ]);

        // Get parties
        $complainers = $model->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
        $defenders = $model->parties->filter(fn($party) => $party->pivot->type === 'Defender');


        // Merge data with ComplaintRegistration specific placeholders
        $data = array_merge($data, [
            '{{jms_complaint.subject}}' => $model->disputeMatter->disputeArea->title . ' ' . $model->disputeMatter->title . ' ' . $model->subject,
            '{{jms_parties.complainerDetail}}' => generatePartyDetails($complainers, 'प्रथम पक्ष'),
            '{{jms_parties.defenderDetail}}' => generatePartyDetails($defenders, 'दोश्रो पक्ष'),
            '{{jms_complaint.description}}' => $model->description,
            '{{jms_complaint.applicant}}' => $complainers->isNotEmpty() ? $complainers->pluck('name')->filter()->implode(', ') : 'X',
            '{{jms_complaint.applicantNumber}}' => $complainers->isNotEmpty() ? $complainers->pluck('phone_no')->filter()->implode(', ') : 'X',
            '{{jms_complaint.footerDate}}' => convertToNepaliDateFormat($model->reg_date),
        ]);
    } elseif ($model instanceof DisputeRegistrationCourt) {
        // Load related data for DisputeRegistrationCourt
        $model->load([
            'complaintRegistration',
            'complaintRegistration.parties',
            'complaintRegistration.disputeMatter',
            'complaintRegistration.priority',
            'complaintRegistration.fiscalYear',
            'complaintRegistration.parties.permanentDistrict',
            'complaintRegistration.parties.permanentLocalBody',
            'complaintRegistration.parties.temporaryDistrict',
            'complaintRegistration.parties.temporaryLocalBody',
            'complaintRegistration.disputeMatter.disputeArea',
            'judicialEmployee',
            'judicialEmployee.designation'
        ]);
        $complainers = $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
        $defenders = $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');

        $data = array_merge($data, [
            '{{jms_parties.complainerDetail}}' => generatePartyDetails($complainers, 'प्रथम पक्ष'),
            '{{jms_parties.defenderDetail}}' => generatePartyDetails($defenders, 'दोश्रो पक्ष'),
            '{{jms_complaintDetail}}' => $model->complaintRegistration->disputeMatter->disputeArea->title . ' '
                . $model->complaintRegistration->disputeMatter->title . ' '
                . $model->complaintRegistration->subject,
            '{{jms_complaintNumber}}' => $model->complaintRegistration->reg_no,
            '{{jms_judicialEmployeeName}}' => $model->judicialEmployee->name,
            '{{jms_judicialEmployeeDesignation}}' => $model->judicialEmployee->designation->title,
            '{{jms_decisionDate}}' => $model->decision_date,
        ]);
    } elseif ($model instanceof DisputeDeadline) {
        $model->load([
            'complaintRegistration.disputeMatter.disputeArea',
            'complaintRegistration.priority',
            'complaintRegistration.fiscalYear',
            'complaintRegistration.parties.permanentDistrict',
            'complaintRegistration.parties.permanentLocalBody',
            'complaintRegistration.parties.temporaryDistrict',
            'complaintRegistration.parties.temporaryLocalBody',
            'complaintRegistration.disputeMatter'
        ]);

        $complainers = $model->complaintRegistration->parties->where('type', 'Complainer');
        $defenders = $model->complaintRegistration->parties->where('type', 'Defender');

        $data = array_merge($data, [
            // '{{jms_complaint.subject}}' => $model->disputeMatter->disputeArea->title . ' ' . $model->disputeMatter->title . ' ' . $model->subject,
            // '{{jms_parties.complainerDetail}}' => generatePartyDetails($complainers, 'प्रथम पक्ष'),
            // '{{jms_parties.defenderDetail}}' => generatePartyDetails($defenders, 'दोश्रो पक्ष'),
            // '{{jms_complaint.description}}' => $model->description,
            // '{{jms_disputeDeadline.extensionPeriod}}' => $model->disputeDeadline->extensionPeriod,
            // '{{jms_judicialEmployeeName}}' => $model->judicialEmployee->name,
            // '{{jms_judicialEmployeeDesignation}}' => $model->judicialEmployee->designation->title,
            // '{{jms_decisionDate}}' => $model->decision_date,
        ]);
    } elseif ($model instanceof JudicialMeeting) {
        $inivitedMember = $model->members->filter(fn($member) => $member->pivot->type === 'invited');
        $presentMember = $model->members->filter(fn($member) => $member->pivot->type === 'present');
        $firstPresent = $presentMember->first();

        $presentText = "";
        foreach ($presentMember as $member) {
            $presentText .= "श्री {$member->title} - {$member->elected_position}<br/>";
        }
        $invitedText = "";
        foreach ($inivitedMember as $member) {
            $invitedText .= "श्री {$member->title} - {$member->elected_position}<br/>";
        }
        $model->load([]);

        $data = array_merge($data, [
            '{{employee_name}}' => $firstPresent ? $firstPresent->title : '',
            '{{meeting_date}}' => $model->meeting_date,
            '{{meeting_time}}' => $model->meeting_time,
            '{{meeting_topic}}' => $model->meeting_topic,
            '{{discussion_details}}' => $model->decision_details,
            '{{present_member}}' => $presentText,
            '{{invited_member}}' => $invitedText,
        ]);
    }
    $data = array_map(fn($value) => is_array($value) ? json_encode($value) : (string) $value, $data);
    // Get form template
    $template = Form::where('title', $value)->first(); //store template data so that user can fetch style and template based on model name
    if (!$template) {
        return ['template' => '', 'styles' => ''];
    }


    // Replace placeholders in the template
    return [ //returns template and styles
        'template' => \Illuminate\Support\Str::replace(array_keys($data), array_values($data), $template->template ?? ''),
        'styles' => $template->styles ?? ''
    ];
}

function generatePartyDetails($parties, $partyLabel)
{
    if ($parties->isEmpty()) {
        return "निवेदकको विवरण उपलब्ध छैन।";
    }

    $details = '';
    foreach ($parties as $party) {
        $details .= ($party->permanentDistrict?->title) . " जिल्ला, ";
        $details .= ($party->permanentLocalBody?->title) . " वडा नं ";
        $details .= ($party->permanent_ward_id) . " ";
        $details .= ($party->permanent_tole) . " मा बस्ने ";
        $details .= ($party->grandfather_name) . " को नाती/नातिनी, ";
        $details .= ($party->father_name) . " को छोरा/छोरी ";
        $details .= "वर्ष " . ($party->age) . " को <strong>" . ($party->name) . "</strong> ";
        $details .= "निवेदक ($partyLabel)";
    }

    return $details;
}
function convertToNepaliDateFormat($bsDate)
{
    // Mapping of BS month numbers to Nepali names
    $monthNames  = [
        '०१' => 'वैशाख',
        '०२' => 'जेठ',
        '०३' => 'असार',
        '०४' => 'श्रावण',
        '०५' => 'भाद्र',
        '०६' => 'आश्विन',
        '०७' => 'कार्तिक',
        '०८' => 'मंसिर',
        '०९' => 'पौष',
        '१०' => 'माघ',
        '११' => 'फाल्गुण',
        '१२' => 'चैत्र'
    ];

    [$year, $month, $day] = explode('-', $bsDate);

    // Map month number to month name
    $monthName = $monthNames[$month] ?? '';

    return "इती संवत् {$year} साल {$monthName} महिना {$day} गते.........रोज शुभम् ।";
}


function resolveYojanaTemplate($model, $value = null)
{
    if (!$model) {
        return '';
    }
    $data = [
        '{{global.letter-head}}' => getLetterHeader(null),
        '{{global.letter-head-footer}}' => getLetterFooter(null),
        '{{global.province}}' => getSetting('palika-province'),
        '{{global.officeName}}' => getSetting('palika-name'),
        '{{global.district}}' => getSetting('palika-district'),
        '{{global.local-body}}' => getSetting('palika-local-body'),
        '{{global.ward}}' => getSetting('palika-ward'),
        '{{global.today_date_ad}}' => today()->toDateString(),
        '{{global.today_date_bs}}' => today()->toDateString(),
    ];

    if ($model instanceof WorkOrder) {
        // Load related data for ComplaintRegistration
        // $model->load([
        //     'disputeMatter',
        //     'priority',
        //     'fiscalYear',
        //     'parties.permanentDistrict',
        //     'parties.permanentLocalBody',
        //     'parties.temporaryDistrict',
        //     'parties.temporaryLocalBody',
        //     'disputeMatter.disputeArea'
        // ]);


        // Merge data with ComplaintRegistration specific placeholders
        $data = array_merge($data, [
            '{{yojana_workload.projectName}}' => $model->plan_name,
            '{{yojana_workload.date}}' => $model->date,
            '{{yojana_workload.subject}}' => $model->subject,
            '{{yojana_workload.letterBody}}' => $model->letter_body,
        ]);
    }

    $data = array_map(fn($value) => is_array($value) ? json_encode($value) : (string) $value, $data);
    // Get form template
    $template = Form::where('title', $value)->first()->template ?? '';

    // Replace placeholders in the template
    return \Illuminate\Support\Str::replace(array_keys($data), array_values($data), $template ?? '');
}

function nepaliMonthName(int $monthNumber): string
{
    return match ($monthNumber) {
        1 => 'बैशाख',
        2 => 'जेठ',
        3 => 'असार',
        4 => 'श्रावण',
        5 => 'भदौ',
        6 => 'आश्विन',
        7 => 'कार्तिक',
        8 => 'मंसिर',
        9 => 'पुष',
        10 => 'माघ',
        11 => 'फाल्गुण',
        12 => 'चैत्र',
        default => 'अमान्य महिना',
    };
}



function resolveMapStepTemplate(MapApply $mapApply, MapStep $mapStep, $form): string
{
    $mapApply->load('customer.kyc', 'fiscalYear', 'landDetail.fourBoundaries', 'constructionType', 'mapApplySteps');

    $signatures = '______________________';

    $letter = [
        'header' => getLetterHeader(null),
        'footer' => getLetterFooter(null),
    ];

    $data = [
        '{{global.letter-head}}' => $letter['header'] ?? '',
        '{{global.letter-head-footer}}' => $letter['footer'] ?? '',
        '{{global.province}}' => getSetting('palika-province'),
        '{{global.district}}' => getSetting('palika-district'),
        '{{global.local-body}}' => getSetting('palika-local-body'),
        '{{global.ward}}' => getSetting('palika-ward'),
        '{{global.today_date_ad}}' => today()->toDateString(),
        '{{global.today_date_bs}}' => today()->toDateString(),
        '{{global.business_status}}' => $businessRegistration->business_status ?? '',
        '{{global.registration_number}}' => $businessRegistration->registration_number ?? '',
        '{{global.registration_date}}' => $businessRegistration->registration_date ?? '',
        '{{global.rejected_reason}}' => $businessRegistration->application_rejection_reason ?? '',
        // '{{global.acceptor_sign}}' => $acceptorSignature,
    ];

    $data = array_merge($data, [
        '{{customer.nepali_date_of_birth}}' => $mapApply->customer->kyc->nepali_date_of_birth,
        '{{customer.english_date_of_birth}}' => $mapApply->customer->kyc->english_date_of_birth,
        '{{customer.grandfather_name}}' => $mapApply->customer->kyc->grandfather_name,
        '{{customer.father_name}}' => $mapApply->customer->kyc->father_name,
        '{{customer.mother_name}}' => $mapApply->customer->kyc->mother_name,
        '{{customer.spouse_name}}' => $mapApply->customer->kyc->spouse_name,
        '{{customer.permanent_province_id}}' => $mapApply->customer->kyc->permanentProvince?->title,
        '{{customer.permanent_district_id}}' => $mapApply->customer->kyc->permanentDistrict?->title,
        '{{customer.permanent_local_body_id}}' => $mapApply->customer->kyc->permanentLocalBody?->title,
        '{{customer.permanent_ward}}' => $mapApply->customer->kyc->permanent_ward,
        '{{customer.permanent_tole}}' => $mapApply->customer->kyc->permanent_tole,
        '{{customer.temporary_province_id}}' => $mapApply->customer->kyc->temporaryProvince?->title,
        '{{customer.temporary_district_id}}' => $mapApply->customer->kyc->temporaryDistrict?->title,
        '{{customer.temporary_local_body_id}}' => $mapApply->customer->kyc->temporaryLocalBody?->title,
        '{{customer.temporary_ward}}' => $mapApply->customer->kyc->temporary_ward,
        '{{customer.temporary_tole}}' => $mapApply->customer->kyc->temporary_tole,
        '{{customer.document_issued_date_nepali}}' => $mapApply->customer->kyc->document_issued_date_nepali,
        '{{customer.document_issued_date_english}}' => $mapApply->customer->kyc->document_issued_date_english,
        '{{customer.document_number}}' => $mapApply->customer->kyc->document_number,
        '{{customer.document_image1}}' => "data:image/jpeg;base64," . base64_encode(ImageServiceFacade::getImage(config('src.CustomerKyc.customerKyc.path'), $mapApply->customer->kyc->document_image1, getStorageDisk('private'))),
        '{{customer.document_image2}}' => "data:image/jpeg;base64," . base64_encode(ImageServiceFacade::getImage(config('src.CustomerKyc.customerKyc.path'), $mapApply->customer->kyc->document_image2, getStorageDisk('private'))),
        '{{customer.expiry_date_nepali}}' => $mapApply->customer->kyc->expiry_date_nepali,
        '{{customer.expiry_date_english}}' => $mapApply->customer->kyc->expiry_date_english,

    ]);

    $data = array_merge($data, [
        '{{mapApply.customer.name}}' => $mapApply->customer->name,
        '{{mapApply.landDetail.ward_no}}' => $mapApply->landDetail->ward,
        '{{mapApply.landDetail.tole}}' => $mapApply->landDetail->tole,
        '{{mapApply.landDetail.plot_no}}' => $mapApply->landDetail->lot_no,
        '{{mapApply.landDetail.area}}' => $mapApply->landDetail->area_sqm,
        '{{mapApply.landDetail.ownership_type}}' => $mapApply->landDetail->ownership,
        '{{mapApply.usage}}' => $mapApply->usage,
        '{{mapApply.landDetail.fourForts:name,direction,distance_to,plot_no}}' =>
        '<table border="1" cellpadding="5" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Direction</th>
                            <th>Distance To</th>
                            <th>Plot No</th>
                        </tr>
                    </thead>
                    <tbody>' .
            $mapApply->landDetail->fourBoundaries->map(
                fn($fort) =>
                "<tr>
                            <td>{$fort->title}</td>
                            <td>{$fort->direction}</td>
                            <td>{$fort->distance}</td>
                            <td>{$fort->lot_no}</td>
                        </tr>"
            )->implode('') .
            '</tbody></table>',
        '{{mapApply.constructionType.title}}' => $mapApply->constructionType->title,
        '{{mapApply.signature}}' => '<img src="data:image/jpeg;base64,' . base64_encode(ImageServiceFacade::getImage(config('src.Ebps.ebps.path'), $mapApply->signature, getStorageDisk('private'))) . '" 
                         alt="Signature" width="80">',
        '{{mapApply.customer.age}}' => $mapApply->customer->customerDetail->age ?? null,
        '{{customer.phone}}' => $mapApply->customer->phone,
        '{{mapApply.customer.customerDetail.age}}' => $mapApply->age,
        '{{mapApply.customer.phone}}' => $mapApply->customer->mobile_no,
        '{{form.approver.signature}}' => $signatures
    ]);



    $data = array_map(fn($value) => is_array($value) ? json_encode($value) : (string) $value, $data);

    return \Illuminate\Support\Str::replace(array_keys($data), array_values($data), $form->template ?? '');
}

// Storage Helper Functions
if (!function_exists('getStorageDisk')) {
    /**
     * Get the appropriate storage disk based on environment configuration
     * Prioritizes Backblaze for all file operations
     */
    function getStorageDisk(?string $type = null): string
    {
        // Always prioritize Backblaze if configured
        if (config('filesystems.disks.backblaze.key')) {
            return 'backblaze';
        }
        
        $defaultDisk = config('filesystems.default', 'local');
        
        if ($defaultDisk === 'backblaze') {
            return 'backblaze';
        }
        
        $useCloudStorage = env('USE_CLOUD_STORAGE', false);
        
        if ($useCloudStorage) {
            if (config('filesystems.disks.backblaze.key')) {
                return 'backblaze';
            } elseif (config('filesystems.disks.s3.key')) {
                return 's3';
            }
        }
        
        if ($type === 'public') {
            return config('filesystems.disks.backblaze.key') ? 'backblaze' : 'public';
        }
        
        if ($type === 'private') {
            return config('filesystems.disks.backblaze.key') ? 'backblaze' : 'local';
        }
        
        return $defaultDisk;
    }
}

if (!function_exists('isCloudStorage')) {
    /**
     * Check if we're using cloud storage
     */
    function isCloudStorage(): bool
    {
        $disk = getStorageDisk();
        return in_array($disk, ['s3', 'backblaze']);
    }
}

if (!function_exists('getTenantPrefix')) {
    /**
     * Get the tenant prefix for file storage
     */
    function getTenantPrefix(): string
    {
        return env('APP_ABBREVIATION', 'default');
    }
}

if (!function_exists('getTenantPrefixedPath')) {
    /**
     * Get path with tenant prefix for cloud storage
     */
    function getTenantPrefixedPath(string $path, ?string $disk = null): string
    {
        $disk = $disk ?: getStorageDisk();
        
        // Only add prefix for cloud storage since local storage doesn't need it
        if (isCloudStorage() && in_array($disk, ['s3', 'backblaze'])) {
            // The 'root' parameter in filesystems.php already handles the prefix
            // so we don't need to manually prepend it here as Laravel handles it
            return $path;
        }
        
        return $path;
    }
}

if (!function_exists('uploadToStorage')) {
    /**
     * Upload file to appropriate storage with proper disk selection and tenant prefix
     */
    function uploadToStorage($file, string $path, ?string $disk = null, array $options = [])
    {
        $disk = $disk ?: getStorageDisk();
        $storage = Storage::disk($disk);
        
        try {
            if (is_string($file)) {
                // Base64 or file content
                return $storage->put($path, $file, $options) ? $path : false;
            } elseif ($file instanceof \Illuminate\Http\UploadedFile) {
                // Uploaded file
                return $file->store($path, $disk);
            } else {
                // Raw content
                return $storage->put($path, $file, $options) ? $path : false;
            }
        } catch (\Exception $e) {
            \Log::error('Storage upload failed: ' . $e->getMessage(), [
                'path' => $path,
                'disk' => $disk,
                'error' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}

if (!function_exists('getStorageUrl')) {
    /**
     * Get storage URL with proper handling for different storage types
     */
    function getStorageUrl(string $key, string $disk = null, int $expiryMinutes = 60): ?string
    {
        try {
            $disk = $disk ?: getStorageDisk();
            $storage = Storage::disk($disk);

            \Log::info('Getting storage URL', [
                'key' => $key,
                'disk' => $disk,
                'tenant_prefix' => getTenantPrefix()
            ]);

            // Check if file exists
            if (!$storage->exists($key)) {
                Log::warning('File not found for URL generation', [
                    'key' => $key, 
                    'disk' => $disk,
                    'tenant_prefix' => getTenantPrefix(),
                    'expected_full_path' => getTenantPrefix() . '/' . $key
                ]);
                return null;
            }

            \Log::info('File found, generating URL', [
                'key' => $key,
                'disk' => $disk,
                'visibility' => config("filesystems.disks.{$disk}.visibility")
            ]);

            // For public disks, use public URL
            if ($disk === 'public' || config("filesystems.disks.{$disk}.visibility") === 'public') {
                return $storage->url($key);
            }

            // For private cloud storage, use temporary URL
            if (isCloudStorage() && in_array($disk, ['s3', 'backblaze'])) {
                return $storage->temporaryUrl($key, now()->addMinutes($expiryMinutes));
            }

            // For local storage, use local file controller
            if ($disk === 'local') {
                return \App\Http\Controllers\LocalFileController::getDownloadUrl($key);
            }

            // Fallback to temporary URL
            try {
                return $storage->temporaryUrl($key, now()->addMinutes($expiryMinutes));
            } catch (\RuntimeException $e) {
                // If temporary URLs are not supported, try to get a regular URL
                $driver = $storage->getDriver();
                
                if (method_exists($driver, 'url')) {
                    return $driver->url($key);
                } else {
                    Log::warning("Storage driver for disk '{$disk}' does not support URLs or temporary URLs", [
                        'key' => $key,
                        'error' => $e->getMessage()
                    ]);
                    return null;
                }
            }

        } catch (\Exception $e) {
            Log::error('Failed to get storage URL', [
                'key' => $key,
                'disk' => $disk,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}

if (!function_exists('safeFilePreview')) {
    /**
     * Safely generate a file preview URL or return appropriate fallback
     */
    function safeFilePreview($file, string $fallbackText = 'File Preview')
    {
        if (!$file) {
            return null;
        }

        try {
            // Check if the file has a temporaryUrl method (Livewire uploaded file)
            if (method_exists($file, 'temporaryUrl')) {
                $filename = $file->getFilename();
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                // Check if it's a previewable image
                $previewableImages = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
                if (in_array($extension, $previewableImages)) {
                    return $file->temporaryUrl();
                }
                
                // For non-previewable files, return null to show fallback
                return null;
            }
            
            // If it's a regular file path or URL
            if (is_string($file)) {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $previewableImages = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
                
                if (in_array($extension, $previewableImages)) {
                    return $file;
                }
            }
            
            return null;
        } catch (\Exception $e) {
            \Log::warning('File preview generation failed: ' . $e->getMessage(), [
                'file' => $file,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}

if (!function_exists('getFileTypeIcon')) {
    /**
     * Get appropriate icon class for file type
     */
    function getFileTypeIcon($file): string
    {
        if (!$file) {
            return 'fas fa-file';
        }

        try {
            $filename = '';
            
            if (method_exists($file, 'getFilename')) {
                $filename = $file->getFilename();
            } elseif (is_string($file)) {
                $filename = $file;
            }
            
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            return match($extension) {
                'pdf' => 'fas fa-file-pdf text-danger',
                'doc', 'docx' => 'fas fa-file-word text-primary',
                'xls', 'xlsx' => 'fas fa-file-excel text-success',
                'ppt', 'pptx' => 'fas fa-file-powerpoint text-warning',
                'txt' => 'fas fa-file-alt text-secondary',
                'zip', 'rar', '7z' => 'fas fa-file-archive text-warning',
                'mp4', 'avi', 'mov', 'wmv' => 'fas fa-file-video text-info',
                'mp3', 'wav', 'm4a' => 'fas fa-file-audio text-success',
                default => 'fas fa-file text-muted'
            };
        } catch (\Exception $e) {
            return 'fas fa-file text-muted';
        }
    }
}