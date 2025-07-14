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
            // Customer Management
            ['name' => 'customer_access', 'guard' => 'web'],
            ['name' => 'customer_kyc_update', 'guard' => 'web'],

            // Page
            ['name' => 'page_access', 'guard' => 'web'],
            ['name' => 'page_create', 'guard' => 'web'],
            ['name' => 'page_update', 'guard' => 'web'],
            ['name' => 'page_delete', 'guard' => 'web'],

            // System Setting
            ['name' => 'system_setting_access', 'guard' => 'web'],

            // Fiscal Year
            ['name' => 'fiscal_year_access', 'guard' => 'web'],
            ['name' => 'fiscal_year_create', 'guard' => 'web'],
            ['name' => 'fiscal_year_update', 'guard' => 'web'],
            ['name' => 'fiscal_year_delete', 'guard' => 'web'],

            // Form
            ['name' => 'form_access', 'guard' => 'web'],
            ['name' => 'form_create', 'guard' => 'web'],
            ['name' => 'form_update', 'guard' => 'web'],
            ['name' => 'form_delete', 'guard' => 'web'],

            // Human Resource
            ['name' => 'human_resource_access', 'guard' => 'web'],

            // Employee
            ['name' => 'employee_access', 'guard' => 'web'],
            ['name' => 'employee_create', 'guard' => 'web'],
            ['name' => 'employee_update', 'guard' => 'web'],
            ['name' => 'employee_delete', 'guard' => 'web'],

            // Designation
            ['name' => 'designation_access', 'guard' => 'web'],
            ['name' => 'designation_create', 'guard' => 'web'],
            ['name' => 'designation_update', 'guard' => 'web'],
            ['name' => 'designation_delete', 'guard' => 'web'],

            // Department
            ['name' => 'branch_access', 'guard' => 'web'],
            ['name' => 'branch_create', 'guard' => 'web'],
            ['name' => 'branch_update', 'guard' => 'web'],
            ['name' => 'branch_delete', 'guard' => 'web'],

            // Office Setting
            ['name' => 'office_setting_access', 'guard' => 'web'],

            // Admin Setting - Setting
            ['name' => 'setting_access', 'guard' => 'web'],
            ['name' => 'setting_create', 'guard' => 'web'],
            ['name' => 'setting_update', 'guard' => 'web'],
            ['name' => 'setting_delete', 'guard' => 'web'],

            // App Setting
            ['name' => 'app_setting_access', 'guard' => 'web'],
            ['name' => 'app_setting_update', 'guard' => 'web'],

            // Grievance Management
            ['name' => 'grievance_access', 'guard' => 'web'],

            // Grievance Type
            ['name' => 'grievance_type_access', 'guard' => 'web'],
            ['name' => 'grievance_type_create', 'guard' => 'web'],
            ['name' => 'grievance_type_update', 'guard' => 'web'],
            ['name' => 'grievance_type_delete', 'guard' => 'web'],

            // Grievance Detail
            ['name' => 'grievance_detail_access', 'guard' => 'web'],
            ['name' => 'grievance_detail_update', 'guard' => 'web'],

            // Grievance Setting
            ['name' => 'grievance_setting_access', 'guard' => 'web'],
            ['name' => 'grievance_setting_update', 'guard' => 'web'],

            // Meeting Management
           

            // Committee Type
            ['name' => 'committee_type_access', 'guard' => 'web'],
            ['name' => 'committee_type_create', 'guard' => 'web'],
            ['name' => 'committee_type_update', 'guard' => 'web'],
            ['name' => 'committee_type_delete', 'guard' => 'web'],

            // Committee
            ['name' => 'committee_access', 'guard' => 'web'],
            ['name' => 'committee_create', 'guard' => 'web'],
            ['name' => 'committee_update', 'guard' => 'web'],
            ['name' => 'committee_delete', 'guard' => 'web'],

            // Committee Member
            ['name' => 'committee_member_access', 'guard' => 'web'],
            ['name' => 'committee_member_create', 'guard' => 'web'],
            ['name' => 'committee_member_update', 'guard' => 'web'],
            ['name' => 'committee_member_delete', 'guard' => 'web'],

            // Meeting
            ['name' => 'meeting_access', 'guard' => 'web'],
            ['name' => 'meeting_create', 'guard' => 'web'],
            ['name' => 'meeting_update', 'guard' => 'web'],
            ['name' => 'meeting_delete', 'guard' => 'web'],

            // Meeting Invited Member
            ['name' => 'meeting_invited_member_access', 'guard' => 'web'],
            ['name' => 'meeting_invited_member_create', 'guard' => 'web'],
            ['name' => 'meeting_invited_member_update', 'guard' => 'web'],
            ['name' => 'meeting_invited_member_delete', 'guard' => 'web'],

            // Meeting Agenda
            ['name' => 'meeting_agenda_access', 'guard' => 'web'],
            ['name' => 'meeting_agenda_create', 'guard' => 'web'],
            ['name' => 'meeting_agenda_update', 'guard' => 'web'],
            ['name' => 'meeting_agenda_delete', 'guard' => 'web'],

            // Meeting Participants
            ['name' => 'meeting_participants_access', 'guard' => 'web'],
            ['name' => 'meeting_participants_create', 'guard' => 'web'],
            ['name' => 'meeting_participants_update', 'guard' => 'web'],
            ['name' => 'meeting_participants_delete', 'guard' => 'web'],

            // Meeting Decision
            ['name' => 'meeting_decision_access', 'guard' => 'web'],
            ['name' => 'meeting_decision_create', 'guard' => 'web'],
            ['name' => 'meeting_decision_update', 'guard' => 'web'],
            ['name' => 'meeting_decision_delete', 'guard' => 'web'],

            // Meeting Minute
            ['name' => 'meeting_minute_access', 'guard' => 'web'],
            ['name' => 'meeting_minute_update', 'guard' => 'web'],

            // Recommendation Management
            ['name' => 'recommendation_access', 'guard' => 'web'],

            // Recommendation Category
            ['name' => 'recommendation_category_access', 'guard' => 'web'],
            ['name' => 'recommendation_category_create', 'guard' => 'web'],
            ['name' => 'recommendation_category_update', 'guard' => 'web'],
            ['name' => 'recommendation_category_delete', 'guard' => 'web'],

            // Recommendation User Group
            ['name' => 'recommendation_user_group_access', 'guard' => 'web'],
            ['name' => 'recommendation_user_group_create', 'guard' => 'web'],
            ['name' => 'recommendation_user_group_update', 'guard' => 'web'],
            ['name' => 'recommendation_user_group_delete', 'guard' => 'web'],

            // Recommendation
            ['name' => 'recommendation_access', 'guard' => 'web'],
            ['name' => 'recommendation_create', 'guard' => 'web'],
            ['name' => 'recommendation_update', 'guard' => 'web'],
            ['name' => 'recommendation_delete', 'guard' => 'web'],
            ['name' => 'recommendation_approve', 'guard' => 'web'],

            // Apply Recommendation
            ['name' => 'recommendation_apply_access', 'guard' => 'web'],
            ['name' => 'recommendation_apply_update', 'guard' => 'web'],
            ['name' => 'recommendation_apply_create', 'guard' => 'web'],

            // Downloads
            ['name' => 'downloads_access', 'guard' => 'web'],
            ['name' => 'downloads_create', 'guard' => 'web'],
            ['name' => 'downloads_update', 'guard' => 'web'],
            ['name' => 'downloads_delete', 'guard' => 'web'],

            // Emergency Contact
            ['name' => 'emergency_contact_access', 'guard' => 'web'],
            ['name' => 'emergency_contact_create', 'guard' => 'web'],
            ['name' => 'emergency_contact_update', 'guard' => 'web'],
            ['name' => 'emergency_contact_delete', 'guard' => 'web'],

            // Roles
            ['name' => 'roles_access', 'guard' => 'web'],
            ['name' => 'roles_create', 'guard' => 'web'],
            ['name' => 'roles_update', 'guard' => 'web'],
            ['name' => 'roles_delete', 'guard' => 'web'],
            ['name' => 'roles_manage', 'guard' => 'web'],

            // Permissions
            ['name' => 'permissions_access', 'guard' => 'web'],
            ['name' => 'permissions_create', 'guard' => 'web'],
            ['name' => 'permissions_update', 'guard' => 'web'],
            ['name' => 'permissions_delete', 'guard' => 'web'],

            ['name' => 'apply_recommendation_access', 'guard' => 'web'],
            ['name' => 'apply_recommendation_create', 'guard' => 'web'],
            ['name' => 'apply_recommendation_update', 'guard' => 'web'],
            ['name' => 'apply_recommendation_delete', 'guard' => 'web'],

            ['name' => 'task_access', 'guard' => 'web'],
            ['name' => 'task_create', 'guard' => 'web'],
            ['name' => 'task_update', 'guard' => 'web'],
            ['name' => 'task_delete', 'guard' => 'web'],
            ['name' => 'task_view', 'guard' => 'web'],

            ['name' => 'task_type_access', 'guard' => 'web'],
            ['name' => 'task_type_create', 'guard' => 'web'],
            ['name' => 'task_type_update', 'guard' => 'web'],
            ['name' => 'task_type_delete', 'guard' => 'web'],

            ['name' => 'project_access', 'guard' => 'web'],
            ['name' => 'project_create', 'guard' => 'web'],
            ['name' => 'project_update', 'guard' => 'web'],
            ['name' => 'project_delete', 'guard' => 'web'],

            ['name' => 'registration_type_access', 'guard' => 'web'],
            ['name' => 'registration_type_create', 'guard' => 'web'],
            ['name' => 'registration_type_update', 'guard' => 'web'],
            ['name' => 'registration_type_delete', 'guard' => 'web'],
            
            ['name' => 'chalani_access', 'guard' => 'web'],
            ['name' => 'chalani_create', 'guard' => 'web'],
            ['name' => 'chalani_update', 'guard' => 'web'],
            ['name' => 'chalani_delete', 'guard' => 'web'],

            ['name' => 'darta_access', 'guard' => 'web'],
            ['name' => 'darta_create', 'guard' => 'web'],
            ['name' => 'darta_update', 'guard' => 'web'],
            ['name' => 'darta_delete', 'guard' => 'web'],

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
