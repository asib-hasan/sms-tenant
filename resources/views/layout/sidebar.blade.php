<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ !empty($header_title) ? $header_title : 'My School' }}</title>
    @include('components.styles')
    @include('components.scripts')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="{{ route('logout') }}">
                        <i class="fa fa-sign-out"></i>
                        Log Out
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:#020e41; font-size:15px;">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset($school_info->logo_circle) }}" alt=" " class="brand-image img-circle elevation-3" style="">
                <span class="brand-text font-weight-lightbrand-text font-weight-bold">{{ $school_info->short_name }}</span>
            </a>
            <nav class="mt-2">
                <div class="sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="info ml-3">
                            <a href="#" class="d-block"><i class="fa fa-user mr-2"></i> {{ Auth::user()->user_id }}</a>
                        </div>
                    </div>

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion>
                        <li class="nav-item">
                            <a id="dashboard" href="{{ route('dashboard') }}"
                                class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="my-profile" href="{{ route('my-profile') }}"
                               class="nav-link">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>My Profile</p>
                            </a>
                        </li>

                        <li class="nav-header">Setup & Configuration</li>
                        @can('hrm_setup', 1)
                        <li id="hrm-setup" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-life-ring"></i>
                                <p>
                                    HRM Setup
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('setup_permission', 1)
                                <li class="nav-item">
                                    <a id="setup-permission" href="{{ route('permission/setup') }}"
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Setup Permissions</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('global_settings', 2)
                        <li id="global-settings" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-cog"></i>
                                <p>
                                    Global Settings
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('session_list', 2)
                                <li class="nav-item">
                                    <a id="session" href="{{ route('session') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Session</p>
                                    </a>
                                </li>
                                @endcan

                                @can('designation_list', 6)
                                <li class="nav-item">
                                    <a id="designation" href="{{ route('designation') }}"
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Designation</p>
                                    </a>
                                </li>
                                @endcan

                                @can('select_id', 10)
                                <li class="nav-item">
                                    <a id="select-id-card" href="{{ route('select-id-card/student') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Select ID Card</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('academic_settings', 3)
                        <li id="academic-settings" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fas fa-book-open"></i>
                                <p>
                                    Academic Settings
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('class_list', 12)
                                <li class="nav-item">
                                    <a id="class" href="{{ route('admin/class') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Class</p>
                                    </a>
                                </li>
                                @endcan
                                @can('exam_list', 16)
                                <li class="nav-item">
                                    <a id="exam" href="{{ route('exam') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Exam</p>
                                    </a>
                                </li>
                                @endcan
                                @can('grade_list', 20)
                                <li class="nav-item">
                                    <a id="grade" href="{{ route('grade/list') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Grade</p>
                                    </a>
                                </li>
                                @endcan
                                @can('subject_list', 24)
                                <li class="nav-item">
                                    <a id="subject" href="{{ route('subject') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Subject</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('accounts_settings',4)
                        <li id="accounts-settings" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-key"></i>
                                <p>
                                    Accounts Settings
                                    <i class="fas fa-angle-left right "></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('achead_list', 32)
                                <li class="nav-item">
                                    <a id="account-head" href="{{ route('account/head') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Account Head</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        <li class="nav-header">Management</li>
                        @can('academic_management',13)
                        <li id="academic-management" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-graduation-cap"></i>
                                <p>
                                    Academic Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('assign_subject', 29)
                                <li class="nav-item">
                                    <a id="assign-subject" href="{{ route('acmgt/assign/subject') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Assign Subject</p>
                                    </a>
                                </li>
                                @endcan
                                @can('assign_exam', 30)
                                <li class="nav-item">
                                    <a id="assign-exam" href="{{ route('acmgt/assign/exam') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Assign Exam</p>
                                    </a>
                                </li>
                                @endcan
                                @can('assign_teacher', 31)
                                <li class="nav-item">
                                    <a id="assign-teacher" href="{{ route('acmgt/assign/teacher') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Assign Teacher</p>
                                    </a>
                                </li>
                                @endcan
                                @can('class_teacher', 83)
                                <li class="nav-item">
                                    <a id="class-teacher" href="{{ route('acmgt/class/teacher') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Class Teacher</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('std_management', 5)
                        <li id="student-management" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    Student Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                @can('std_add', 37)
                                <li class="nav-item">
                                    <a id="new-admission" href="{{ route('stdmgt/new/admission') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>New Admission</p>
                                    </a>
                                </li>
                                @endcan
                                @can('student_registration', 84)
                                <li class="nav-item">
                                    <a id="student-reg" href="{{ route('stdmgt/registration/by/student') }}"
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Student Registration</p>
                                    </a>
                                </li>
                                @endcan
                                @can('std_profile', 40)
                                <li class="nav-item">
                                    <a id="student-profile" href="{{ route('stdmgt/student/profile') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Student Profile</p>
                                    </a>
                                </li>
                                @endcan
                                @can('std_list', 36)
                                <li class="nav-item">
                                    <a id="student-list" href="{{ route('stdmgt/student') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Student List</p>
                                    </a>
                                </li>
                                @endcan
                                @can('std_id', 41)
                                <li class="nav-item">
                                    <a id="student-id-card" href="{{ route('stdmgt/id-card/student') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Student ID Card</p>
                                    </a>
                                </li>
                                @endcan
                                @can('delete_registration', 92)
                                <li class="nav-item">
                                    <a id="registration-delete" href="{{ route('stdmgt/registration/delete') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Registration Delete</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan

                        @can('emp_management', 6)
                        <li id="employee-management" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Employee Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                @can('emp_add', 43)
                                <li class="nav-item">
                                    <a id="add-new-employee" href="{{ route('empmgt/employee/add') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Add New Employee</p>
                                    </a>
                                </li>
                                @endcan
                                @can('emp_list', 42)
                                <li class="nav-item">
                                    <a id="employee-list" href="{{ route('empmgt/employee') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Employee List</p>
                                    </a>
                                </li>
                                @endcan
                                @can('emp_profile', 46)
                                <li class="nav-item">
                                    <a id="emp-profile" href="{{ route('empmgt/profile') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Employee Profile</p>
                                    </a>
                                </li>
                                @endcan
                                @can('emp_id', 40)
                                <li class="nav-item">
                                    <a id="employee-id-card" href="{{ route('empmgt/id-card/employee') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Employee ID Card</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('hr_management', 16)
                            <li id="hr-management" class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-tie"></i>
                                    <p>
                                        HR Management
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('employee_status', 85)
                                    <li class="nav-item">
                                        <a id="employee-status" href="{{ route('hrmgt/employee/status') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                            <p>Employee Status</p>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('employee_status', 85)
                                        <li class="nav-item">
                                            <a id="student-status" href="{{ route('hrmgt/student/status') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                                <p>Student Status</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('week_days', 93)
                                        <li class="nav-item">
                                            <a id="weekdays" href="{{ route('hrmgt/week/days') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                                <p>Week Days</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('declare_holiday', 94)
                                        <li class="nav-item">
                                            <a id="declare-holiday" href="{{ route('hrmgt/declare/holiday') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                                <p>Declare Holiday</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('mark_management', 7)
                        <li id="result-management" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-chart-bar"></i>
                                <p>
                                    Result Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                @can('manage_marks', 28)
                                <li class="nav-item">
                                    <a id="manage-marks" href="{{ route('rgmt/manage/marks') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Manage Marks</p>
                                    </a>
                                </li>
                                @endcan
                                @can('mark_entry', 48)
                                <li class="nav-item">
                                    <a id="mark-entry" href="{{ route('rmgt/mark/entry/search') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Marks Entry</p>
                                    </a>
                                </li>
                                @endcan
                                @can('result_page', 49)
                                <li class="nav-item">
                                    <a id="result-sheet" href="{{ route('rmgt/result') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Student Result</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('std_accounts', 8)
                        <li id="student-accounts" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-money-check"></i>
                                <p>
                                    Student Accounts
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('fee_structure', 50)
                                <li class="nav-item">
                                    <a id="fee-structure" href="{{ route('stdacc/fee/structure/by/student') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Fee Structure</p>
                                    </a>
                                </li>
                                @endcan
                                @can('apply_waiver', 51)
                                <li class="nav-item">
                                    <a id="apply-waiver" href="{{ route('stdacc/waiver/student') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Apply Waiver</p>
                                    </a>
                                </li>
                                @endcan
                                @can('fees_collection', 52)
                                <li class="nav-item">
                                    <a id="fees-collection" href="{{ route('stdacc/fees/collection') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Fees Collection</p>
                                    </a>
                                </li>
                                @endcan
                                @can('student_dues_list', 54)
                                <li class="nav-item">
                                    <a id="student-dues" href="{{ route('stdacc/dues/student') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Student Dues</p>
                                    </a>
                                </li>
                                @endcan
                                @can('transaction_history_std', 53)
                                <li class="nav-item">
                                    <a id="transaction-history-student" href="{{ route('stdacc/transaction/history') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Transaction History</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan

                        @can('general_accounts', 9)
                        <li id="general-accounts" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon  fas fa-balance-scale"></i>
                                <p>
                                    General Accounts
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('create_emp_salary', 57)
                                <li class="nav-item">
                                    <a id="salary-structure" href="{{ route('genacc/salary/structure/employee') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p style="white-space: nowrap">Salary Structure</p>
                                    </a>
                                </li>
                                @endcan
                                @can('salary_payment', 58)
                                <li class="nav-item">
                                    <a id="salary-payment" href="{{ route('genacc/salary/payment') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Salary Payment</p>
                                    </a>
                                </li>
                                @endcan
                                @can('salary_report_list', 61)
                                <li class="nav-item">
                                    <a id="salary-report" href="{{ route('genacc/salary/report/employee') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Salary Report</p>
                                    </a>
                                </li>
                                @endcan
                                @can('transaction_history_emp', 59)
                                <li class="nav-item">
                                    <a id="transaction-history-employee" href="{{ route('genacc/transaction/history') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Transaction History</p>
                                    </a>
                                </li>
                                @endcan
                                @can('misc_list', 64)
                                <li class="nav-item">
                                    <a id="misc-cost" href="{{ route('genacc/miscellaneous/cost') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Miscellaneous Cost</p>
                                    </a>
                                </li>
                                @endcan
                                @can('invest_list', 68)
                                <li class="nav-item">
                                    <a id="investment" href="{{ route('genacc/investment') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Investment/Donation</p>
                                    </a>
                                </li>
                                @endcan
                                @can('balance_sheet', 60)
                                <li class="nav-item">
                                    <a id="finance-report" href="{{ route('genacc/balance/sheet') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Finance Report</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('attendance_management',14)
                        <li id="attendance-management" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>
                                    Attendance Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('student_attendance', 86)
                                <li class="nav-item">
                                    <a id="student-attendance" href="{{ route('atmgt/student') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Student Attendance</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="student-attendance-sheet" href="{{ route('atmgt/attendance/sheet') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Attendance Sheet</p>
                                    </a>
                                </li>
                                @endcan
                                @can('employee_attendance', 96)
                                <li class="nav-item">
                                    <a id="employee-attendance" href="{{ route('atmgt/employee') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Employee Attendance</p>
                                    </a>
                                </li>
                                @endcan
                                @can('attendance_report', 95)
                                <li class="nav-item">
                                    <a id="attendance-report" href="{{ route('atmgt/report/student') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Attendance Report</p>
                                    </a>
                                </li>
                                @endcan
                                @can('daily_summery', 81)
                                <li class="nav-item">
                                    <a id="daily-summery" href="{{ route('atmgt/daily/summery/std') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Daily Summary</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('report_management',10)
                        <li id="report-management" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-file-text"></i>
                                <p>
                                    Report Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('attendance_report', 72)
                                <li class="nav-item">
                                    <a id="attendance-sheet" href="{{ route('attendance/sheet') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Attendance Sheet</p>
                                    </a>
                                </li>
                                @endcan
                                @can('admit_card', 73)
                                <li class="nav-item">
                                    <a id="admit-card" href="{{ route('rpmgt/admit/card/by/student') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Admit card</p>
                                    </a>
                                </li>
                                @endcan
                                {{-- @can('testimonial', 76) --}}
                                <li class="nav-item">
                                    <a id="testimonial" href="{{ route('admin/testimonial/search') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Testimonial</p>
                                    </a>
                                </li>
                                {{-- @endcan --}}
                            </ul>
                        </li>
                        @endcan
                        @can('support_management',11)
                        <li id="support-management" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-hands-helping"></i>
                                <p>
                                    Support Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                @can('account_recovery', 74)
                                <li class="nav-item">
                                    <a id="account-recovery" href="{{ route('spmgt/account/recovery/emp') }}" class="nav-link"><i class="far fa-circle nav-icon"></i>
                                        <p>Account Recovery</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('sms_service', 12)
                        <li id="sms-service" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-sms"></i>
                                <p>
                                    SMS Service
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                @can('send_sms', 75)
                                <li class="nav-item">
                                    <a id="send-sms" href="{{ route('send-sms/by/student') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Send SMS</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('system_settings', 17)
                        <li id="developer-console" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    System Settings
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('activity_log', 88)
                                <li class="nav-item">
                                    <a id="activity-log" href="{{ route('sst/activity/log') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Activity Log</p>
                                    </a>
                                </li>
                                @endcan
                                @can('activity_log', 88)
                                    <li class="nav-item">
                                        <a id="school-setup" href="{{ route('sst/school/setup') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>School Setup</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        <li class="nav-header">Others</li>
                        <li class="nav-item">
                            <a href="{{ route('calendar') }}" class="nav-link">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>Calendar</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="nav-icon fas fa-columns"></i>
                                <p>Support</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>FAQ</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>
    </div>
    @yield('content')
</body>


<script>
    $(function() {
        $('.select2').select2()
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('.form-prevent').on('submit', function () {

            $('.form-prevent-multiple-submit').attr('disabled', 'true');

            $('.form-prevent-multiple-submit').html('Processing...');

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#session_wise_all_student').change(function () {
            let sessionId = $(this).val();
            let studentDropdown = $('#all_student_load');

            studentDropdown.html('<option value="">Select</option>');

            if (sessionId) {
                $.ajax({
                    url: `{{ route('session-wise-all-student') }}`, // use url
                    type: 'GET',
                    data: { sessionId: sessionId },
                    success: function (data) {
                        $.each(data, function (key, student) {
                            studentDropdown.append(
                                `<option value="${student.student_id}">${student.student_info.first_name} ${student.student_info.last_name} [${student.student_id}]</option>`
                            );
                        });
                    },
                    error: function () {
                        console.log('Could not load students.');
                    },
                });
            }
        });


        $('#session_wise_active_student').change(function () {
            let sessionId = $(this).val();
            let studentDropdown = $('#active_student_load');

            studentDropdown.html('<option value="">Select</option>');

            if (sessionId) {
                $.ajax({
                    url: `{{ route('session-wise-active-student') }}`, // <-- use url, not route
                    type: 'GET',
                    data: { sessionId: sessionId }, // send as query parameter
                    success: function (data) {
                        $.each(data, function (key, student) {
                            studentDropdown.append(
                                `<option value="${student.student_id}">${student.student_info.first_name} ${student.student_info.last_name} [${student.student_id}]</option>`
                            );
                        });
                    },
                    error: function () {
                        console.log('Could not load students.');
                    },
                });
            }
        });

    });
</script>
</html>
