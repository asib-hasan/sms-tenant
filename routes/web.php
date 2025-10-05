<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\ACHeadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeSalaryController;
use App\Http\Controllers\EmployeeStatusController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssignExamController;
use App\Http\Controllers\AssignTeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\EmployeeSalarySummaryController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\ManageMarksController;
use App\Http\Controllers\MisCostController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AttendanceReportController;
use App\Http\Controllers\StudentStatusController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\DeclareHolidayController;
use App\Http\Controllers\FeesCollectionSummaryController;
use App\Http\Controllers\StudentWaiverController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ClassTeacherController;
use App\Http\Controllers\WeekDaysController;
use App\Http\Controllers\EmployeeAttendanceController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', [AuthController::class, 'select']);
Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return 'Cleared!';
});
Route::group(['prefix' => '{tenant}', 'middleware' => ['tenant']], function () {
    Route::get('/', [AuthController::class, 'login'])->name('home');
    Route::get('login', [AuthController::class, 'Authlogin'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});


Route::group(['prefix' => '{tenant}', 'middleware' => ['tenant','admin']], function () {

    //Dashboard
    Route::get('dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('calendar',[DashboardController::class,'calendar'])->name('calendar');

#profile
    Route::get('my-profile',[MyProfileController::class,'my_profile'])->name('my-profile');
    Route::post('my-profile/change/password',[MyProfileController::class,'change_password'])->name('my-profile/change/password');


//Permission Setup
    Route::get('permission/setup',[PermissionController::class,'setup'])->name('permission/setup');
    Route::post('permission/save',[PermissionController::class,'save'])->name('permission/save');

    Route::get('store-id',[SystemController::class,'store_id'])->name('store-id');

#Student Management
    Route::get('stdmgt/student',[StudentController::class,'index'])->name('stdmgt/student');
    Route::get('stdmgt/student/list/pdf',[StudentController::class,'student_list_pdf'])->name('stdmgt/student/list/pdf');
    Route::get('stdmgt/student/search',[StudentController::class,'search'])->name('stdmgt/student/search');
    Route::get('stdmgt/new/admission',[StudentController::class,'add'])->name('stdmgt/new/admission');
    Route::post('stdmgt/student/store',[StudentController::class,'store'])->name('stdmgt/student/store');
    Route::get('stdmgt/student/profile',[StudentController::class,'profile'])->name('stdmgt/student/profile');
    Route::get('stdmgt/student/edit/',[StudentController::class,'edit'])->name('stdmgt/student/edit');
    Route::post('stdmgt/student/update/',[StudentController::class,'update'])->name('stdmgt/student/update');
    Route::get('stdmgt/student/delete/{id}',[StudentController::class,'delete'])->name('stdmgt/student/delete');
    Route::get('stdmgt/student/view',[StudentController::class,'view'])->name('stdmgt/student/view');

//Registration
    Route::get('stdmgt/registration/by/student',[StudentRegistrationController::class,'by_student'])->name('stdmgt/registration/by/student');
    Route::post('stdmgt/registration/by/student/store',[StudentRegistrationController::class,'by_student_store'])->name('stdmgt/registration/by/student/store');
    Route::post('stdmgt/registration/by/student/update',[StudentRegistrationController::class,'by_student_update'])->name('stdmgt/registration/by/student/update');
    Route::get('stdmgt/registration/by/class',[StudentRegistrationController::class,'by_class'])->name('stdmgt/registration/by/class');
    Route::post('stdmgt/registration/by/class/store',[StudentRegistrationController::class,'by_class_store'])->name('stdmgt/registration/by/class/store');
    Route::get('stdmgt/registration/update',[StudentRegistrationController::class,'reg_update'])->name('stdmgt/registration/update');
    Route::post('stdmgt/registration/update/post',[StudentRegistrationController::class,'reg_update_post'])->name('stdmgt/registration/update/post');
    Route::get('stdmgt/registration/delete',[StudentRegistrationController::class,'delete_registration'])->name('stdmgt/registration/delete');
    Route::post('stdmgt/registration/delete/apply',[StudentRegistrationController::class,'delete_registration_apply'])->name('stdmgt/registration/delete/apply');

//ID Card
    Route::get('stdmgt/id-card/student',[ReportController::class,'id_card_std'])->name('stdmgt/id-card/student');
    Route::get('stdmgt/id-card/student/generate',[ReportController::class,'id_card_std_generate'])->name('stdmgt/id-card/student/generate');

#Employee Management
    Route::get('empmgt/employee',[EmployeeController::class,'index'])->name('empmgt/employee');
    Route::get('empmgt/profile',[EmployeeController::class,'profile_search'])->name('empmgt/profile');
    Route::get('empmgt/employee/list/pdf',[EmployeeController::class,'emp_list_pdf'])->name('empmgt/employee/list/pdf');
    Route::get('empmgt/employee/add',[EmployeeController::class,'add'])->name('empmgt/employee/add');
    Route::get('empmgt/employee/search',[EmployeeController::class,'search'])->name('empmgt/employee/search');
    Route::post('empmgt/employee/store',[EmployeeController::class,'store'])->name('empmgt/employee/store');
    Route::post('empmgt/employee/update',[EmployeeController::class,'update'])->name('empmgt/employee/update');
    Route::get('empmgt/employee/edit',[EmployeeController::class,'edit'])->name('empmgt/employee/edit');
    Route::get('empmgt/employee/view',[EmployeeController::class,'view'])->name('empmgt/employee/view');
    Route::get('empmgt/employee/delete/{id}',[EmployeeController::class,'delete'])->name('empmgt/employee/delete');

//Employee ID Card
    Route::get('empmgt/id-card/employee',[ReportController::class,'id_card_emp'])->name('empmgt/id-card/employee');
    Route::get('empmgt/id-card/employee/generate',[ReportController::class,'id_card_emp_generate'])->name('empmgt/id-card/employee/generate');

//Class
    Route::get('admin/class',[ClassController::class,'index'])->name('admin/class');
    Route::post('admin/class/store',[ClassController::class,'store'])->name('admin/class/store');
    Route::post('admin/class/update',[ClassController::class,'update'])->name('admin/class/update');
    Route::get('admin/class/delete',[ClassController::class,'delete'])->name('admin/class/delete');

//Grade
    Route::get('grade/list',[GradeController::class,'index'])->name('grade/list');

//Exam
    Route::get('exam',[ExamController::class,'index'])->name('exam');
    Route::post('exam/store',[ExamController::class,'store'])->name('exam/store');
    Route::post('exam/update',[ExamController::class,'update'])->name('exam/update');
    Route::get('exam/delete',[ExamController::class,'delete'])->name('exam/delete');

//Subject
    Route::get('subject',[SubjectController::class,'index'])->name('subject');
    Route::post('subject/store',[SubjectController::class,'store'])->name('subject/store');
    Route::post('subject/update/',[SubjectController::class,'update'])->name('subject/update');
    Route::get('subject/delete',[SubjectController::class,'delete'])->name('subject/delete');

//Assign Subject
    Route::get('acmgt/assign/subject',[ClassSubjectController::class,'index'])->name('acmgt/assign/subject');
    Route::post('acmgt/assign/subject/update',[ClassSubjectController::class,'update'])->name('acmgt/assign/subject/update');
    Route::post('acmgt/assign/subject/delete',[ClassSubjectController::class,'delete'])->name('acmgt/assign/subject/delete');

//Assign Exam
    Route::get('acmgt/assign/exam',[AssignExamController::class,'index'])->name('acmgt/assign/exam');
    Route::post('acmgt/assign/exam/update',[AssignExamController::class,'update'])->name('acmgt/assign/exam/update');
    Route::post('acmgt/assign/exam/delete',[AssignExamController::class,'delete'])->name('acmgt/assign/exam/delete');

//Assign Teacher
    Route::get('acmgt/assign/teacher',[AssignTeacherController::class,'index'])->name('acmgt/assign/teacher');
    Route::post('acmgt/assign/teacher/update',[AssignTeacherController::class,'update'])->name('acmgt/assign/teacher/update');
    Route::get('acmgt/assign/teacher/delete',[AssignTeacherController::class,'delete'])->name('acmgt/assign/teacher/delete');

//Class Teacher
    Route::get('acmgt/class/teacher',[ClassTeacherController::class,'index'])->name('acmgt/class/teacher');
    Route::post('acmgt/class/teacher/update',[ClassTeacherController::class,'update'])->name('acmgt/class/teacher/update');

//Session
    Route::get('session',[SessionController::class,'index'])->name('session');
    Route::post('session/store',[SessionController::class,'store'])->name('session/store');
    Route::post('session/update',[SessionController::class,'update'])->name('session/update');
    Route::get('session/delete',[SessionController::class,'delete'])->name('session/delete');

//Designation
    Route::get('designation',[DesignationController::class,'index'])->name('designation');
    Route::post('designation/store',[DesignationController::class,'store'])->name('designation/store');
    Route::post('designation/update',[DesignationController::class,'update'])->name('designation/update');
    Route::get('designation/delete',[DesignationController::class,'delete'])->name('designation/delete');

//Result Management
    Route::get('rmgt/mark/entry/search', [MarksController::class,'search_students'])->name('rmgt/mark/entry/search');
    Route::get('rmgt/mark/entry', [MarksController::class,'mark_entry_index'])->name('rmgt/mark/entry');
    Route::post('rmgt/mark/entry/apply', [MarksController::class,'mark_entry_apply'])->name('rmgt/mark/entry/apply');
    Route::post('rgmt/mark/entry/lock', [MarksController::class,'lock_mark'])->name('rgmt/mark/entry/lock');
    Route::get('rmgt/result',[MarksController::class,'student_result'])->name('rmgt/result');
    Route::get('rmgt/print/result',[MarksController::class,'student_result_pdf'])->name('rmgt/print/result');

//Result Management -> Manage Marks
    Route::get('rgmt/manage/marks',[ManageMarksController::class,'index'])->name('rgmt/manage/marks');
    Route::get('rgmt/manage/marks/search',[ManageMarksController::class,'search'])->name('rgmt/manage/marks/search');
    Route::get('rgmt/manage/marks/find/exam',[ManageMarksController::class,'find_exam'])->name('rgmt/manage/marks/find/exam');
    Route::post('rgmt/manage/marks/publish',[ManageMarksController::class,'publish'])->name('rgmt/manage/marks/publish');
    Route::post('rgmt/manage/marks/unpublish',[ManageMarksController::class,'unpublish'])->name('rgmt/manage/marks/unpublish');
    Route::post('rgmt/manage/marks/lock',[ManageMarksController::class,'lock'])->name('rgmt/manage/marks/lock');
    Route::post('rgmt/manage/marks/unlock',[ManageMarksController::class,'unlock'])->name('rgmt/manage/marks/unlock');
    Route::get('rgmt/manage/marks/review',[ManageMarksController::class,'review_marks_entry'])->name('rgmt/manage/marks/review');
    Route::post('rgmt/manage/marks/review/update',[ManageMarksController::class,'review_marks_entry_update'])->name('rgmt/manage/marks/review/update');

//ac_head
    Route::get('account/head',[ACHeadController::class,'index'])->name('account/head');
    Route::post('account/head/store',[ACHeadController::class,'store'])->name('account/head/store');
    Route::post('account/head/update',[ACHeadController::class,'update'])->name('account/head/update');
    Route::get('account/head/delete',[ACHeadController::class,'delete'])->name('account/head/delete');

//Student Accounts
//Fee Structure
    Route::get('stdacc/fee/structure/by/student',[FeesController::class,'bystudent'])->name('stdacc/fee/structure/by/student');
    Route::post('stdacc/fee/structure/apply/student',[FeesController::class,'apply_fees_for_student'])->name('stdacc/fee/structure/apply/student');
    Route::get('stdacc/fee/structure/by/class',[FeesController::class,'byclass'])->name('stdacc/fee/structure/by/class');
    Route::post('stdacc/fee/structure/apply/class',[FeesController::class,'apply_fees_for_class'])->name('stdacc/fee/structure/apply/class');
    Route::get('stdacc/fee/structure/by/school',[FeesController::class,'byschool'])->name('stdacc/fee/structure/by/school');
    Route::post('stdacc/fee/structure/apply/school',[FeesController::class,'apply_fees_for_school'])->name('stdacc/fee/structure/apply/school');
    Route::post('stdacc/fees/collection/invoice/update',[FeesController::class, 'invoice_update'])->name('stdacc/fees/collection/invoice/update');
    Route::post('stdacc/fees/collection/invoice/delete',[FeesController::class, 'invoice_delete'])->name('stdacc/fees/collection/invoice/delete');

    //Waiver
    Route::get('stdacc/waiver/student',[StudentWaiverController::class,'waiver_student'])->name('stdacc/waiver/student');
    Route::post('stdacc/waiver/apply/student',[StudentWaiverController::class,'apply_student'])->name('stdacc/waiver/apply/student');
    Route::get('stdacc/waiver/class',[StudentWaiverController::class,'waiver_class'])->name('stdacc/waiver/class');
    Route::post('stdacc/waiver/apply/class',[StudentWaiverController::class,'apply_class'])->name('stdacc/waiver/apply/class');
    Route::get('stdacc/waiver/classes',[StudentWaiverController::class,'waiver_classes'])->name('stdacc/waiver/classes');
    Route::post('stdacc/waiver/apply/classes',[StudentWaiverController::class,'apply_classes'])->name('stdacc/waiver/apply/classes');

//Fees Collection
    Route::get('stdacc/fees/collection',[FeesController::class,'fees_collection'])->name('stdacc/fees/collection');
    Route::post('stdacc/fees/collection/apply',[FeesController::class,'fees_collection_apply'])->name('stdacc/fees/collection/apply');

//Fees Collection Summary
    Route::get('stdacc/fees/collection/summary',[FeesCollectionSummaryController::class,'index'])->name('stdacc/fees/collection/summary');
    Route::get('stdacc/print/fees/collection/summary',[FeesCollectionSummaryController::class,'print'])->name('stdacc/print/fees/collection/summary');

//Student Dues
    Route::get('stdacc/dues/student',[FeesController::class,'student_dues_byStudent'])->name('stdacc/dues/student');
    Route::get('stdacc/dues/class',[FeesController::class,'student_dues_byClass'])->name('stdacc/dues/class');
    Route::get('stdacc/dues/report',[FeesController::class,'student_dues_report'])->name('stdacc/dues/report');
    Route::post('stdacc/dues/report/find/{id}',[FeesController::class,'find_dues'])->name('find-dues');
    Route::post('stdacc/dues/update',[FeesController::class,'update_dues'])->name('stdacc/dues/update');
    Route::post('stdacc/dues/delete',[FeesController::class,'delete_dues'])->name('stdacc/dues/delete');

//Transaction History (Student Account)
    Route::get('stdacc/transaction/history',[AccountsController::class,'transaction_student'])->name('stdacc/transaction/history');
    Route::get('stdacc/transaction/view',[AccountsController::class,'transaction_view'])->name('stdacc/transaction/view');

//General Accounts
//Salary Structure
    Route::get('genacc/salary/structure/employee',[EmployeeSalaryController::class,'by_employee'])->name('genacc/salary/structure/employee');
    Route::post('genacc/salary/structure/employee/apply',[EmployeeSalaryController::class,'apply_salary_by_employee'])->name('genacc/salary/structure/employee/apply');
    Route::get('genacc/salary/structure/designation',[EmployeeSalaryController::class,'by_designation'])->name('genacc/salary/structure/designation');
    Route::post('genacc/salary/structure/designation/apply',[EmployeeSalaryController::class,'apply_salary_by_designation'])->name('genacc/salary/structure/designation/apply');

//Salary payment
    Route::get('genacc/salary/payment',[EmployeeSalaryController::class,'salary_payment'])->name('genacc/salary/payment');
    Route::post('genacc/salary/payment/apply',[EmployeeSalaryController::class,'salary_payment_apply'])->name('genacc/salary/payment/apply');
    Route::post('genacc/salary/invoice/update',[EmployeeSalaryController::class,'invoice_update'])->name('genacc/salary/invoice/update');
    Route::post('genacc/salary/invoice/delete',[EmployeeSalaryController::class,'invoice_delete'])->name('genacc/salary/invoice/delete');

//Salary summary
    Route::get('genacc/salary/payment/summary',[EmployeeSalarySummaryController::class,'index'])->name('genacc/salary/payment/summary');
    Route::get('genacc/print/salary/payment/summary',[EmployeeSalarySummaryController::class,'print'])->name('genacc/print/salary/payment/summary');

//Salary Report
    Route::get('genacc/salary/report/employee',[EmployeeSalaryController::class,'salary_by_employee'])->name('genacc/salary/report/employee');
    Route::get('genacc/salary/report/designation',[EmployeeSalaryController::class,'salary_by_designation'])->name('genacc/salary/report/designation');
    Route::get('genacc/salary/report/session',[EmployeeSalaryController::class,'employee_salary_report'])->name('genacc/salary/report/session');
    Route::post('genacc/salary/report/update',[EmployeeSalaryController::class,'update_salary'])->name('genacc/salary/report/update');
    Route::post('genacc/salary/report/delete',[EmployeeSalaryController::class,'delete_salary'])->name('genacc/salary/report/delete');
    Route::post('genacc/salary/report/find',[EmployeeSalaryController::class,'find_salary'])->name('find-salary');

//Miscellaneous Cost
    Route::get('genacc/miscellaneous/cost',[MisCostController::class,'index'])->name('genacc/miscellaneous/cost');
    Route::get('genacc/miscellaneous/cost/add',[MisCostController::class,'add'])->name('genacc/miscellaneous/cost/add');
    Route::post('genacc/miscellaneous/cost/store',[MisCostController::class,'store'])->name('genacc/miscellaneous/cost/store');
    Route::get('genacc/miscellaneous/cost/edit',[MisCostController::class,'edit'])->name('genacc/miscellaneous/cost/edit');
    Route::post('genacc/miscellaneous/cost/update',[MisCostController::class,'update'])->name('genacc/miscellaneous/cost/update');
    Route::post('genacc/miscellaneous/cost/delete',[MisCostController::class,'delete'])->name('genacc/miscellaneous/cost/delete');

//Investment Income
    Route::get('genacc/investment',[InvestmentController::class,'index'])->name('genacc/investment');
    Route::get('genacc/investment/add',[InvestmentController::class,'add'])->name('genacc/investment/add');
    Route::post('genacc/investment/store',[InvestmentController::class,'store'])->name('genacc/investment/store');
    Route::get('genacc/investment/edit',[InvestmentController::class,'edit'])->name('genacc/investment/edit');
    Route::post('genacc/investment/update',[InvestmentController::class,'update'])->name('genacc/investment/update');
    Route::post('genacc/investment/delete',[InvestmentController::class,'delete'])->name('genacc/investment/delete');
    Route::get('genacc/investment/print/voucher',[InvestmentController::class,'print'])->name('genacc/investment/print/voucher');

//Balance Sheet
    Route::get('genacc/balance/sheet',[AccountsController::class,'balance_sheet'])->name('genacc/balance/sheet');

//Transaction History (General Account)
    Route::get('genacc/transaction/history',[AccountsController::class,'transaction_employee'])->name('genacc/transaction/history');
    Route::get('genacc/transaction/view',[AccountsController::class,'transaction_view_emp'])->name('genacc/transaction/view');

//Attendance Management
    Route::get('atmgt/student',[StudentAttendanceController::class,'index'])->name('atmgt/student');
    Route::get('atmgt/student/entry',[StudentAttendanceController::class,'entry'])->name('atmgt/student/entry');
    Route::get('atmgt/student/print',[StudentAttendanceController::class,'print'])->name('atmgt/student/print');
    Route::post('atmgt/student/entry/store',[StudentAttendanceController::class,'store'])->name('atmgt/student/entry/store');
    Route::get('atmgt/student/entry/edit',[StudentAttendanceController::class,'edit'])->name('atmgt/student/entry/edit');
    Route::get('atmgt/student/entry/delete',[StudentAttendanceController::class,'delete'])->name('atmgt/student/entry/delete');
    Route::post('atmgt/student/entry/update',[StudentAttendanceController::class,'update'])->name('atmgt/student/entry/update');
    Route::get('atmgt/attendance/sheet',[StudentAttendanceController::class,'attendance_sheet'])->name('atmgt/attendance/sheet');
    Route::get('atmgt/print/attendance/sheet',[StudentAttendanceController::class,'print'])->name('atmgt/print/attendance/sheet');

//Employee Attendance
    Route::get('atmgt/employee',[EmployeeAttendanceController::class,'index'])->name('atmgt/employee');
    Route::post('atmgt/employee/store',[EmployeeAttendanceController::class,'store'])->name('atmgt/employee/store');
    Route::post('atmgt/employee/update',[EmployeeAttendanceController::class,'update'])->name('atmgt/employee/update');
    Route::post('atmgt/employee/delete',[EmployeeAttendanceController::class,'delete'])->name('atmgt/employee/delete');

    //Attendance Report
    Route::get('atmgt/report/student',[AttendanceReportController::class,'by_student'])->name('atmgt/report/student');
    Route::get('atmgt/report/print/student',[AttendanceReportController::class,'by_student_pdf'])->name('atmgt/report/print/student');
    Route::get('atmgt/report/employee',[AttendanceReportController::class,'by_employee'])->name('atmgt/report/employee');
    Route::get('atmgt/report/print/employee',[AttendanceReportController::class,'by_employee_pdf'])->name('atmgt/report/print/employee');

//Daily Summary
    Route::get('atmgt/daily/summery/std',[AttendanceController::class,'daily_summery_std'])->name('atmgt/daily/summery/std');
    Route::get('atmgt/daily/summery/emp',[AttendanceController::class,'daily_summery_emp'])->name('atmgt/daily/summery/emp');

#HR Management
//Employee Status
    Route::get('hrmgt/employee/status',[EmployeeStatusController::class,'index'])->name('hrmgt/employee/status');
    Route::post('hrmgt/employee/status/update',[EmployeeStatusController::class,'update'])->name('hrmgt/employee/status/update');
    Route::get('hrmgt/employee/status/resigned/records',[EmployeeStatusController::class,'resigned_records'])->name('hrmgt/employee/status/resigned/records');

//Student Status
    Route::get('hrmgt/student/status',[StudentStatusController::class,'index'])->name('hrmgt/student/status');
    Route::post('hrmgt/student/status/update',[StudentStatusController::class,'update'])->name('hrmgt/student/status/update');
    Route::get('hrmgt/student/status/inactive/records',[StudentStatusController::class,'inactive_records'])->name('hrmgt/student/status/inactive/records');

//Week Days
    Route::get('hrmgt/week/days',[WeekDaysController::class,'index'])->name('hrmgt/week/days');
    Route::post('hrmgt/week/days/update',[WeekDaysController::class,'update'])->name('hrmgt/week/days/update');

//Declare Holiday
    Route::get('hrmgt/declare/holiday',[DeclareHolidayController::class,'index'])->name('hrmgt/declare/holiday');
    Route::post('hrmgt/declare/holiday/store',[DeclareHolidayController::class,'store'])->name('hrmgt/declare/holiday/store');
    Route::get('hrmgt/declare/holiday/delete',[DeclareHolidayController::class,'delete'])->name('hrmgt/declare/holiday/delete');

#Report Management
//Attendance Sheet
    Route::get('attendance/sheet',[ReportController::class,'attendance_sheet'])->name('attendance/sheet');
    Route::get('attendance/sheet/generate',[ReportController::class,'print_attendance_sheet'])->name('attendance/sheet/generate');

//Admit Card
    Route::get('rpmgt/admit/card/by/student',[ReportController::class,'admit_card_by_student'])->name('rpmgt/admit/card/by/student');
    Route::get('rpmgt/admit/card/by/class',[ReportController::class,'admit_card_by_class'])->name('rpmgt/admit/card/by/class');
    Route::get('rpmgt/admit/card/print/student',[ReportController::class,'print_admit_card_student'])->name('rpmgt/admit/card/print/student');
    Route::get('rpmgt/admit/card/print/class',[ReportController::class,'print_admit_card_class'])->name('rpmgt/admit/card/print/class');

//Testimonial
    Route::get('admin/testimonial/search',[ReportController::class,'search_testimonial'])->name('admin/testimonial/search');
    Route::get('admin/testimonial/generate',[ReportController::class,'generate_testimonial'])->name('admin/testimonial/generate');

//ID Card
    Route::get('select-id-card/student',[ReportController::class,'select_stu'])->name('select-id-card/student');
    Route::post('select-id-card/student/update',[ReportController::class,'select_stu_update'])->name('select-id-card/student/update');
    Route::post('select-id-card/employee-apply',[ReportController::class,'select_emp_apply'])->name('select-id-card/employee-apply');
    Route::get('select-id-card/employee',[ReportController::class,'select_emp'])->name('select-id-card/employee');
    Route::post('select-id-card/employee/update',[ReportController::class,'select_emp_apply'])->name('select-id-card/employee/update');
    Route::get('student/id-card/search',[ReportController::class,'search_id_card'])->name('student/id-card/search');
    Route::get('student/id-card/generate',[ReportController::class,'generate_id_card'])->name('student/id-card/generate');
    Route::get('admin/employee/id-card/search',[ReportController::class,'search_id_card_emp'])->name('admin/employee/id-card/search');
    Route::get('admin/employee/id-card/generate',[ReportController::class,'generate_id_card_emp'])->name('admin/employee/id-card/generate');

#Account Recovery
    Route::get('spmgt/account/recovery/emp',[SupportController::class,'account_rec_emp'])->name('spmgt/account/recovery/emp');
    Route::post('spmgt/account/recovery/emp/update',[SupportController::class,'account_rec_emp_update'])->name('spmgt/account/recovery/emp/update');
    Route::get('spmgt/account/recovery/std',[SupportController::class,'account_rec_std'])->name('spmgt/account/recovery/std');
    Route::post('spmgt/account/recovery/std/update',[SupportController::class,'account_rec_std_update'])->name('spmgt/account/recovery/std/update');

#SMS Service
    Route::get('send-sms/by/student',[SmsController::class,'by_student'])->name('send-sms/by/student');
    Route::post('send-sms/student/send',[SmsController::class,'student_send'])->name('send-sms/student/send');

    Route::get('send-sms/by/employee',[SmsController::class,'by_employee'])->name('send-sms/by/employee');
    Route::post('send-sms/employee/send',[SmsController::class,'employee_send'])->name('send-sms/employee/send');

    Route::get('send-sms/by/class',[SmsController::class,'by_class'])->name('send-sms/by/class');
    Route::post('send-sms/class/send',[SmsController::class,'class_send'])->name('send-sms/class/send');

    Route::get('send-sms/by/designation',[SmsController::class,'by_designation'])->name('send-sms/by/designation');
    Route::get('send-sms/search/designation',[SmsController::class,'search_designation'])->name('send-sms/search/designation');
    Route::post('send-sms/designation/send',[SmsController::class,'designation_send'])->name('send-sms/designation/send');

    Route::get('send-sms/by/number',[SmsController::class,'by_number'])->name('send-sms/by/number');
    Route::post('send-sms/number/send',[SmsController::class,'number_send'])->name('send-sms/number/send');

#Developer Console
    Route::get('sst/activity/log',[SystemController::class,'activity_log'])->name('sst/activity/log');
    Route::get('sst/school/setup',[SystemController::class,'school_setup'])->name('sst/school/setup');
    Route::post('sst/school/setup/update',[SystemController::class,'school_setup_update'])->name('sst/school/setup/update');

#Ajax
    Route::get('/session-wise-all-student', [AjaxController::class, 'session_wise_all_student'])->name('session-wise-all-student');
    Route::get('/session-wise-active-student', [AjaxController::class, 'session_wise_active_student'])->name('session-wise-active-student');


});

Route::group(['prefix' => '{tenant}', 'middleware' => ['tenant','student']], function () {
    Route::get('std/dashboard', [StudentDashboardController::class, 'index'])->name('std/dashboard');
    Route::get('std/profile', [StudentDashboardController::class, 'my_profile'])->name('std/profile');
    Route::post('std/profile/change/password', [StudentDashboardController::class, 'change_password'])->name('std/profile/change/password');
    Route::get('std/subjects', [StudentDashboardController::class, 'my_subject'])->name('std/subjects');
    Route::get('std/payment/details', [StudentDashboardController::class, 'payment_details'])->name('std/payment/details');
    Route::get('std/exam/result', [StudentDashboardController::class, 'result'])->name('std/exam/result');
});
