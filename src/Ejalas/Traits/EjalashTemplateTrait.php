<?php

namespace Src\Ejalas\Traits;

use App\Facades\ImageServiceFacade;
use App\Traits\HelperDate;
use App\Traits\HelperTemplate;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapApplyStepTemplate;
use Src\Settings\Models\Form;

trait EjalashTemplateTrait
{
    use HelperDate, HelperTemplate;
    function resolveEjalasTemplate($model, $value = null)
    {
        if (!$model) {
            return '';
        }

        $modelName = class_basename($model);

        $data = [
            '{{global.letter-head}}' => $this->getLetterHeader(null),
            '{{global.province}}' => getSetting('palika-province'),
            '{{global.province_ne}}' => getSetting('palika-province-ne'),
            '{{global.district_ne}}' => getSetting('palika-district-ne'),
            '{{global.local_body_ne}}' => getSetting('palika-local-body-ne'),
            '{{global.ward_ne}}' => getSetting('palika-ward-ne'),
            '{{global.palika_name}}' => getSetting('palika-name'),
            '{{global.address}}' => getSetting('palika-address'),
            '{{global.office_name}}' => getSetting('palika-name'),
            '{{global.officeName}}' => getSetting('palika-name'),
            '{{global.district}}' => getSetting('palika-district'),
            '{{global.local-body}}' => getSetting('palika-local-body'),
            '{{global.ward}}' => getSetting('palika-ward'),
            '{{global.today_date_ad}}' => today()->toDateString(),
            '{{global.today_date_bs}}' => replaceNumbers($this->adToBs(today()->toDateString(), 'yyyy-mm-dd'), true),
        ];

        switch ($modelName) {

            case "ComplaintRegistration":
                // Load related data for ComplaintRegistration
                $model->load([
                    'disputeMatter',
                    'disputeMatter.disputeArea',
                    'priority',
                    'fiscalYear',
                    'parties.permanentDistrict',
                    'parties.permanentLocalBody',
                    'parties.temporaryDistrict',
                    'parties.temporaryLocalBody',
                    'disputeMatter.disputeArea',
                    'disputeRegistrationCourt',
                    'disputeRegistrationCourt.judicialEmployee',
                    'disputeRegistrationCourt.judicialEmployee.designation',
               
                    'hearingSchedule',
                    'courtNotice',
                    'writtenResponseRegistration',
                    'mediatorSelection.mediator',
                    'witnessesRepresentative',
                    'settlement',
                    'caseRecord.judicialEmployee.designation',
                    'caseRecord.judicialMember',
                    'disputeDeadline'
                ]);


                $complainers = $model->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
                $defenders =  $model->parties->filter(fn($party) => $party->pivot->type === 'Defender');

                $complainerDetailsArray = $this->generatePartyDetails($complainers);

                $defenderDetailsArray = $this->generatePartyDetails($defenders);


                $complainerTextPlain = '';
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerTextPlain .= "{$c['district']} जिल्ला, {$c['local_body']} वडा नं {$c['ward']}, {$c['tole']} बस्ने {$c['grandfather_name']}को नाती/नातिनी, {$c['father_name']}को छोरा/छोरी {$c['spouse_name']}को श्रीमान/श्रीमती वर्ष {$c['age']}को  {$c['name']} निवेदक (प्रथम पक्ष) <br>";
                }

                $defenderTextPlain = '';
                foreach ($defenderDetailsArray as $i => $d) {
                    $defenderTextPlain .= "{$d['district']} जिल्ला, {$d['local_body']} वडा नं {$d['ward']}, {$d['tole']} बस्ने {$d['grandfather_name']}को नाती/नातिनी, {$d['father_name']}को छोरा/छोरी {$d['spouse_name']}को श्रीमान/श्रीमती वर्ष {$d['age']}को  {$d['name']} विपक्षी (दोश्रो पक्ष) <br>";
                }


                $complainerFields = $this->extractPartyFields($complainerDetailsArray);

$complainerDistrict = $complainerFields['district'];
$complainerLocalBody = $complainerFields['local_body'];
$complainerWard = $complainerFields['ward'];
$complainerTole = $complainerFields['tole'];
$complainerGrandfather = $complainerFields['grandfather_name'];
$complainerFather = $complainerFields['father_name'];
$complainerSpouse = $complainerFields['spouse_name'];
$complainerAge = $complainerFields['age'];
$complainerName = $complainerFields['name'];
$complainerNumber = $complainerFields['phone'];

$defenderFields = $this->extractPartyFields($defenderDetailsArray);

$defenderDistrict = $defenderFields['district'];
$defenderLocalBody = $defenderFields['local_body'];
$defenderWard = $defenderFields['ward'];
$defenderTole = $defenderFields['tole'];
$defenderGrandfather = $defenderFields['grandfather_name'];
$defenderFather = $defenderFields['father_name'];
$defenderSpouse = $defenderFields['spouse_name'];
$defenderAge = $defenderFields['age'];
$defenderName = $defenderFields['name'];
$defenderNumber = $defenderFields['phone'];
$today = date('Y-m-d');
$bsDate = $this->convertToNepaliDateFormat(replaceNumbers($this->AdTobs($today), true));
$nepaliDateParts = $this->convertToNepaliDateParts($bsDate);

$regYear = $nepaliDateParts['year'];
$regMonth = $nepaliDateParts['month'];
$regDay = $nepaliDateParts['day'];
$latestHearingSchedule = $model->hearingSchedule()->latest('created_at')->first();
$latestCourtNotice = $model->courtNotice()->latest('created_at')->first();
$latestWrittenResponse = $model->writtenResponseRegistration()->latest('created_at')->first();
$latestMediatorSelection = $model->mediatorSelection()->latest('created_at')->first();
$latestWitness = $model->witnessesRepresentative()->latest('created_at')->first();
$latestSettlement = $model->settlement()->latest('created_at')->first();
$latestCaseRecord = $model->caseRecord()->latest('created_at')->first();
$latestDisputeDeadline = $model->disputeDeadline()->latest('created_at')->first();



                $data = array_merge($data, [
                    '{{complainer_detail_plain}}' => $complainerTextPlain ?? '',
                    '{{defender_detail_plain}}' => $defenderTextPlain ?? '',
                    '{{complainer_detail_br}}' => $complainerTextBr ?? '',
                    '{{defender_detail_br}}' => $defenderTextBr ?? '',
                    '{{dispute_area}}' => $model->disputeMatter?->disputeArea->title ?? '',
                    '{{dispute_matter}}' => $model->disputeMatter?->title ?? '',
                    '{{complaint_registration_subject}}' => $model->subject ?? '',
                    '{{complaint_description}}' => $model->description ?? '',
                    '{{complainer_name}}' => $complainerName ?? '',
                    '{{complainer_number}}' => $complainerNumber ?? '',
                    '{{defender_name}}' => $defenderName ?? '',
                    '{{defender_number}}' => $defenderNumber ?? '',
                    '{{reg_date}}' => $this->convertToNepaliDateFormat(replaceNumbers($this->AdTobs($model->reg_date), true)) ?? '',
                 

    // Complainers
    '{{complainer_district}}' => $complainerDistrict ?? '',
    '{{complainer_local_body}}' => $complainerLocalBody ?? '',
    '{{complainer_ward}}' => $complainerWard ?? '',
    '{{complainer_tole}}' => $complainerTole ?? '',
    '{{complainer_grandfather_name}}' => $complainerGrandfather ?? '',
    '{{complainer_father_name}}' => $complainerFather ?? '',
    '{{complainer_spouse_name}}' => $complainerSpouse ?? '',
    '{{complainer_age}}' => $complainerAge ?? '',

    // Defenders
    '{{defender_district}}' => $defenderDistrict ?? '',
    '{{defender_local_body}}' => $defenderLocalBody ?? '',
    '{{defender_ward}}' => $defenderWard ?? '',
    '{{defender_tole}}' => $defenderTole ?? '',
    '{{defender_grandfather_name}}' => $defenderGrandfather ?? '',
    '{{defender_father_name}}' => $defenderFather ?? '',
    '{{defender_spouse_name}}' => $defenderSpouse ?? '',
    '{{defender_age}}' => $defenderAge ?? '',

    '{{reg_year}}' => $regYear ?? '',
    '{{reg_month}}' => $regMonth ?? '',
    '{{reg_day}}' => $regDay ?? '',
    '{{complaint_registration_no}}' => $model->reg_no ?? '',
    '{{complaint_registration_ward_no}}' => $model->ward_no ?? '',


    //disputeRegistrationCourt
    '{{dispute_entry_judicial_employee_name}}' => $model->disputeRegistrationCourt?->judicialEmployee?->name ?? '',
    '{{dispute_entry_judicial_employee_designation}}' => $model->disputeRegistrationCourt?->judicialEmployee?->designation?->title ?? '',
    '{{dispute_decision_date}}' => $model->disputeRegistrationCourt?->decision_date ?? '',

    // Hearing Schedule Related Placeholders
    '{{hearing_time}}' => $latestHearingSchedule?->hearing_time ?? '',

    '{{hearing_date}}' => $latestHearingSchedule ? replaceNumbers($this->AdTobs($latestHearingSchedule->hearing_date), true) : '',

    // Court Notice Related Placeholders
    '{{notice_time}}' => $latestCourtNotice?->notice_time ?? '',
    '{{notice_date}}' => $latestCourtNotice ? $this->convertToNepaliDateFormat($latestCourtNotice->notice_date) : '',

    // Written Response Related Placeholders
    '{{written_response_description}}' => $latestWrittenResponse?->description ?? '',
    '{{written_response_fee_amount}}' => $latestWrittenResponse?->fee_amount ?? '',
    '{{written_response_fee_receipt_no}}' => $latestWrittenResponse?->fee_receipt_no ?? '',
    '{{written_response_fee_paid_date}}' => $latestWrittenResponse?->fee_paid_date ?? '',
    '{{written_response_date}}' => $latestWrittenResponse ? $this->convertToNepaliDateFormat(replaceNumbers($latestWrittenResponse->registration_date, true)) : '',

    // Mediator Selection Related Placeholders
    '{{mediator_name}}' => $latestMediatorSelection?->mediator?->mediator_name ?? '',
    '{{mediator_address}}' => $latestMediatorSelection?->mediator?->mediator_address ?? '',
    '{{mediator_selection_date}}' => $latestMediatorSelection ? $this->convertToNepaliDateFormat(replaceNumbers($latestMediatorSelection->selection_date, true)) : '',

    // Witnesses Related Placeholders
    '{{witness_name}}' => $latestWitness?->name ?? '',
    '{{witness_address}}' => $latestWitness?->address ?? '',

    // Settlement Related Placeholders
    '{{settlement_detail}}' => $latestSettlement?->settlement_details ?? '',
    '{{settlement_date}}' => $latestSettlement ? $this->convertToNepaliDateFormat(replaceNumbers($latestSettlement->settlement_date, true)) : '',
    '{{discussion_date}}' => $latestSettlement ? $this->convertToNepaliDateFormat(replaceNumbers($latestSettlement->discussion_date, true)) : '',
    '{{complaint_registration_claim_request}}' => $model->claim_request ?? '',

    // Case Record Related Placeholders
    '{{complaint_registration_date}}' => replaceNumbers($this->adToBs($model->reg_date), true) ?? '',
    '{{recording_officer_name}}' => $latestCaseRecord?->judicialEmployee?->name ?? '',
    '{{decision_authority}}' => $latestCaseRecord?->judicialMember?->title ?? '',
    '{{recording_officer_position}}' => $latestCaseRecord?->judicialEmployee?->designation?->title ?? '',
    '{{decision_date}}' => $latestCaseRecord ? replaceNumbers($this->adToBs($latestCaseRecord->decision_date), true) : '',
    '{{case_remark}}' => $latestCaseRecord?->remarks ?? '',

    // Dispute Deadline Related Placeholders
    '{{extension_period}}' => $latestDisputeDeadline?->deadline_extension_period ?? '',

                ]);
                break;

            case "DisputeRegistrationCourt":
                // Load related data for DisputeRegistrationCourt
                $model->load([
                    'complaintRegistration',
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
                $defenders =  $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');

                $complainerDetailsArray = $this->generatePartyDetails($complainers);
                $defenderDetailsArray = $this->generatePartyDetails($defenders);
                // 'प्रथम पक्ष',
                // 'दोश्रो पक्ष'
                $complainerTextBr = '';
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerTextBr .= "{$c['name']}<br>{$c['district']} जिल्ला, {$c['local_body']} वडा नं {$c['ward']},{$c['tole']}<br>";
                }

                $defenderTextBr = '';
                foreach ($defenderDetailsArray as $i => $d) {
                    $defenderTextBr .= "{$d['name']}<br>{$d['district']} जिल्ला, {$d['local_body']} गाउँपालिका वडा नं {$d['ward']},{$c['tole']}<br>";
                }
                //text without br
                $complainerTextPlain = '';
                $lastKey = array_key_last($complainerDetailsArray);
                foreach ($complainerDetailsArray as  $i => $c) {
                    $complainerTextPlain .= "{$c['name']} {$c['district']} जिल्ला, {$c['local_body']} वडा नं {$c['ward']}, {$c['tole']} बस्ने तपाई";
                    $complainerTextPlain .= ($i === $lastKey) ? 'ले' : ', ';
                }

                $defenderTextPlain = '';
                foreach ($defenderDetailsArray as $d) {
                    $defenderTextPlain .= "{$d['district']} जिल्ला, {$d['local_body']} वडा नं {$d['ward']}, {$d['tole']} बस्ने {$d['name']} ";
                }

                $data = array_merge($data, [
                    '{{complainer_detail}}' => $complainerTextBr,
                    '{{defender_detail}}' => $defenderTextBr,
                    '{{complainer_detail_plain}}' => $complainerTextPlain,
                    '{{defender_detail_plain}}' => $defenderTextPlain,
                    '{{dispute_area}}' => $model->complaintRegistration?->disputeMatter?->disputeArea->title,
                    '{{dispute_matter}}' => $model->complaintRegistration?->disputeMatter->title,
                    '{{complaint_registration_no}}' => $model->complaintRegistration->reg_no,
                    '{{complaint_registration_subject}}' => $model->complaintRegistration->subject,
                    '{{judicial_employee_name}}' => $model->judicialEmployee->name,
                    '{{judicial_employee_designation}}' => $model->judicialEmployee->designation->title,
                    '{{decision_date}}' => $model->decision_date,
                ]);
                break;

            case "DisputeDeadline":
                $model->load([
                    'complaintRegistration',
                    'complaintRegistration.disputeMatter.disputeArea',
                    'complaintRegistration.priority',
                    'complaintRegistration.fiscalYear',
                    'complaintRegistration.parties.permanentDistrict',
                    'complaintRegistration.parties.permanentLocalBody',
                    'complaintRegistration.parties.temporaryDistrict',
                    'complaintRegistration.parties.temporaryLocalBody',
                    'complaintRegistration.disputeMatter'
                ]);

                $complainers = $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
                $defenders =  $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');

                $complainerDetailsArray = $this->generatePartyDetails($complainers);
                $defenderDetailsArray = $this->generatePartyDetails($defenders);

                //text without br
                $complainerTextPlain = '';
                $lastKey = array_key_last($complainerDetailsArray);
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerTextPlain .= "{$c['district']} जिल्ला, {$c['local_body']} वडा नं {$c['ward']}, {$c['tole']} बस्ने {$c['name']}";
                    $complainerTextPlain .= ($i === $lastKey) ? 'ले' : ', ';
                }

                $defenderTextPlain = '';
                foreach ($defenderDetailsArray as $d) {
                    $defenderTextPlain .= "{$d['district']} जिल्ला, {$d['local_body']} वडा नं {$d['ward']}, {$d['tole']} बस्ने {$d['name']} ";
                }


                $data = array_merge($data, [
                    '{{complainer_detail_plain}}' => $complainerTextPlain,
                    '{{defender_detail_plain}}' => $defenderTextPlain,
                    '{{dispute_area}}' => $model->complaintRegistration?->disputeMatter?->disputeArea->title,
                    '{{dispute_matter}}' => $model->complaintRegistration?->disputeMatter->title,
                    '{{complaint_registration_subject}}' => $model->complaintRegistration->subject,
                    '{{extension_period}}' => $model->deadline_extension_period,
                ]);
                break;
            case "HearingSchedule":
                $model->load([
                    'complaintRegistration',
                    'complaintRegistration.disputeMatter.disputeArea',
                    'complaintRegistration.priority',
                    'complaintRegistration.fiscalYear',
                    'complaintRegistration.parties.permanentDistrict',
                    'complaintRegistration.parties.permanentLocalBody',
                    'complaintRegistration.parties.temporaryDistrict',
                    'complaintRegistration.parties.temporaryLocalBody',
                    'complaintRegistration.disputeMatter'
                ]);

                $complainers = $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
                $defenders =  $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');

                $complainerDetailsArray = $this->generatePartyDetails($complainers);
                $defenderDetailsArray = $this->generatePartyDetails($defenders);

                $complainerTextPlain = '';

                foreach ($complainerDetailsArray as $c) {
                    $complainerTextPlain .= "श्री {$c['name']} {$c['district']} जिल्ला, {$c['local_body']} वडा नं {$c['ward']}, {$c['tole']} <br>";
                }

                $defenderTextPlain = '';
                foreach ($defenderDetailsArray as $d) {
                    $defenderTextPlain .= "श्री {$d['name']} {$d['district']} जिल्ला, {$d['local_body']} वडा नं {$d['ward']}, {$d['tole']}<br>";
                }

                $complainerHearingTable = '';
                $lastKey = array_key_last($complainerDetailsArray);
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerHearingTable .= " {$c['district']} जिल्ला, {$c['local_body']} वडा नं {$c['ward']}, {$c['tole']} बस्ने मुद्धा नं {$model->complaintRegistration?->reg_no}मा प्रथम पक्ष श्री {$c['name']}";
                    $complainerHearingTable .= ($i === $lastKey) ? 'ले' : ', ';
                }

