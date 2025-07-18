<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Agendas\Models\Agenda;
use Src\Decisions\Models\Decision;
use Src\InvitedMembers\Models\InvitedMember;
use Src\Meetings\Models\Meeting;
use Src\Minutes\Models\Minute;
use Src\Yojana\Models\Committee;
use Src\Yojana\Models\CommitteeMember;
use Src\Yojana\Models\CommitteeType;

class CreateFakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*Customer::factory()
            ->count(1000)
            ->has(CustomerKyc::factory()->count(1),'kyc')
            ->create();*/

        /* Page::factory()
             ->count(10)
             ->create();*/

        /*   Download::factory()
               ->count(50)
               ->create();*/

        /*     EmergencyContact::factory()
                 ->count(100)
                 ->create();*/

        /*FiscalYear::factory()
            ->count(5)
            ->create();*/

        /* Form::factory()
             ->count(500)
             ->create();*/

        /*  Branch::factory()
              ->count(100)
              ->create();*/

        /* Designation::factory()
             ->count(100)
             ->create();*/

        /*  Employee::factory()
              ->count(200)
              ->create();*/

        /*    GrievanceType::factory()
                ->count(50)
                ->has(
                    GrievanceDetail::factory()
                        ->has(GrievanceFile::factory()->count(rand(1, 5)), 'files')
                        ->count(rand(50, 300))
                )
                ->create();*/

        CommitteeType::factory()
            ->count(10)
            ->has(
                Committee::factory()
                    ->has(
                        CommitteeMember::factory()
                            ->count(rand(1, 5)),
                        'committeeMembers'
                    )
                    ->has(
                        Meeting::factory()
                            ->has(Agenda::factory()->count(rand(1, 10)), 'agendas')
                            ->has(InvitedMember::factory()->count(rand(1, 10)), 'invitedMembers')
                            ->has(Minute::factory(), 'minute')
                            ->has(Decision::factory()->count(rand(1, 10)), 'decisions')
                            ->count(rand(1, 50)),
                        'meetings'
                    )
                    ->count(rand(50, 300)),
                'committees'
            )
            ->create();


    }
}
