<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Psy\Readline\Hoa\Console;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Dashboard

        Gate::define('dash_student', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('dash_teacher', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('dash_feesCollection', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('dash_classWise', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('dash_incomeExpense', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('dash_attendance_percentage', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('dash_estimated_fee', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });

        //HRM Setup
        Gate::define('setup_permission', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        //Global Settings ->Session
        Gate::define('session_list', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('session_add', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('session_edit', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('session_delete', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        //Global Settings->Designation
        Gate::define('designation_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id,$permissionId);
        });
        Gate::define('designation_add', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('designation_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('designation_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        //Global Settings-> ID Card
        Gate::define('select_id', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('select_id_emp', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('class_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('class_add', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('class_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('class_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('exam_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('exam_add', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('exam_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('exam_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });

        //Grade
        Gate::define('grade_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('grade_add', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('grade_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('grade_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });

        //Subject

        Gate::define('subject_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('subject_add', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('subject_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('subject_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });

        //Assign Subject, Exam, Teacher
        Gate::define('assign_subject', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('assign_exam', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('assign_teacher', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('class_teacher', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });

        //Account Head

        Gate::define('achead_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('achead_add', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('achead_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('achead_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });

        //Student Management

        Gate::define('std_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('std_add', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('std_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('std_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('std_profile', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('std_id', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('student_registration', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('delete_registration', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });

        //Employee Profile
        Gate::define('emp_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('emp_add', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('emp_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('emp_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('emp_profile', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('emp_id', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });

        //HR Management
        Gate::define('employee_status', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('week_days', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('declare_holiday', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });

        //Result Management

        Gate::define('manage_marks', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('mark_entry', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('result_page', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });

        //Student Accounts
        Gate::define('fee_structure', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('apply_waiver', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('fees_collection', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('transaction_history_std', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('student_dues_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('student_dues_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('student_dues_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });

        //General Accounts
        Gate::define('create_emp_salary', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('salary_payment', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('transaction_history_emp', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('transaction_history_std', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('balance_sheet', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('salary_report_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('salary_report_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('salary_report_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('misc_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('misc_add', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('misc_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('misc_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('invest_list', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('invest_add', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('invest_edit', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('invest_delete', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('invest_voucher', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });

        //Attendance Management
        Gate::define('student_attendance', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('employee_attendance', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('attendance_report', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });
        Gate::define('daily_summery', function ($user, $permissionId) {
            return $user->hasPermission( $user->id,$permissionId);
        });

        //Report Management
        Gate::define('attendance_sheet', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('admit_card', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('testimonial_card', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });

        //Support Management
        Gate::define('account_recovery', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });
        Gate::define('send_sms', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });

        //System Settings
        Gate::define('activity_log', function ($user, $permissionId) {
            return $user->hasPermission($user->id, $permissionId);
        });


        #ALL MODULES
        Gate::define('academic_management', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('hrm_setup', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('global_settings', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('academic_settings', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('accounts_settings', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('std_management', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('emp_management', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('mark_management', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('std_accounts', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('general_accounts', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('attendance_management', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('report_management', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('support_management', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('sms_service', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('hr_management', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });
        Gate::define('system_settings', function ($user, $moduleId) {
            return $user->hasModule( $user->id,$moduleId);
        });

    }
}
