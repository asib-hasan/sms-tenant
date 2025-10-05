<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use App\Models\EmployeeAttendanceModel;
use App\Models\Student;
use App\Models\StudentAttendanceModel;
use App\Models\StudentRegistrationModel;
use App\Models\TeacherModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class AttendanceReportController extends Controller
{
    public function by_student(Request $request)
    {
        $this->authorize('attendance_report', 95);
        $student_info = $student_reg_info = $from_date = $to_date = $student_id = $flag = null;
        $attendance_records = collect();

        try {
            if ($request->student_id != null && $request->from_date != null && $request->to_date != null) {
                $flag = 1;
                $student_id = $request->student_id;
                $from_date = $request->from_date;
                $to_date = $request->to_date;
                $student_info = Student::where('student_id', $student_id)->first();
                if(!$student_info){
                    return redirect()->back()->with('error', 'Student information not found');
                }
                $student_reg_info = StudentRegistrationModel::current_session_student($student_id);
                //For manual attendance
                //$attendance_records = StudentAttendanceModel::where('student_id',$student_id)->whereBetween('date', [$from_date, $to_date])->get();
                #for automatic device
                $attendance_records = AttendanceModel::where('user_id',$student_id)->whereBetween('date', [$from_date, $to_date])->get();
            }
            $header_title = 'Attendance Report';
            return view('admin.attendance_report.by_student', compact('from_date','to_date','flag', 'header_title','student_info','student_reg_info','student_id','attendance_records'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
    public function by_employee(Request $request)
    {
        $this->authorize('attendance_report', 95);

        $employee_info = $from_date = $to_date = $employee_id = $flag = null;
        $attendance_records = collect();

        try {
            if ($request->employee_id != null && $request->from_date != null && $request->to_date != null) {
                $flag = 1;
                $employee_id = $request->employee_id;
                $from_date = $request->from_date;
                $to_date = $request->to_date;
                $employee_info = TeacherModel::where('employee_id', $employee_id)->first();
                if(!$employee_info){
                    return redirect()->back()->with('error', 'Employee information not found');
                }
                //For manual attendance
                //$attendance_records = EmployeeAttendanceModel::where('employee_id',$employee_id)->whereBetween('date', [$from_date, $to_date])->get();
                #for automatic device
                $attendance_records = AttendanceModel::where('user_id',$employee_id)->whereBetween('date', [$from_date, $to_date])->get();
            }
            $header_title = 'Attendance Report';
            return view('admin.attendance_report.by_employee', compact('from_date','to_date','flag', 'header_title','employee_info','employee_id','attendance_records'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
    public function by_employee_pdf(Request $request)
    {
        $this->authorize('attendance_report', 95);

        $flag = $date = $type = null;
        $new_entry = 1;
        $record_list = $employee_list = collect();
        $auth_user = Auth::user();
        try {
            if ($request->date != null && $request->type != null) {
                $flag = 1;
                $date = $request->date;
                $type = $request->type;
                $record_list = EmployeeAttendanceModel::where('date', $date)->get();
                $employee_list = TeacherModel::where('status',0)->where('type',$type)->get();
                if($record_list->count() > 0){
                    $new_entry = null;
                }
            }
            $header_title = 'Employee Attendance';
            return view('admin.employee_attendance.index', compact('record_list','new_entry','type','date','employee_list','flag', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
}
