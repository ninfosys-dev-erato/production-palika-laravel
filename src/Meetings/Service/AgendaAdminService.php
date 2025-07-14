<?php

namespace Src\Meetings\Service;

use Illuminate\Support\Facades\Auth;
use Src\Meetings\DTO\AgendaAdminDto;
use Src\Meetings\Models\Agenda;

class AgendaAdminService
{
public function store(AgendaAdminDto $agendaAdminDto){
    return Agenda::create([
        'meeting_id' => $agendaAdminDto->meeting_id,
        'proposal' => $agendaAdminDto->proposal,
        'description' => $agendaAdminDto->description,
        'is_final' => $agendaAdminDto->is_final,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Agenda $agenda, AgendaAdminDto $agendaAdminDto){
    return tap($agenda)->update([
        'meeting_id' => $agendaAdminDto->meeting_id,
        'proposal' => $agendaAdminDto->proposal,
        'description' => $agendaAdminDto->description,
        'is_final' => $agendaAdminDto->is_final,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Agenda $agenda){
    return tap($agenda)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Agenda::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}
