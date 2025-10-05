<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\ClassModel;
use App\Models\ClassTeacherModel;
use App\Models\MonthsModel;
use App\Models\SchoolInfoModel;
use App\Models\SessionModel;
use App\Models\StudentAttendanceModel;
use App\Models\StudentRegistrationModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class StudentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('student_attendance', 86);
        $class_id = $session_id = $flag = $month_id = null;
        $record_list = collect();
        $auth_user = Auth::user();
        try {
            if ($request->month_id != null && $request->class_id != null && $request->session_id != null && is_numeric($request->class_id) && is_numeric($request->session_id)) {
                $flag = 1;
                $class_id = $request->class_id;
                $session_id = $request->session_id;
                $month_id = $request->month_id;
                $assign_teacher_info = ClassTeacherModel::where('employee_id',$auth_user->user_id)->where('class_id',$class_id)->where('session_id',$session_id)->first();
                if($assign_teacher_info == null){
                    return redirect(route('atmgt/student'))->with('error','You are not assigned to this class');
                }
                $record_list = StudentAttendanceModel::where('class_id', $class_id)
                    ->where('session_id', $session_id)
                    ->whereMonth('date', $month_id)
                    ->selectRaw('date,
                                    SUM(CASE WHEN status = "P" THEN 1 ELSE 0 END) as present,
                                    SUM(CASE WHEN status = "A" THEN 1 ELSE 0 END) as absent')
                    ->groupBy('date')
                    ->get();
            }
            $session_list = ClassTeacherModel::where('employee_id', $auth_user->user_id)->distinct()->get(['session_id']);
            $class_list = ClassTeacherModel::where('employee_id', $auth_user->user_id)->get(['class_id']);
            $month_list = MonthsModel::all();
            $header_title = 'Student Attendance';
            return view('admin.student_attendance.index', compact('record_list','month_id','month_list','flag','session_list', 'class_list', 'header_title', 'session_id', 'class_id'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function entry(Request $request)
    {
        $this->authorize('student_attendance', 86);

        if ($request->month_id !=null && $request->class_id != null && $request->session_id != null && is_numeric($request->class_id) && is_numeric($request->session_id)) {
            $session_id = $request->session_id;
            $class_id = $request->class_id;
            $month_id = $request->month_id;
            $session_name = SessionModel::getName($session_id);
            $class_name = ClassModel::getName($class_id);
            $student_list = StudentRegistrationModel::where('class_id', $class_id)->where('session_id', $session_id)->get();
            $header_title = 'Attendance Entry';
            return view('admin.student_attendance.new_entry', compact('session_id','month_id', 'class_id', 'student_list', 'class_name', 'session_name', 'header_title'));
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function store(Request $request)
    {
        $this->authorize('student_attendance', 86);

        $class_id = Helper::encrypt_decrypt('decrypt', $request->class_id);
        $session_id = Helper::encrypt_decrypt('decrypt', $request->session_id);
        $month_id = Helper::encrypt_decrypt('decrypt', $request->month_id);
        if ($request->date != null && is_numeric($class_id) && is_numeric($session_id) && $class_id > 0 && $session_id > 0 && $month_id > 0) {
            $date = $request->date;
            $student_attendance = $request->status;

            if(StudentAttendanceModel::where('date',$date)->where('session_id',$session_id)->where('class_id',$class_id)->exists()){
                return redirect()->back()->with('error', 'Attendance already exists for date ' . $date)->withInput();
            }
            try {
                DB::transaction(function () use ($request, $class_id, $session_id, $date, $student_attendance) {
                    foreach ($student_attendance as $student_id => $status) {
                        StudentAttendanceModel::insert([
                            'date' => $date,
                            'student_id' => $student_id,
                            'status' => $status,
                            'class_id' => $class_id,
                            'session_id' => $session_id,
                            'created_by' => Auth::user()->user_id,
                        ]);
                    }
                    Helper::store_activity(Auth::user()->user_id, 'Attendance Records saved successfully for class #' . ClassModel::getName($class_id) . ' and session #' . SessionModel::getName($session_id). ' and date #' . $date);
                });
                return redirect()->route('atmgt/student', [
                    'class_id' => $class_id,
                    'session_id' => $session_id,
                    'month_id' => $month_id
                ])->with('success', 'Attendance records saved successfully');
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

        $class_id = Helper::encrypt_decrypt('decrypt', $request->class_id);
        $session_id = Helper::encrypt_decrypt('decrypt', $request->session_id);
        $month_id = Helper::encrypt_decrypt('decrypt', $request->month_id);
        $previous_date = Helper::encrypt_decrypt('decrypt',$request->previous_date);
        if ($request->date != null && $previous_date != null && is_numeric($class_id) && is_numeric($session_id) && $class_id > 0 && $session_id > 0 && $month_id > 0) {
            $date = $request->date;
            $student_attendance = $request->status;

            if($date != $previous_date && StudentAttendanceModel::where('date',$date)->where('session_id',$session_id)->where('class_id',$class_id)->exists()){
                return redirect()->back()->with('error', 'Attendance already exists for date ' . $date);
            }
            try {
                DB::transaction(function () use ($request, $class_id, $session_id,$previous_date, $date, $student_attendance) {
                    foreach ($student_attendance as $student_id => $status) {
                        $attendance_info = StudentAttendanceModel::where('student_id',$student_id)
                                                ->where('class_id',$class_id)
                                                ->where('session_id',$session_id)
                                                ->where('date',$previous_date)->first();
                        if($attendance_info){
                            $attendance_info->status = $status;
                            $attendance_info->date = $date;
                            $attendance_info->updated_by = Auth::user()->user_id;
                            $attendance_info->save();
                        }
                        else{
                            StudentAttendanceModel::insert([
                                'date' => $date,
                                'student_id' => $student_id,
                                'status' => $status,
                                'class_id' => $class_id,
                                'session_id' => $session_id,
                                'created_by' => Auth::user()->user_id,
                            ]);
                        }
                    }
                    Helper::store_activity(Auth::user()->user_id, 'Attendance Records updated successfully for class #' . ClassModel::getName($class_id) . ' and session #' . SessionModel::getName($session_id). ' and date #' . $date);
                });
                return redirect()->route('atmgt/student', [
                    'class_id' => $class_id,
                    'session_id' => $session_id,
                    'month_id' => $month_id
                ])->with('success', 'Attendance records updated successfully');
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

        $class_id = $request->class_id;
        $session_id = $request->session_id;
        if ($request->date != null && $request->month_id != null && is_numeric($class_id) && is_numeric($session_id) && $class_id > 0 && $session_id > 0) {
            $date = $request->date;
            $month_id = $request->month_id;
            try {
                DB::transaction(function () use ($request, $class_id, $session_id, $date) {
                    StudentAttendanceModel::where('class_id',$class_id)->where('session_id',$session_id)
                        ->where('date',$date)->delete();
                    Helper::store_activity(Auth::user()->user_id, 'Attendance Records deleted successfully for class #' . ClassModel::getName($class_id) . ' and session #' . SessionModel::getName($session_id) . ' and date #' . $date);
                });
                return redirect()->route('atmgt/student', [
                    'class_id' => $class_id,
                    'session_id' => $session_id,
                    'month_id' => $month_id
                ])->with('success', 'Attendance records deleted successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function attendance_sheet(Request $request)
    {
        $this->authorize('student_attendance', 86);

        try {
            $auth_user = Auth::user();
            $session_list = ClassTeacherModel::where('employee_id', $auth_user->user_id)->get(['session_id']);
            $class_list = ClassTeacherModel::where('employee_id', $auth_user->user_id)->get(['class_id']);
            $month_list = MonthsModel::all();
            $header_title = 'Attendance Sheet';
            return view('admin.student_attendance.attendance_sheet', compact('month_list', 'session_list', 'class_list', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function print(Request $request)
    {
        $this->authorize('student_attendance', 86);

        if ($request->has(['session_id','class_id','month']) && is_numeric($request->class_id) && is_numeric($request->session_id)) {
            $session_id = $request->session_id;
            $class_id = $request->class_id;
            $month = $request->month;
            $student_list = StudentRegistrationModel::where('class_id', $class_id)->where('session_id', $session_id)->get();
            $pdf = PDF::loadView('admin.student_attendance.attendance_pdf', [
                'student_list' => $student_list,
                'class_name' => ClassModel::getName($class_id),
                'school_info' => SchoolInfoModel::first(),
                'month' => MonthsModel::getName($month),
                'attendance_list' => StudentAttendanceModel::where('class_id', $class_id)->where('session_id', $session_id)->whereMonth('date',$month)->groupBy('date')->get(),
                'session_name' => SessionModel::getName($session_id),
            ])->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
            return $pdf->stream();
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
}
