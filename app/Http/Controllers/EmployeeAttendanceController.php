<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AssignTeacherModel;
use App\Models\AttendanceModel;
use App\Models\ClassModel;
use App\Models\ClassTeacherModel;
use App\Models\EmployeeAttendanceModel;
use App\Models\MonthsModel;
use App\Models\SchoolInfoModel;
use App\Models\SessionModel;
use App\Models\StudentAttendanceModel;
use App\Models\StudentRegistrationModel;
use App\Models\TeacherModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class EmployeeAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('student_attendance', 86);
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

    public function store(Request $request)
    {
        $this->authorize('student_attendance', 86);
        $date = Helper::encrypt_decrypt('decrypt', $request->date);
        if ($date != null) {
            $employee_attendance = $request->status;
            if(EmployeeAttendanceModel::where('date',$date)->exists()){
                return redirect()->back()->with('error', 'Attendance already exists for date ' . $date);
            }
            try {
                DB::transaction(function () use ($request,$date, $employee_attendance) {
                    foreach ($employee_attendance as $employee_id => $status) {
                        EmployeeAttendanceModel::insert([
                            'date' => $date,
                            'employee_id' => $employee_id,
                            'status' => $status,
                            'created_by' => Auth::user()->user_id,
                        ]);
                    }
                    Helper::store_activity(Auth::user()->user_id, 'Attendance Records saved successfully for employee date #'. $date);
                });
                return redirect(route('atmgt/employee'))->with('success', 'Attendance records saved successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function edit(Request $request)
    {
        $this->authorize('student_attendance', 86);

        if ($request->month_id !=null && $request->class_id != null && $request->session_id != null && is_numeric($request->class_id) && is_numeric($request->session_id) && $request->date != null) {
            $session_id = $request->session_id;
            $class_id = $request->class_id;
            $date = $request->date;
            $month_id = $request->month_id;
            $attendance_info = StudentAttendanceModel::where('class_id',$class_id)->where('session_id',$session_id)->where('date',$date)->first();
            if ($attendance_info == null){
                return redirect()->back()->with('error','Attendance records not found');
            }
            $session_name = SessionModel::getName($session_id);
            $class_name = ClassModel::getName($class_id);
            $student_list = StudentRegistrationModel::where('class_id', $class_id)->where('session_id', $session_id)->get();
            $status = [];
            $attendance_list = StudentAttendanceModel::where('date',$date)->where('class_id',$class_id)->where('session_id',$session_id)->get();
            foreach ($attendance_list as $attendance) {
                $status[$attendance->student_id] = $attendance->status;
            }
            $header_title = 'Attendance Edit';
            return view('admin.student_attendance.edit', compact('date','month_id','status','session_id', 'class_id', 'student_list', 'class_name', 'session_name', 'header_title'));
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function update(Request $request)
    {
        $this->authorize('student_attendance', 86);

        $date = Helper::encrypt_decrypt('decrypt', $request->date);
        if ($date != null) {
            $employee_attendance = $request->status;

            try {
                DB::transaction(function () use ($request,$date, $employee_attendance) {
                    foreach ($employee_attendance as $id => $status) {
                        EmployeeAttendanceModel::where('id',$id)->update([
                            'date' => $date,
                            'status' => $status,
                            'updated_by' => Auth::user()->user_id,
                        ]);
                    }
                    Helper::store_activity(Auth::user()->user_id, 'Attendance Records updated successfully for employee date #'. $date);
                });
                return redirect(route('atmgt/employee'))->with('success', 'Attendance records updated successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
    public function delete(Request $request)
    {
        $this->authorize('student_attendance', 86);
        $date = Helper::encrypt_decrypt('decrypt', $request->date);

        if ($date != null) {
            try {
                DB::transaction(function () use ($request, $date) {
                    EmployeeAttendanceModel::where('date', $date)->delete();
                    Helper::store_activity(Auth::user()->user_id, 'Attendance Records delete successfully for employee date #' . $date);
                });
                return redirect(route('atmgt/employee'))->with('success', 'Attendance records deleted successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
}
