<?php

namespace App\Http\Controllers;

use App\Models\StudentRegistrationModel;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function session_wise_active_student(Request $request)
    {
        $session_id = $request->sessionId;
        $student_list = StudentRegistrationModel::with('student_info')->where('session_id', $session_id)->where('status', 0)->get();
        return response()->json($student_list);
    }

    public function session_wise_all_student(Request $request)
    {
        $session_id = $request->sessionId;
        $student_list = StudentRegistrationModel::with('student_info')
            ->where('session_id', $session_id)
            ->select('student_id', 'id')
            ->get();
        return response()->json($student_list);
    }
}







