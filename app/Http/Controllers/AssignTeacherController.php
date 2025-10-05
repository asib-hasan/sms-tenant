<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\AssignExamModel;
use App\Models\AssignTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamModel;
use App\Models\MarksModel;
use App\Models\SessionModel;
use App\Models\SubjectModel;
use App\Models\TeacherModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AssignTeacherController extends Controller
{
    public function index(Request $request) {
        #checking permission
        $this->authorize('assign_teacher', 31);
        $flag = 0;$class_id = $session_id = $teacher_id = null;
        $assigned_subject_list = $assigned_exam_list = collect();
        if(isset($request->session_id) && isset($request->class_id)){
            $class_id = $request->class_id;
            $session_id = $request->session_id;
            $teacher_id = $request->teacher_id;
            $assigned_subject_list = ClassSubjectModel::where('session_id',$session_id)->where('class_id',$class_id)->get();
            $assigned_exam_list = AssignExamModel::where('class_id',$class_id)->where('session_id',$session_id)->orderBy('exam_id')->get();
            $flag = 1;
        }
        try {
            #getting information
            $class_list = ClassModel::getActiveClasses();
            $teacher_list = TeacherModel::getActiveTeachers();
            $session_list = SessionModel::getActiveSessions();
            $header_title = 'Assign Teacher';
            return view('admin.assign_teacher.index', compact('assigned_exam_list','assigned_subject_list','teacher_id','flag','class_id','teacher_list','session_id','class_list','session_list','header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function update(Request $request) {
        #checking permission
        $this->authorize('assign_teacher', 31);
        $class_id = Helper::encrypt_decrypt('decrypt', $request->class_id);
        $session_id = Helper::encrypt_decrypt('decrypt', $request->session_id);
        $exam_id = Helper::encrypt_decrypt('decrypt', $request->exam_id);
        $subject_id = Helper::encrypt_decrypt('decrypt', $request->subject_id);
        $teacher_id = $request->teacher_id;
        if($class_id && $session_id && $exam_id && $subject_id && ($teacher_id == 0 || $teacher_id)) {
            $class_info = ClassModel::where('id', $class_id)->first();
            $session_info = SessionModel::where('id', $session_id)->first();
            $subject_info = SubjectModel::where('id', $subject_id)->first();
            $exam_info = ExamModel::where('id', $exam_id)->first();
            $teacher_info = TeacherModel::where('id', $teacher_id)->first(['id','employee_id']);

            if ($class_info == null) {
                return redirect()->back()->with('error', 'Class information not found');
            } else if($exam_info == null) {
                return redirect()->back()->with('error', 'Exam information not found');
            } else if ($session_info == null) {
                return redirect()->back()->with('error', 'Session information not found');
            } else if ($teacher_id != 0 && $teacher_info == null) {
                return redirect()->back()->with('error', 'Teacher information not found');
            } else if ($subject_info == null) {
                return redirect()->back()->with('error', 'Subject information not found');
            }
            $assign_teacher_info = collect();
            $class_name = $class_info->name;
            $session_name = $session_info->name;
            $subject_name = $subject_info->name;
            $exam_name = $exam_info->name;

            $mark_info = MarksModel::where('session_id', $session_id)
                ->where('class_id', $class_id)
                ->where('subject_id', $subject_id)
                ->where('exam_id', $exam_id)
                ->first();
            if($teacher_id != 0) {
                $assign_teacher_info = AssignTeacherModel::where('session_id', $session_id)
                    ->where('class_id', $class_id)
                    ->where('subject_id', $subject_id)
                    ->where('exam_id', $exam_id)
                    ->first();
            }
            if ($mark_info) {
                return redirect()->back()->with('error', 'Teacher has already inserted marks, can not be modified or deleted');
            }
            try {
                DB::transaction(function () use ($assign_teacher_info,$class_name,$exam_name, $session_name, $subject_name ,$class_id,$teacher_info,$exam_id, $session_id, $subject_id, $teacher_id) {
                    if($teacher_id == 0){
                        AssignTeacherModel::where('session_id', $session_id)
                            ->where('class_id', $class_id)
                            ->where('subject_id', $subject_id)
                            ->where('exam_id', $exam_id)
                            ->delete();
                    }
                    else if($assign_teacher_info){
                        $assign_teacher_info->teacher_id_primary = $teacher_info->id;
                        $assign_teacher_info->teacher_user_id = $teacher_info->employee_id;
                        $assign_teacher_info->save();
                    }
                    else{
                        AssignTeacherModel::insert([
                            'class_id' => $class_id,
                            'session_id' => $session_id,
                            'subject_id' => $subject_id,
                            'teacher_id_primary' => $teacher_info->id,
                            'teacher_user_id' => $teacher_info->employee_id,
                            'exam_id' => $exam_id,
                            'created_by' => Auth::user()->user_id,
                        ]);
                    }
                    if($teacher_id == 0){
                        Helper::store_activity(Auth::user()->user_id, 'Assign teacher deleted for session # ' . $session_name . ' class #' . $class_name . ' subject #'  . $subject_name . ' exam #'  . $exam_name);
                    }
                    else{
                        Helper::store_activity(Auth::user()->user_id, 'Assign teacher updated for teacher#' . $teacher_info->employee_id . ' session # ' . $session_name . ' class #' . $class_name . ' subject #'  . $subject_name . ' exam #'  . $exam_name);
                    }
                });
                return redirect()->back()->with('success', 'Assign teacher updated successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }
}