                $defenderHearingTable = '';
                foreach ($defenderDetailsArray as $d) {
                    $defenderHearingTable .= "{$d['district']} जिल्ला, {$d['local_body']} वडा नं {$d['ward']}, {$d['tole']} बस्ने श्री {$d['name']}";
                }

                $data = array_merge($data, [
                    '{{complainer_detail_plain}}' => $complainerTextPlain,
                    '{{defender_detail_plain}}' => $defenderTextPlain,
                    '{{complainer_detail_hearing_table}}' => $complainerHearingTable,
                    '{{defender_detail_hearing_table}}' => $defenderHearingTable,
                    '{{dispute_area}}' => $model->complaintRegistration?->disputeMatter?->disputeArea->title,
                    '{{dispute_matter}}' => $model->complaintRegistration?->disputeMatter->title,
                    '{{complaint_registration_subject}}' => $model->complaintRegistration->subject,
                    '{{hearing_time}}' => replaceNumbers($model->hearing_time, true),
                    '{{hearing_date}}' => replaceNumbers($this->AdTobs($model->hearing_date), true),
                ]);
                break;

            case "CourtNotice":
                $model->load([
                    'complaintRegistration',
                    'complaintRegistration.disputeMatter.disputeArea',
                    'complaintRegistration.priority',
                    'complaintRegistration.fiscalYear',
                    'complaintRegistration.parties.permanentDistrict',
                    'complaintRegistration.parties.permanentLocalBody',
                    'complaintRegistration.parties.temporaryDistrict',
                    'complaintRegistration.parties.temporaryLocalBody',
                    'complaintRegistration.disputeMatter'
                ]);

