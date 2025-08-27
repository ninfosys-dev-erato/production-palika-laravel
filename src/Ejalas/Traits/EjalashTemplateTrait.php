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

        $modelName = class_basename($this->model);

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
            '{{global.today_date_bs}}' => $this->adToBs(today()->toDateString(), 'yyyy-mm-dd'),
        ];

        switch ($modelName) {

            case "ComplaintRegistration":
                // Load related data for ComplaintRegistration
                $model->load([
                    'disputeMatter',
                    'priority',
                    'fiscalYear',
                    'parties.permanentDistrict',
                    'parties.permanentLocalBody',
                    'parties.temporaryDistrict',
                    'parties.temporaryLocalBody',
                    'disputeMatter.disputeArea'
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

                $complainerName = '';
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerName .= "{$c['name']},";
                }
                $complainerNumber = '';
                foreach ($complainerDetailsArray as $i => $c) {
                    $complainerNumber .= "{$c['phone_no']},";
                }

                $data = array_merge($data, [
                    '{{complainer_detail_plain}}' => $complainerTextPlain,
                    '{{defender_detail_plain}}' => $defenderTextPlain,
                    '{{dispute_area}}' => $model->disputeMatter?->disputeArea->title,
                    '{{dispute_matter}}' => $model->disputeMatter->title,
                    '{{complaint_registration_subject}}' => $model->subject,
                    '{{complaint_description}}' => $model->description,
                    '{{complainer_name}}' => $complainerName,
                    '{{complainer_number}}' => $complainerNumber,
                    '{{reg_date}}' => $this->convertToNepaliDateFormat(replaceNumbers($this->AdTobs($model->reg_date), true)),
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
}
