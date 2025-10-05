<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassTeacherModel;
use App\Models\SessionModel;
use App\Models\TeacherModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassTeacherController extends Controller
{
    public function index(Request $request)
    {

        #checking permission
        $this->authorize('class_teacher', 83);

        $flag = 0;
        $class_id = $session_id = $ct[] = "";
        try {
            if ($request->session_id != null) {
                $session_id = $request->session_id;

                $class_teacher = ClassTeacherModel::where('session_id', $session_id)->get();
                foreach ($class_teacher as $i){
                    $ct[$i->class_id] = $i->employee_id;
                }
                $flag = 1;
            }
            $session_list = SessionModel::getActiveSessions();
            $class_list = ClassModel::getActiveClasses();
            $teacher_list = TeacherModel::getActiveTeachers();
            $header_title = 'Class Teacher';
            return view('admin.class_teacher.index', compact('ct','class_list','teacher_list','flag', 'class_id', 'session_id','session_list','header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }

    }

    public function update(Request $request)
    {
        $this->authorize('assign_subject', 29);
        try {
            $session_id = $request->session_id;
            DB::transaction(function () use ($request,$session_id) {
                $class_teacher = $request->class_teacher;
                foreach ($class_teacher as $class_id=>$teacher_id)
                    if(ClassTeacherModel::where('session_id',$session_id)->where('class_id',$class_id)->exists()){
                        ClassTeacherModel::where('session_id',$session_id)->where('class_id', $class_id)->update([
                            'employee_id' => $teacher_id,
                            'updated_by' => Auth::user()->user_id,
                        ]);
                    }
                    else{
                        ClassTeacherModel::insert([
                            'class_id' => $class_id,
                            'session_id' => $session_id,
                            'employee_id' => $teacher_id,
                            'created_by' => Auth::user()->user_id,
                        ]);
                    }

                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Class teacher updated for session #' . SessionModel::getName($session_id));
            });
            return redirect()->back()->with('success', 'Class teacher updated successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
}