                $complainers = $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
                $defenders =  $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');

                $complainerDetailsArray = $this->generatePartyDetails($complainers);
                $defenderDetailsArray = $this->generatePartyDetails($defenders);

                //text without br
                $complainerTextBr = '';
                //all names according to format
                foreach ($complainerDetailsArray as $c) {
                    $complainerTextBr .= "{$c['name']}<br>";
                }
                //all addresses same like format
                foreach ($complainerDetailsArray as $c) {
                    $complainerTextBr .= "{$c['district']} जिल्ला, {$c['local_body']}-वडा नं {$c['ward']}, {$c['tole']} वस्ने <br>";
                }

                $defenderTextBr = '';
                //all names according to format
                foreach ($defenderDetailsArray as $d) {
                    $defenderTextBr .= "{$d['name']}<br>";
                }

                //all addresses same like format
                foreach ($defenderDetailsArray as $d) {
                    $defenderTextBr .= "{$d['district']} जिल्ला, {$d['local_body']}-वडा नं {$d['ward']}, {$d['tole']} वस्ने <br>";
                }

                $data = array_merge($data, [
                    '{{complainer_detail_br}}' => $complainerTextBr,
                    '{{defender_detail_br}}' => $defenderTextBr,
                    '{{dispute_area}}' => $model->complaintRegistration?->disputeMatter?->disputeArea->title,
                    '{{dispute_matter}}' => $model->complaintRegistration?->disputeMatter->title,
                    '{{complaint_registration_subject}}' => $model->complaintRegistration->subject,
                    '{{notice_time}}' => replaceNumbers($model->notice_time, true),
                    '{{notice_date}}' => $this->convertToNepaliDateFormat($model->notice_date),
                ]);
                break;

