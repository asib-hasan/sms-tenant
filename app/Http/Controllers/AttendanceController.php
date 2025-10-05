<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AttendanceBulkModel;
use App\Models\AttendanceModel;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    #For API
    public function store(Request $request)
    {
        $token = "mah&*#(@())!!";
        $apiToken = $request->header('X-API-TOKEN');
        if ($apiToken !== $token) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $attendanceData = $request->json()->all();

        foreach ($attendanceData as $entry) {
            $user_type = 1;
            if(strlen($entry['emp_code']) <= 6) {
                $user_type = 0;
            }
            if (!AttendanceBulkModel::where('punch_id', $entry['id'])->exists()) {
                $punchDate = Carbon::parse($entry['punch_time'])->toDateString();
                $punchTimeFormatted = Carbon::parse($entry['punch_time'])->format('H:i:s');
                $existingAttendance = AttendanceModel::where('user_id', $entry['emp_code'])->where('date', $punchDate)->first();

                if (!$existingAttendance) {
                    if($user_type == 1){
                        if($punchDate == date('Y-m-d')){
                            $student_info = Student::where('student_id', $entry['emp_code'])->first();
                            if($student_info && $student_info->mobile != null){
                                $msg = 'আপনার সন্তান(' . ($student_info->student_id) . ') ' . 'মাদ্রাসায় উপস্থিত হয়েছে। সময়ঃ ' . $punchTimeFormatted . '। করতৃপক্ষ - MAHPCM';
                                Helper::sms_send($msg, $student_info->mobile);
                            }
                        }
                    }
                    AttendanceModel::create([
                        'user_id' => $entry['emp_code'],
                        'user_type' => $user_type,
                        'date' => $punchDate,
                        'check_in' => $punchTimeFormatted,
                        'check_out' => null,
                    ]);
                } else {
                    $existingAttendance->update([
                        'check_out' => $punchTimeFormatted,
                    ]);
                }
                AttendanceBulkModel::create([
                    'user_id' => $entry['emp_code'],
                    'punch_id' => $entry['id'],
                    'user_type' => $user_type,
                    'punch_time' => $entry['punch_time'],
                ]);
            }
        }
        return response()->json(['message' => 'Attendance data received and processed successfully.'],201);
    }

    public function daily_summery_std(Request $request) {
        #checking permission
        $this->authorize('daily_summery', 81);
        try {
            $date = today()->format('Y-m-d');
            if($request->has('date') && $request->date != null){
                $date = $request->date;
            }
            $header_title = 'Daily Summery';
            $summery_list = AttendanceModel::where('date',$date)->where('user_type',1)->get();
            return view('admin.attendance_mgt.summery_std', compact('summery_list','date','header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
    public function daily_summery_emp(Request $request) {
        #checking permission
        $this->authorize('daily_summery', 81);
        try {
            $date = today()->format('Y-m-d');
            if($request->has('date') && $request->date!=""){
                $date = $request->date;
            }
            $header_title = 'Daily Summery';
            $summery_list = AttendanceModel::where('date',$date)->where('user_type',0)->get();
            return view('admin.attendance_mgt.summery_emp', compact('summery_list','header_title','date'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
}
