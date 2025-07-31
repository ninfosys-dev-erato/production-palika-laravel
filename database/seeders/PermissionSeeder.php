<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Src\Permissions\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // -------------------
            // ACTIVITY LOGS MODULE
            // -------------------
            ['name' => 'activity_logs access', 'guard' => 'web'],
            ['name' => 'activity_logs create', 'guard' => 'web'],
            ['name' => 'activity_logs delete', 'guard' => 'web'],
            ['name' => 'activity_logs edit', 'guard' => 'web'],

            // -------------------
            // ADDRESS MODULE
            // -------------------
            // (No explicit permissions found)

            // -------------------
            // ADMIN SETTINGS MODULE
            // -------------------
            ['name' => 'group_access', 'guard' => 'web'],
            ['name' => 'group_create', 'guard' => 'web'],
            ['name' => 'group_delete', 'guard' => 'web'],
            ['name' => 'group_update', 'guard' => 'web'],
            ['name' => 'letter_head_manage', 'guard' => 'web'],
            ['name' => 'letter_head_update', 'guard' => 'web'],
            ['name' => 'letter_head_delete', 'guard' => 'web'],
            ['name' => 'setting_groups create', 'guard' => 'web'],
            ['name' => 'setting_groups edit', 'guard' => 'web'],
            ['name' => 'setting_groups delete', 'guard' => 'web'],
            ['name' => 'setting access', 'guard' => 'web'],
            ['name' => 'setting_create', 'guard' => 'web'],
            ['name' => 'setting_delete', 'guard' => 'web'],
            ['name' => 'setting_update', 'guard' => 'web'],

            // -------------------
            // AUTOMATION MODULE
            // -------------------
            // (No explicit permissions found)

            // -------------------
            // BUSINESS REGISTRATION MODULE
            // -------------------
            ['name' => 'business_registration access', 'guard' => 'web'],
            ['name' => 'business_registration create', 'guard' => 'web'],
            ['name' => 'business_registration delete', 'guard' => 'web'],
            ['name' => 'business_registration edit', 'guard' => 'web'],
            ['name' => 'business_renewals access', 'guard' => 'web'],
            ['name' => 'business_renewals create', 'guard' => 'web'],
            ['name' => 'business_renewals delete', 'guard' => 'web'],
            ['name' => 'business_renewals edit', 'guard' => 'web'],
            ['name' => 'business_settings access', 'guard' => 'web'],
            ['name' => 'business_settings create', 'guard' => 'web'],
            ['name' => 'business_settings delete', 'guard' => 'web'],
            ['name' => 'business_settings edit', 'guard' => 'web'],

            // -------------------
            // COMMITTEES MODULE
            // -------------------
            ['name' => 'committee_access', 'guard' => 'web'],
            ['name' => 'committee_create', 'guard' => 'web'],
            ['name' => 'committee_delete', 'guard' => 'web'],
            ['name' => 'committee_update', 'guard' => 'web'],
            ['name' => 'committee_member_access', 'guard' => 'web'],
            ['name' => 'committee_member_create', 'guard' => 'web'],
            ['name' => 'committee_member_delete', 'guard' => 'web'],
            ['name' => 'committee_member_update', 'guard' => 'web'],
            ['name' => 'committee_type_access', 'guard' => 'web'],
            ['name' => 'committee_type_create', 'guard' => 'web'],
            ['name' => 'committee_type_delete', 'guard' => 'web'],
            ['name' => 'committee_type_update', 'guard' => 'web'],

            // -------------------
            // CUSTOMERS MODULE
            // -------------------
            ['name' => 'customer access', 'guard' => 'web'],

            // -------------------
            // DIGITAL BOARD MODULE
            // -------------------
            ['name' => 'digital_board access', 'guard' => 'web'],
            ['name' => 'digital_board create', 'guard' => 'web'],
            ['name' => 'digital_board delete', 'guard' => 'web'],
            ['name' => 'digital_board edit', 'guard' => 'web'],
           

            // -------------------
            // DISTRICTS MODULE
            // -------------------
            ['name' => 'districts create', 'guard' => 'web'],
            ['name' => 'districts delete', 'guard' => 'web'],
            ['name' => 'districts edit', 'guard' => 'web'],

            // -------------------
            // DOWNLOADS MODULE
            // -------------------
            ['name' => 'downloads access', 'guard' => 'web'],
            ['name' => 'downloads create', 'guard' => 'web'],
            ['name' => 'downloads delete', 'guard' => 'web'],
            ['name' => 'downloads edit', 'guard' => 'web'],

            // -------------------
            // EBPS MODULE
            // -------------------
            ['name' => 'ebps_settings create', 'guard' => 'web'],
            ['name' => 'ebps_settings delete', 'guard' => 'web'],
            ['name' => 'ebps_settings edit', 'guard' => 'web'],
            ['name' => 'map_applies access', 'guard' => 'web'],
            ['name' => 'map_applies delete', 'guard' => 'web'],
            ['name' => 'map_applies edit', 'guard' => 'web'],
            ['name' => 'ebps_organizations access', 'guard' => 'web'],
            ['name' => 'ebps_organizations edit', 'guard' => 'web'],
            ['name' => 'ebps_organizations create', 'guard' => 'web'],
            ['name' => 'ebps_organizations delete', 'guard' => 'web'],

            // -------------------
            // EMERGENCY CONTACTS MODULE
            // -------------------
            ['name' => 'emergency_contact access', 'guard' => 'web'],
            ['name' => 'emergency_contact create', 'guard' => 'web'],
            ['name' => 'emergency_contact delete', 'guard' => 'web'],
            ['name' => 'emergency_contact update', 'guard' => 'web'],

            // -------------------
            // BRANCH MODULE
            // -------------------
            ['name' => 'branch access', 'guard' => 'web'],
            ['name' => 'branch create', 'guard' => 'web'],
            ['name' => 'branch delete', 'guard' => 'web'],
            ['name' => 'branch update', 'guard' => 'web'],

            // -------------------
            // EMPLOYEES MODULE
            // -------------------
            ['name' => 'employee access', 'guard' => 'web'],
            ['name' => 'employee create', 'guard' => 'web'],
            ['name' => 'employee delete', 'guard' => 'web'],
            ['name' => 'employee update', 'guard' => 'web'],
            ['name' => 'designation access', 'guard' => 'web'],
            ['name' => 'designation create', 'guard' => 'web'],
            ['name' => 'designation edit', 'guard' => 'web'],

            // -------------------
            // FISCAL YEARS MODULE
            // -------------------
            ['name' => 'fiscal_year access', 'guard' => 'web'],
            ['name' => 'fiscal_year create', 'guard' => 'web'],
            ['name' => 'fiscal_year delete', 'guard' => 'web'],
            ['name' => 'fiscal_year edit', 'guard' => 'web'],

            // -------------------
            // FORM MODULE
            // -------------------
            ['name' => 'form access', 'guard' => 'web'],
            ['name' => 'form create', 'guard' => 'web'],
            ['name' => 'form delete', 'guard' => 'web'],
            ['name' => 'form edit', 'guard' => 'web'],

            // -------------------
            // GRANT MANAGEMENT MODULE
            // -------------------
            ['name' => 'gms_settings access', 'guard' => 'web'],
            ['name' => 'gms_settings create', 'guard' => 'web'],
            ['name' => 'gms_settings edit', 'guard' => 'web'],
            ['name' => 'gms_settings delete', 'guard' => 'web'],

            ['name' => 'gms_report access', 'guard' => 'web'],

            ['name' => 'gms_activity access', 'guard' => 'web'],
            ['name' => 'gms_activity create', 'guard' => 'web'],
            ['name' => 'gms_activity edit', 'guard' => 'web'],
            ['name' => 'gms_activity delete', 'guard' => 'web'],
            ['name' => 'gms_activity view', 'guard' => 'web'],


            // -------------------
            // GRIEVANCE MODULE
            // -------------------
            ['name' => 'grievance access', 'guard' => 'web'],
            ['name' => 'grievance create', 'guard' => 'web'],
            ['name' => 'grievance_setting access', 'guard' => 'web'],
            ['name' => 'grievance_setting create', 'guard' => 'web'],
            ['name' => 'grievance_setting delete', 'guard' => 'web'],
            ['name' => 'grievance_setting edit', 'guard' => 'web'],

            // -------------------
            // LOCAL BODIES MODULE
            // -------------------
            ['name' => 'local_bodies delete', 'guard' => 'web'],
            ['name' => 'local_bodies edit', 'guard' => 'web'],
            ['name' => 'local_levels create', 'guard' => 'web'],
            ['name' => 'local_levels view', 'guard' => 'web'],

            // -------------------
            // MEETINGS MODULE
            // -------------------
            ['name' => 'meeting_access', 'guard' => 'web'],
            ['name' => 'meeting_agenda_access', 'guard' => 'web'],
            ['name' => 'meeting_agenda_create', 'guard' => 'web'],
            ['name' => 'meeting_agenda_delete', 'guard' => 'web'],
            ['name' => 'meeting_agenda_update', 'guard' => 'web'],
            ['name' => 'meeting_create', 'guard' => 'web'],
            ['name' => 'meeting_delete', 'guard' => 'web'],
            ['name' => 'meeting_decision_access', 'guard' => 'web'],
            ['name' => 'meeting_decision_create', 'guard' => 'web'],
            ['name' => 'meeting_decision_delete', 'guard' => 'web'],
            ['name' => 'meeting_decision_update', 'guard' => 'web'],
            ['name' => 'meeting_invited_member_access', 'guard' => 'web'],
            ['name' => 'meeting_invited_member_create', 'guard' => 'web'],
            ['name' => 'meeting_invited_member_delete', 'guard' => 'web'],
            ['name' => 'meeting_invited_member_update', 'guard' => 'web'],
            ['name' => 'meeting_minute_access', 'guard' => 'web'],
            ['name' => 'meeting_minute_update', 'guard' => 'web'],
            ['name' => 'meeting_participants_access', 'guard' => 'web'],
            ['name' => 'meeting_participants_create', 'guard' => 'web'],
            ['name' => 'meeting_participants_delete', 'guard' => 'web'],
            ['name' => 'meeting_participants_update', 'guard' => 'web'],
            ['name' => 'meeting_update', 'guard' => 'web'],

            // -------------------
            // PAGES MODULE
            // -------------------
            ['name' => 'page access', 'guard' => 'web'],
            ['name' => 'page create', 'guard' => 'web'],
            ['name' => 'page delete', 'guard' => 'web'],
            ['name' => 'page edit', 'guard' => 'web'],

            // -------------------
            // PERMISSIONS MODULE
            // -------------------
            ['name' => 'permissions access', 'guard' => 'web'],
            ['name' => 'permissions create', 'guard' => 'web'],
            ['name' => 'permissions delete', 'guard' => 'web'],
            ['name' => 'permissions edit', 'guard' => 'web'],

            // -------------------
            // PROFILE MODULE
            // -------------------
            // (No explicit permissions found)

            // -------------------
            // PROVINCES MODULE
            // -------------------
            // (No explicit permissions found)

            // -------------------
            // RECOMMENDATION MODULE
            // -------------------        

            ['name' => 'recommendation_apply access', 'guard' => 'web'],
            ['name' => 'recommendation_apply create', 'guard' => 'web'],
            ['name' => 'recommendation_apply delete', 'guard' => 'web'],
            ['name' => 'recommendation_apply update', 'guard' => 'web'],
            ['name' => 'recommendation_apply status', 'guard' => 'web'],
            ['name' => 'recommendation_settings access', 'guard' => 'web'],
            ['name' => 'recommendation_settings create', 'guard' => 'web'],
            ['name' => 'recommendation_settings delete', 'guard' => 'web'],
            ['name' => 'recommendation_settings update', 'guard' => 'web'],

            // -------------------
            // REGISTRATION MODULE (EJALAS)
            // -------------------
            ['name' => 'anusuchis create', 'guard' => 'web'],
            ['name' => 'case_records create', 'guard' => 'web'],
            ['name' => 'complaint_registrations create', 'guard' => 'web'],
            ['name' => 'dispute_areas create', 'guard' => 'web'],
            ['name' => 'dispute_matters create', 'guard' => 'web'],
            ['name' => 'dispute_matters delete', 'guard' => 'web'],
            ['name' => 'dispute_matters edit', 'guard' => 'web'],
            ['name' => 'dispute_registration_courts create', 'guard' => 'web'],
            ['name' => 'fulfilled_conditions create', 'guard' => 'web'],
            ['name' => 'fulfilled_conditions delete', 'guard' => 'web'],
            ['name' => 'fulfilled_conditions edit', 'guard' => 'web'],
            ['name' => 'hearing_schedules create', 'guard' => 'web'],
            ['name' => 'judicial_committees create', 'guard' => 'web'],
            ['name' => 'judicial_employees create', 'guard' => 'web'],
            ['name' => 'levels create', 'guard' => 'web'],
            ['name' => 'local_levels create', 'guard' => 'web'],
            ['name' => 'party create', 'guard' => 'web'],
            ['name' => 'parties create', 'guard' => 'web'],
            ['name' => 'priotities create', 'guard' => 'web'],
            ['name' => 'reconciliation_centers create', 'guard' => 'web'],
            ['name' => 'registration_indicators create', 'guard' => 'web'],
            ['name' => 'registration_indicators delete', 'guard' => 'web'],
            ['name' => 'registration_indicators edit', 'guard' => 'web'],
            ['name' => 'registration_type_access', 'guard' => 'web'],
            ['name' => 'registration_type_create', 'guard' => 'web'],
            ['name' => 'registration_type_delete', 'guard' => 'web'],
            ['name' => 'registration_type_update', 'guard' => 'web'],
            ['name' => 'settlement_detail create', 'guard' => 'web'],
            ['name' => 'settlements create', 'guard' => 'web'],
            ['name' => 'settlements delete', 'guard' => 'web'],
            ['name' => 'settlements edit', 'guard' => 'web'],
            ['name' => 'settlements print', 'guard' => 'web'],
            ['name' => 'witnesses_representatives create', 'guard' => 'web'],
            ['name' => 'written_response_registrations create', 'guard' => 'web'],

            // -------------------
            // ROLES MODULE
            // -------------------
            ['name' => 'roles access', 'guard' => 'web'],
            ['name' => 'roles create', 'guard' => 'web'],
            ['name' => 'roles delete', 'guard' => 'web'],
            ['name' => 'roles manage', 'guard' => 'web'],
            ['name' => 'roles edit', 'guard' => 'web'],

            // -------------------
            // SETTINGS MODULE
            // -------------------
            ['name' => 'app_setting_access', 'guard' => 'web'],
            ['name' => 'app_setting_update', 'guard' => 'web'],
            ['name' => 'setting_access', 'guard' => 'web'],
            ['name' => 'setting_create', 'guard' => 'web'],
            ['name' => 'setting_delete', 'guard' => 'web'],
            ['name' => 'setting_update', 'guard' => 'web'],

            // -------------------
            // SETTING MODULE
            // -------------------
            ['name' => 'general_setting access', 'guard' => 'web'],
            ['name' => 'office_setting access', 'guard' => 'web'],

            // -------------------
            // TASK TRACKING MODULE
            // -------------------
            ['name' => 'project_access', 'guard' => 'web'],
            ['name' => 'project_create', 'guard' => 'web'],
            ['name' => 'project_delete', 'guard' => 'web'],
            ['name' => 'project_update', 'guard' => 'web'],
            ['name' => 'task_access', 'guard' => 'web'],
            ['name' => 'task_create', 'guard' => 'web'],
            ['name' => 'task_delete', 'guard' => 'web'],
            ['name' => 'task_types access', 'guard' => 'web'],
            ['name' => 'task_types create', 'guard' => 'web'],
            ['name' => 'task_types delete', 'guard' => 'web'],
            ['name' => 'task_types update', 'guard' => 'web'],
            ['name' => 'task_update', 'guard' => 'web'],
            ['name' => 'task_view', 'guard' => 'web'],

            // -------------------
            // TOKEN TRACKING MODULE
            // -------------------
            ['name' => 'register_token_logs create', 'guard' => 'web'],
            ['name' => 'register_token_logs delete', 'guard' => 'web'],
            ['name' => 'register_token_logs edit', 'guard' => 'web'],
            ['name' => 'register_tokens access', 'guard' => 'web'],
            ['name' => 'register_tokens create', 'guard' => 'web'],
            ['name' => 'register_tokens delete', 'guard' => 'web'],
            ['name' => 'register_tokens edit', 'guard' => 'web'],
            ['name' => 'register_tokens exitTime', 'guard' => 'web'],
            ['name' => 'token_holders create', 'guard' => 'web'],
            ['name' => 'token_holders delete', 'guard' => 'web'],
            ['name' => 'token_holders edit', 'guard' => 'web'],
            ['name' => 'token_logs create', 'guard' => 'web'],
            ['name' => 'token_logs delete', 'guard' => 'web'],
            ['name' => 'token_logs edit', 'guard' => 'web'],

            // -------------------
            // USERS MODULE
            // -------------------
            ['name' => 'users access', 'guard' => 'web'],
            ['name' => 'users create', 'guard' => 'web'],
            ['name' => 'users delete', 'guard' => 'web'],
            ['name' => 'users edit', 'guard' => 'web'],
            ['name' => 'users manage', 'guard' => 'web'],

            // -------------------
            // WARDS MODULE
            // -------------------
            ['name' => 'wards access', 'guard' => 'web'],
            ['name' => 'wards create', 'guard' => 'web'],
            ['name' => 'wards delete', 'guard' => 'web'],
            ['name' => 'wards edit', 'guard' => 'web'],

            // -------------------
            // JMS Ejalas Module
            // -------------------
            ['name' => 'jms_settings create', 'guard' => 'web'],
            ['name' => 'jms_settings access', 'guard' => 'web'],
            ['name' => 'jms_settings edit', 'guard' => 'web'],
            ['name' => 'jms_settings delete', 'guard' => 'web'],

            ['name' => 'jms_judicial_management create', 'guard' => 'web'],
            ['name' => 'jms_judicial_management access', 'guard' => 'web'],
            ['name' => 'jms_judicial_management edit', 'guard' => 'web'],
            ['name' => 'jms_judicial_management delete', 'guard' => 'web'],
            ['name' => 'jms_judicial_management print', 'guard' => 'web'],

            ['name' => 'jms_reconciliation_center access', 'guard' => 'web'],
            ['name' => 'jms_reconciliation_center create', 'guard' => 'web'],
            ['name' => 'jms_report access', 'guard' => 'web'],
            // -------------------
            // TOK Token Management Module
            // -------------------
            ['name' => 'tok_token access', 'guard' => 'web'],
            ['name' => 'tok_token_feedback access', 'guard' => 'web'],
            ['name' => 'tok_token_report access', 'guard' => 'web'],
            ['name' => 'tok_token action', 'guard' => 'web'],
            ['name' => 'tok_token_feedback action', 'guard' => 'web'],

            // -------------------
            // TSK Task Tracking Module
            // -------------------
            ['name' => 'tsk_setting access', 'guard' => 'web'],
            ['name' => 'tsk_setting create', 'guard' => 'web'],
            ['name' => 'tsk_setting edit', 'guard' => 'web'],
            ['name' => 'tsk_setting delete', 'guard' => 'web'],
            ['name' => 'tsk_management access', 'guard' => 'web'],
            ['name' => 'tsk_management create', 'guard' => 'web'],
            ['name' => 'tsk_management edit', 'guard' => 'web'],
            ['name' => 'tsk_management delete', 'guard' => 'web'],
            ['name' => 'tsk_management print', 'guard' => 'web'],
            ['name' => 'tsk_management view', 'guard' => 'web'],

            // -------------------
            // YOJANA MODULE
            // -------------------
            // Plan Permissions
            ['name' => 'plan create', 'guard' => 'web'],
            ['name' => 'plan edit', 'guard' => 'web'],
            ['name' => 'plan delete', 'guard' => 'web'],
            ['name' => 'plan show', 'guard' => 'web'],
            ['name' => 'plan print', 'guard' => 'web'],
            ['name' => 'plan settings', 'guard' => 'web'],

            // Plan Basic Settings Permissions
            ['name' => 'plan_basic_settings create', 'guard' => 'web'],
            ['name' => 'plan_basic_settings edit', 'guard' => 'web'],
            ['name' => 'plan_basic_settings delete', 'guard' => 'web'],

            // Plan Committee Settings Permissions
            ['name' => 'plan_committee_settings create', 'guard' => 'web'],
            ['name' => 'plan_committee_settings edit', 'guard' => 'web'],
            ['name' => 'plan_committee_settings delete', 'guard' => 'web'],

            // Plan Log Books Permissions
            ['name' => 'plan_log_books create', 'guard' => 'web'],
            ['name' => 'plan_log_books edit', 'guard' => 'web'],
            ['name' => 'plan_log_books delete', 'guard' => 'web'],

            // -------------------
            // DARTA MODULE
            // -------------------
            ['name' => 'darta access', 'guard' => 'web'],
            ['name' => 'darta update', 'guard' => 'web'],
            ['name' => 'darta delete', 'guard' => 'web'],
            ['name' => 'darta create', 'guard' => 'web'],

            // -------------------
            // CHALANI MODULE
            // -------------------
            ['name' => 'chalani create', 'guard' => 'web'],
            ['name' => 'chalani access', 'guard' => 'web'],
            ['name' => 'chalani update', 'guard' => 'web'],
            ['name' => 'chalani delete', 'guard' => 'web'],

            // -------------------
            // GENERAL/OTHER MODULE
            // -------------------
            ['name' => 'human_resource access', 'guard' => 'web'],
            ['name' => 'office_setting access', 'guard' => 'web'],
            ['name' => 'letter_head access', 'guard' => 'web'],
            ['name' => 'letter_head create', 'guard' => 'web'],
           

        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']], // Find by name
                [
                    'guard_name' => $permission['guard'] ?? 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