            case "JudicialMeeting":
                $model->load(['employees.designation']);
                $invitedMember = $model->members;
                $presentEmployee = $model->employees;
                $firstPresent = $invitedMember->first();

                $presentText = "";
                foreach ($presentEmployee as $member) {
                    $presentText .= "श्री {$member->name} - {$member->designation->title}<br/>";
                }
                $invitedText = "";
                foreach ($invitedMember as $member) {
                    $invitedText .= "श्री {$member->title} - {$member->elected_position->label()}<br/>";
                }

                $data = array_merge($data, [
                    '{{employee_name}}' => $firstPresent ? $firstPresent->title : '',
                    '{{meeting_date}}' => $model->meeting_date,
                    '{{meeting_time}}' => $model->meeting_time,
                    '{{meeting_topic}}' => $model->meeting_topic,
                    '{{discussion_details}}' => $model->decision_details,
                    '{{present_member}}' => $presentText,
                    '{{invited_member}}' => $invitedText,
                ]);
                break;
            case "WrittenResponseRegistration":
                $model->load([
                    'complaintRegistration',
                    'complaintRegistration.disputeMatter.disputeArea',
                    'complaintRegistration.priority',
                    'complaintRegistration.fiscalYear',
                    'complaintRegistration.parties.permanentDistrict',
                    'complaintRegistration.parties.permanentLocalBody',
                    'complaintRegistration.parties.temporaryDistrict',
                    'complaintRegistration.parties.temporaryLocalBody',
                    'complaintRegistration.disputeMatter'
                ]);
                $complainers = $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
                $defenders =  $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');

