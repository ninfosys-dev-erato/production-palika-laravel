<?php

namespace Src\Meetings\Service;

use Illuminate\Support\Facades\Auth;
use Src\Meetings\DTO\ParticipantAdminDto;
use Src\Meetings\Models\Participant;

class ParticipantAdminService
{
public function store(ParticipantAdminDto $participantAdminDto){
    return Participant::create([
        'meeting_id' => $participantAdminDto->meeting_id,
        'committee_member_id' => $participantAdminDto->committee_member_id,
        'name' => $participantAdminDto->name,
        'designation' => $participantAdminDto->designation,
        'phone' => $participantAdminDto->phone,
        'email' => $participantAdminDto->email,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Participant $participant, ParticipantAdminDto $participantAdminDto){
    return tap($participant)->update([
        'meeting_id' => $participantAdminDto->meeting_id,
        'committee_member_id' => $participantAdminDto->committee_member_id,
        'name' => $participantAdminDto->name,
        'designation' => $participantAdminDto->designation,
        'phone' => $participantAdminDto->phone,
        'email' => $participantAdminDto->email,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Participant $participant){
    return tap($participant)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Participant::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}