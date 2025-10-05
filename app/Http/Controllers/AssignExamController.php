<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\AssignExamModel;
use App\Models\AssignTeacherModel;
use App\Models\ClassModel;
use App\Models\ExamModel;
use App\Models\MarksModel;
use App\Models\SessionModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AssignExamController extends Controller
{
    public function index(Request $request) {
        #checking permission
        $this->authorize('assign_exam',30);

        $flag = 0;$class_id = $session_id = $total_exam="";
        $assigned_exam_list = collect();
        if(isset($request->session_id) && isset($request->class_id)){
            $class_id = $request->class_id;
            $session_id = $request->session_id;
            $assigned_exam_list = AssignExamModel::where('class_id',$class_id)->where('session_id',$session_id)->get();
            $total_exam = AssignExamModel::where('class_id',$class_id)->where('session_id',$session_id)->count();
            $flag = 1;
        }
        try {
            #getting exam list
            $exam_list = ExamModel::getActiveExams();
            $class_list = ClassModel::getActiveClasses();
            $session_list = SessionModel::getActiveSessions();
            $header_title = 'Assign Exam';
            return view('admin.assign_exam.index', compact('assigned_exam_list','total_exam','flag','class_id','session_id','class_list','session_list','exam_list','header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function update(Request $request) {
        #checking permission
        $this->authorize('assign_exam', 30);

        $class_id = Helper::encrypt_decrypt('decrypt', $request->class_id);
        $session_id = Helper::encrypt_decrypt('decrypt', $request->session_id);
        $selected_exams = $request->exams;
        $class_info = ClassModel::where('id',$class_id)->first();
        $session_info = SessionModel::where('id',$session_id)->first();
        if($class_info == null){
            return redirect()->back()->with('error','Class information not found');
        }
        else if($session_info == null){
            return redirect()->back()->with('error','Session information not found');
        }
        else if($selected_exams == null){
            return redirect()->back()->with('error','No exam found');
        }
        $class_name = $class_info->name;
        $session_name = $session_info->name;

        try {
            DB::transaction(function () use ($class_id, $session_id, $selected_exams,$class_name, $session_name) {
                foreach($selected_exams as $i){
                    $save = new AssignExamModel();
                    $save->class_id = $class_id;
                    $save->session_id = $session_id;
                    $save->exam_id = $i;
                    $save->created_by = Auth::user()->user_id;
                    $save->save();
                }
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Assign exam updated for class #' . trim($class_name) . ' and session #' . trim($session_name));
            });
            return redirect()->back()->with('success', 'Assign exam updated successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function delete(Request $request) {
        #checking permission
        $this->authorize('assign_exam', 30);

        $id = Helper::encrypt_decrypt('decrypt',$request->id);

        if($id && $id > 0) {
            $assign_exam_info = AssignExamModel::where('id',$id)->first();
            if($assign_exam_info == null){
                return redirect()->back()->with('error','Assign exam information not found');
            }
            $class_name = $assign_exam_info->class_info->name ?? '';
            $session_name = $assign_exam_info->session_info->name ?? '';
            $class_id = $assign_exam_info->class_id;
            $session_id = $assign_exam_info->session_id;
            $exam_id = $assign_exam_info->exam_id;
            $marks_info = MarksModel::where('exam_id',$exam_id)->where('session_id',$session_id)->where('class_id',$class_id)->exists();
            $assign_teacher_info = AssignTeacherModel::where('exam_id',$exam_id)->where('session_id',$session_id)->where('class_id',$class_id)->exists();
            if($marks_info || $assign_teacher_info){
                return redirect()->back()->with('error','Assigned exam already in use, you can not delete it');
            }
            try {
                DB::transaction(function () use ($id, $class_name, $session_name) {
                    AssignExamModel::destroy($id);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Assign exam deleted for class #' . trim($class_name) . ' and session #' . trim($session_name));
                });
                return redirect()->back()->with('success', 'Assign exam deleted successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }
}