                $complainerDetailsArray = $this->generatePartyDetails($complainers);
                $defenderDetailsArray = $this->generatePartyDetails($defenders);

                //text without br
                $complainerTextPlain = '';
                $lastKey = array_key_last($complainerDetailsArray);
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerTextPlain .= "{$c['district']} जिल्ला, {$c['local_body']} वडा नं {$c['ward']}, {$c['tole']} बस्ने {$c['grandfather_name']}को नाती/नातिनी, {$c['father_name']}को छोरा/छोरी {$c['spouse_name']}को श्रीमान/श्रीमती लिखित जवाफ प्रस्तुतकर्ता {$c['name']}";
                }

                $defenderTextPlain = '';
                $defenderName = '';
                $defenderPhone = '';
                foreach ($defenderDetailsArray as $d) {
                    $defenderTextPlain .= "{$d['district']} जिल्ला, {$d['local_body']} वडा नं {$d['ward']}, {$d['tole']} बस्ने {$d['grandfather_name']}को नाती/नातिनी, {$d['father_name']}को छोरा/छोरी {$d['spouse_name']}को श्रीमान/श्रीमती लिखित जवाफ प्रस्तुतकर्ता {$d['name']}";
                    $defenderName .= "{$d['name']}";
                    $defenderPhone .= "{$d['name']}";
                }

                $data = array_merge($data, [
                    '{{complainer_detail_plain}}' => $complainerTextPlain,
                    '{{defender_detail_plain}}' => $defenderTextPlain,
                    '{{defender_name}}' => $defenderName,
                    '{{defender_phone}}' => $defenderPhone,
                    '{{dispute_area}}' => $model->complaintRegistration?->disputeMatter?->disputeArea->title,
                    '{{dispute_matter}}' => $model->complaintRegistration?->disputeMatter->title,
                    '{{complaint_registration_subject}}' => $model->complaintRegistration->subject,
                    '{{written_response_description}}' => $model->description,
                    '{{written_response_date}}' => $this->convertToNepaliDateFormat(replaceNumbers($model->registration_date, true)),
                ]);
                break;
            case "MediatorSelection":
                $model->load([
                    'complaintRegistration',
                    'complaintRegistration.disputeMatter',
                    'complaintRegistration.priority',
                    'complaintRegistration.fiscalYear',
                    'complaintRegistration.parties.permanentDistrict',
                    'complaintRegistration.parties.permanentLocalBody',
                    'complaintRegistration.parties.temporaryDistrict',
                    'complaintRegistration.parties.temporaryLocalBody',
                    'complaintRegistration.disputeMatter.disputeArea',
                ]);
                $complainers = $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
                $defenders =  $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');

                $complainerDetailsArray = $this->generatePartyDetails($complainers);
                $defenderDetailsArray = $this->generatePartyDetails($defenders);
                $complainerTextPlain = '';
                $complainerName = "";
                $defenderName = "";
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerTextPlain .= "{$c['name']} {$c['district']} जिल्ला, {$c['local_body']} वडा नं {$c['ward']}, {$c['tole']},";
                    $complainerName .= "{$c['name']} {$c['local_body']} ";
                }

                $defenderTextPlain = '';
                foreach ($defenderDetailsArray as $d) {
                    $defenderTextPlain .= "{$d['name']} {$d['district']} जिल्ला, {$d['local_body']} वडा नं {$d['ward']}, {$d['tole']}";
                    $defenderName .= "{$d['name']} {$d['local_body']} ";
                }

                $data = array_merge($data, [
                    '{{complainer_detail_plain}}' => $complainerTextPlain,
                    '{{defender_detail_plain}}' => $defenderTextPlain,
                    '{{dispute_area}}' => $model->complaintRegistration?->disputeMatter?->disputeArea->title,
                    '{{dispute_matter}}' => $model->complaintRegistration?->disputeMatter->title,
                    '{{complaint_registration_subject}}' => $model->complaintRegistration->subject,
                    '{{written_response_description}}' => $model->description,
                    '{{mediator_name}}' => $model->mediator->mediator_name,
                    '{{mediator_address}}' => $model->mediator->mediator_address,
                    '{{complainer_name}}' => $complainerName,
                    '{{defender_name}}' => $defenderName,
                    '{{mediator_selection_date}}' => $this->convertToNepaliDateFormat(replaceNumbers($model->selection_date, true)),
                ]);
                break;
            case "WitnessesRepresentative":
                $model->load([
                    'complaintRegistration',
                    'complaintRegistration.disputeMatter.disputeArea',
                    'complaintRegistration.priority',
                    'complaintRegistration.fiscalYear',
                    'complaintRegistration.parties.permanentDistrict',
                    'complaintRegistration.parties.permanentLocalBody',
                    'complaintRegistration.parties.temporaryDistrict',
                    'complaintRegistration.parties.temporaryLocalBody',
                    'complaintRegistration.disputeMatter'
                ]);
                $complainers = $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
                $defenders =  $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');

                $complainerDetailsArray = $this->generatePartyDetails($complainers);
                $defenderDetailsArray = $this->generatePartyDetails($defenders);

                //text without br
                $complainerName = '';
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerName .= "{$c['name']},";
                }

                $defenderName = '';
                foreach ($defenderDetailsArray as $d) {
                    $defenderName .= "{$d['name']},";
                }
                $data = array_merge($data, [
                    '{{witness_name}}' => $model->name,
                    '{{witness_address}}' => $model->address,
                    '{{complainer_name}}' => $complainerName,
                    '{{defender_name}}' => $defenderName,
                    '{{complaint_registration_no}}' => $model->complaintRegistration->reg_no,
                ]);
                break;
            case "Settlement":
                $model->load([
                    'complaintRegistration',
                    'complaintRegistration.disputeMatter.disputeArea',
                    'complaintRegistration.priority',
                    'complaintRegistration.fiscalYear',
                    'complaintRegistration.parties.permanentDistrict',
                    'complaintRegistration.parties.permanentLocalBody',
                    'complaintRegistration.parties.temporaryDistrict',
                    'complaintRegistration.parties.temporaryLocalBody',
                    'complaintRegistration.disputeMatter'
                ]);
                $complainers = $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
                $defenders =  $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');

                $complainerDetailsArray = $this->generatePartyDetails($complainers);
                $defenderDetailsArray = $this->generatePartyDetails($defenders);

                //text without br
                $complainerTextPlain = '';
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerTextPlain .= "प्रथम पक्ष {$c['district']} जिल्ला, {$c['local_body']} वडा नं {$c['ward']}, {$c['tole']} बस्ने {$c['grandfather_name']}को नाती/नातिनी, {$c['father_name']}को छोरा/छोरी {$c['spouse_name']}को श्रीमान/श्रीमती, {$c['name']} <br>";
                }
                $data = array_merge($data, [
                    '{{complainer_detail_plain}}' => $complainerTextPlain,
                    '{{complaint_registration_no}}' => $model->complaintRegistration->reg_no,
                    '{{dispute_area}}' => $model->complaintRegistration?->disputeMatter?->disputeArea->title,
                    '{{dispute_matter}}' => $model->complaintRegistration?->disputeMatter->title,
                    '{{complaint_registration_subject}}' => $model->complaintRegistration->subject,
                    '{{complaint_registration_claim_request}}' => $model->complaintRegistration->claim_request,
                    '{{settlement_detail}}' => $model->settlement_details,
                    '{{discussion_date}}' => $this->convertToNepaliDateFormat(replaceNumbers($model->discussion_date, true)),
                ]);
                break;
            case "CaseRecord":
                $model->load([
                    'complaintRegistration',
                    'complaintRegistration.disputeMatter.disputeArea',
                    'complaintRegistration.priority',
                    'complaintRegistration.fiscalYear',
                    'complaintRegistration.parties.permanentDistrict',
                    'complaintRegistration.parties.permanentLocalBody',
                    'complaintRegistration.parties.temporaryDistrict',
                    'complaintRegistration.parties.temporaryLocalBody',
                    'complaintRegistration.disputeMatter',
                    'judicialEmployee',
                    'judicialMember',
                    'judicialEmployee.designation',
                ]);
                $complainers = $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Complainer');
                $defenders =  $model->complaintRegistration->parties->filter(fn($party) => $party->pivot->type === 'Defender');

                $complainerDetailsArray = $this->generatePartyDetails($complainers);
                $defenderDetailsArray = $this->generatePartyDetails($defenders);
                $complainerName = '';
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerName .= "{$c['name']},";
                }

                $defenderName = '';
                foreach ($defenderDetailsArray as $d) {
                    $defenderName .= "{$d['name']},";
                }
                $data = array_merge($data, [
                    '{{complainer_name}}' => $complainerName,
                    '{{defender_name}}' => $defenderName,
                    '{{complaint_registration_no}}' => $model->complaintRegistration->reg_no,

                    '{{complaint_registration_date}}' => replaceNumbers($this->adToBs($model->complaintRegistration->reg_date), true),
                    '{{dispute_area}}' => $model->complaintRegistration?->disputeMatter?->disputeArea->title,
                    '{{dispute_matter}}' => $model->complaintRegistration?->disputeMatter->title,
                    '{{complaint_registration_subject}}' => $model->complaintRegistration->subject,
                    '{{complaint_registration_claim_request}}' => $model->complaintRegistration->claim_request,
                    '{{discussion_date}}' => $model->discussion_date,
                    '{{recording_officer_name}}' => $model->judicialEmployee->name,
                    '{{decision_authority}}' => $model->judicialMember->title,
                    '{{recording_officer_position}}' => $model->judicialEmployee->designation->title,
                    '{{decision_date}}' => replaceNumbers($this->adToBs($model->decision_date), true),
                ]);
                break;
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
            'styles' => $template->styles ?? '',
        ];
    }

    function generatePartyDetails($parties)
    {
        if ($parties->isEmpty()) {
            return [];
        }

        $result = [];

        foreach ($parties as $party) {
            $detail = [
                'district' => $party->permanentDistrict->title ?? '',
                'local_body' => $party->permanentLocalBody->title ?? '',
                'ward' => $party->permanent_ward_id ?? '',
                'tole' => $party->permanent_tole ?? '',
                'grandfather_name' => $party->grandfather_name ?? '',
                'father_name' => $party->father_name ?? '',
                'age' => $party->age ?? '',
                'name' => $party->name ?? '',
                'phone_no' => $party->phone_no ?? '',
                'spouse_name' => $party->spouse_name ?? '',
            ];

            $result[] = $detail;
        }

        return $result;
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

        return "{$year} साल {$monthName} महिना {$day} गते";
    }


    function extractPartyFields(array $partyDetailsArray): array
{
    $fields = [
        'district' => [],
        'local_body' => [],
        'ward' => [],
        'tole' => [],
        'grandfather_name' => [],
        'father_name' => [],
        'spouse_name' => [],
        'age' => [],
        'name' => [],
        'phone' => [],
    ];

    foreach ($partyDetailsArray as $party) {
        foreach ($fields as $key => &$arr) {
            $arr[] = $party[$key] ?? '';
        }
    }

    // Implode each array into comma-separated string
    return array_map(fn($arr) => implode(', ', $arr), $fields);
}

function convertToNepaliDateParts($bsDate)
{
    // Handle null or empty input
    if (empty($bsDate) || is_null($bsDate)) {
        return [
            'year' => '',
            'month' => '',
            'day' => '',
        ];
    }

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

    // Split the date and handle cases where explode might fail
    $dateParts = explode('-', $bsDate);
    
    // Check if we have at least 3 parts (year, month, day)
    if (count($dateParts) < 3) {
        return [
            'year' => $dateParts[0] ?? '',
            'month' => '',
            'day' => $dateParts[1] ?? '',
        ];
    }

    $year = $dateParts[0] ?? '';
    $month = $dateParts[1] ?? '';
    $day = $dateParts[2] ?? '';
    
    $monthName = $monthNames[$month] ?? '';

    return [
        'year' => $year,
        'month' => $monthName,
        'day' => $day,
    ];
}

}
