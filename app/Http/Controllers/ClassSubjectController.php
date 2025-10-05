<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\AssignTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\MarksModel;
use App\Models\SessionModel;
use App\Models\SubjectModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ClassSubjectController extends Controller
{
    public function index(Request $request)
    {
        #checking permission
        $this->authorize('assign_subject', 29);

        $flag = 0;
        $class_id = $session_id = $total_subject = "";
        $assigned_subject_list = collect();
        if ($request->session_id != null && $request->class_id != null) {
            $class_id = $request->class_id;
            $session_id = $request->session_id;
            $total_subject = ClassSubjectModel::where('class_id', $class_id)->where('session_id', $session_id)->count();
            $assigned_subject_list = ClassSubjectModel::where('class_id', $class_id)->where('session_id', $session_id)->get();
            $flag = 1;
        }
        try {
            #getting subject list
            $subject_list = SubjectModel::getActiveSubjects();
            $class_list = ClassModel::getActiveClasses();
            $session_list = SessionModel::getActiveSessions();
            $header_title = 'Assign Subject';
            return view('admin.assign_subject.index', compact('assigned_subject_list','total_subject', 'flag', 'class_id', 'session_id', 'class_list', 'session_list', 'subject_list', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        #checking permission
        $this->authorize('assign_subject', 29);

        $class_id = Helper::encrypt_decrypt('decrypt', $request->class_id);
        $session_id = Helper::encrypt_decrypt('decrypt', $request->session_id);
        $selected_subjects = $request->subjects;
        $class_info = ClassModel::where('id', $class_id)->first();
        $session_info = SessionModel::where('id', $session_id)->first();
        if (!$class_info) {
            return redirect()->back()->with('error', 'Class information not found');
        } else if (!$session_info) {
            return redirect()->back()->with('error', 'Session information not found');
        } else if (!$selected_subjects) {
            return redirect()->back()->with('error', 'No subjects found');
        }
        $class_name = $class_info->name;

        try {
            DB::transaction(function () use ($class_id, $session_id, $selected_subjects, $class_name) {
                foreach ($selected_subjects as $i) {
                    $save = new ClassSubjectModel();
                    $save->class_id = $class_id;
                    $save->session_id = $session_id;
                    $save->subject_id = $i;
                    $save->created_by = Auth::user()->user_id;
                    $save->save();
                }
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Assign subject updated for class#' . trim($class_name) . ' and session #' . SessionModel::getName($session_id));
            });
            return redirect()->back()->with('success', 'Assign subject updated successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function delete(Request $request)
    {
        #checking permission
        $this->authorize('assign_subject', 29);
        $id = Helper::encrypt_decrypt('decrypt',$request->id);

        if($id != null && $id > 0) {
            $assign_subject_info = ClassSubjectModel::where('id', $id)->first();
            if(!$assign_subject_info) {
                return redirect()->back()->with('error', 'Assign subject information not found');
            }
            $class_id = $assign_subject_info->class_id;
            $session_id = $assign_subject_info->session_id;
            $subject_id = $assign_subject_info->subject_id;
            $marks_info = MarksModel::where('class_id', $class_id)->where('session_id', $session_id)->where('subject_id', $subject_id)->exists();
            $assign_teacher_info = AssignTeacherModel::where('class_id', $class_id)->where('session_id',$session_id)->where('subject_id',$subject_id)->exists();

            if($marks_info || $assign_teacher_info){
                return redirect()->back()->with('error','Assigned subject already in use, You are not delete it');
            }
            try {
                DB::transaction(function () use ($id, $assign_subject_info) {
                    $class_name = $assign_subject_info->class_info->name ?? '';
                    $session_name = $assign_subject_info->session_info->name ?? '';
                    ClassSubjectModel::destroy($id);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Assign subject deleted for class #' . trim($class_name) . ' and Session #' . $session_name);
                });
                return redirect()->back()->with('success', 'Assign subject deleted successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        }
        else{
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
}
