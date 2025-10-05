<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AssignExamModel;
use App\Models\AssignTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamModel;
use App\Models\MarksModel;
use App\Models\SessionModel;
use App\Models\StudentRegistrationModel;
use App\Models\SubjectModel;
use App\Models\TeacherModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageMarksController extends Controller
{
    public function index(Request $request)
    {
        #checking permission
        $this->authorize('manage_marks', 28);
        try {
            #getting exam list
            $class_list = ClassModel::getActiveClasses();
            $session_list = SessionModel::getActiveSessions();
            $exam_list = ExamModel::getActiveExams();
            $header_title = 'Manage Marks';
            $class_id = $session_id = $exam_id = $flag = "";
            return view('admin.manage_marks.index', compact('flag', 'exam_id','exam_list', 'class_id', 'session_id', 'class_list', 'session_list', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function search(Request $request)
    {
        #checking permission
        $this->authorize('manage_marks', 28);
        if (is_numeric($request->class_id) && is_numeric($request->session_id) && is_numeric($request->exam_id) && $request->class_id > 0 && $request->exam_id && $request->session_id > 0) {
            $class_id = $request->class_id;
            $session_id = $request->session_id;
            $exam_id = $request->exam_id;
            $flag = 1;
            try {
                $assign_exam_info = AssignExamModel::where('class_id', $class_id)->where('session_id', $session_id)->first();
                if ($assign_exam_info == null) {
                    return redirect()->back()->with('error', 'Exam not assigned');
                }
                $class_list = ClassModel::getActiveClasses();
                $session_list = SessionModel::getActiveSessions();
                $exam_list = ExamModel::getActiveExams();
                $assign_subject_list = ClassSubjectModel::where('class_id', $class_id)->where('session_id', $session_id)->get();
                $header_title = 'Manage Marks';
                return view('admin.manage_marks.index', compact('flag', 'assign_subject_list','exam_list', 'session_id', 'class_id', 'session_id', 'exam_id', 'class_list', 'session_list', 'header_title'));
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function publish(Request $request)
    {
        #checking permission
        $this->authorize('manage_marks', 28);
        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if (is_numeric($id) && $id > 0) {
            $assign_teacher_info = AssignTeacherModel::where('id', $id)->first();
            if ($assign_teacher_info == "") {
                return redirect()->back()->with('error', 'Assign teacher information not found');
            }
            $subject_name = $assign_teacher_info->subject_info->name;
            try {
                DB::transaction(function () use ($id, $subject_name, $assign_teacher_info) {
                    AssignTeacherModel::where('id', $id)->update([
                        'is_published' => 1,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    MarksModel::where('class_id', $assign_teacher_info->class_id)
                        ->where('subject_id', $assign_teacher_info->subject_id)
                        ->where('exam_id', $assign_teacher_info->exam_id)
                        ->where('session_id', $assign_teacher_info->session_id)
                        ->update([
                            'is_published' => 1,
                        ]);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Mark published for subject #' . trim($subject_name));
                });
                return redirect()->back()->with('success', 'Mark successfully published');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function unpublish(Request $request)
    {
        #checking permission
        $this->authorize('manage_marks', 28);
        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if (is_numeric($id) && $id > 0) {
            $assign_teacher_info = AssignTeacherModel::where('id', $id)->first();
            if ($assign_teacher_info == "") {
                return redirect()->back()->with('error', 'Assign teacher information not found');
            }
            $subject_name = $assign_teacher_info->subject_info->name ?? '';
            try {
                DB::transaction(function () use ($id, $subject_name, $assign_teacher_info) {
                    AssignTeacherModel::where('id', $id)->update([
                        'is_published' => 0,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    MarksModel::where('class_id', $assign_teacher_info->class_id)
                        ->where('subject_id', $assign_teacher_info->subject_id)
                        ->where('exam_id', $assign_teacher_info->exam_id)
                        ->where('session_id', $assign_teacher_info->session_id)
                        ->update([
                            'is_published' => 0,
                        ]);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Mark unpublished for subject #' . trim($subject_name));
                });
                return redirect()->back()->with('success', 'Mark successfully unpublished');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function lock(Request $request)
    {
        #checking permission
        $this->authorize('manage_marks', 28);
        $id = Helper::encrypt_decrypt('decrypt', $request->id);

        if (is_numeric($id) && $id > 0) {
            $assign_teacher_info = AssignTeacherModel::where('id', $id)->first();
            if ($assign_teacher_info == "") {
                return redirect()->back()->with('error', 'Assign teacher information not found');
            }
            $subject_name = $assign_teacher_info->subject_info->name;
            try {
                DB::transaction(function () use ($id, $subject_name) {
                    AssignTeacherModel::where('id', $id)->update([
                        'is_mark_locked' => 1,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Mark locked for subject #' . trim($subject_name));
                });
                return redirect()->back()->with('success', 'Mark successfully locked');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function unlock(Request $request)
    {
        #checking permission
        $this->authorize('manage_marks', 28);
        $id = Helper::encrypt_decrypt('decrypt', $request->id);

        if (is_numeric($id) && $id > 0) {
            $assign_teacher_info = AssignTeacherModel::where('id', $id)->first();
            if ($assign_teacher_info == "") {
                return redirect()->back()->with('error', 'Assign teacher information not found');
            }
            $subject_name = $assign_teacher_info->subject_info->name;
            try {
                DB::transaction(function () use ($id, $subject_name) {
                    AssignTeacherModel::where('id', $id)->update([
                        'is_mark_locked' => 0,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Mark unlocked for subject #' . trim($subject_name));
                });
                return redirect()->back()->with('success', 'Mark successfully unlocked');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function review_marks_entry(Request $request) {
        $this->authorize('manage_marks', 28);
        $id = Helper::encrypt_decrypt('decrypt',$request->at);
        if(is_numeric($id) && $id > 0) {
            $assign_info = AssignTeacherModel::where('id', $id)->first();
            if($assign_info == null){
                return redirect()->back()->with('error', 'Assign teacher information not found');
            }
            $session_id = $assign_info->session_id;
            $class_id = $assign_info->class_id;
            $exam_id = $assign_info->exam_id;
            $subject_id = $assign_info->subject_id;
            $teacher_id = $assign_info->teacher_id_primary;

            $teacher_info = TeacherModel::where('id', $teacher_id)->first();
            if($teacher_info == null){
                return redirect()->back()->with('error', 'Teacher information not found');
            }
            $header_title = 'Review Mark Entry';
            try {
                $getStudent = StudentRegistrationModel::where('class_id', $class_id)
                    ->where('session_id', $session_id)
                    ->where('status', 0)
                    ->orderBy('roll_no')
                    ->get();

                $exam_name = ExamModel::getName($exam_id);
                $session_name = SessionModel::getName($session_id);
                $subject_name = SubjectModel::getName($subject_id);
                $class_name = ClassModel::getName($class_id);

                # Retrieving marks, grade points, and letter grades
                $Marks = MarksModel::where('class_id', $class_id)
                    ->where('subject_id', $subject_id)
                    ->where('session_id', $session_id)
                    ->where('exam_id', $exam_id)
                    ->get();

                $StudentMark = [];
                $GradePoint = [];
                $LetterGrade = [];
                foreach ($Marks as $mark) {
                    $StudentMark[$mark->student_id] = $mark->mark;
                    $GradePoint[$mark->student_id] = $mark->grade_point;
                    $LetterGrade[$mark->student_id] = $mark->letter_grade;
                }
                return view('admin.manage_marks.review_marks', compact('getStudent', 'session_id', 'header_title', 'class_id', 'subject_id', 'exam_id', 'exam_name', 'session_name', 'subject_name', 'class_name', 'StudentMark', 'GradePoint', 'LetterGrade', 'teacher_info'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred. Please try again.' . $e->getMessage());
            }
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }

    public function review_marks_entry_update(Request $request) {
        # Check permission
        $this->authorize('manage_marks', 28);

        $exam_id = Helper::encrypt_decrypt('decrypt', $request->exam_id);
        $session_id = Helper::encrypt_decrypt('decrypt', $request->session_id);
        $class_id = Helper::encrypt_decrypt('decrypt', $request->class_id);
        $subject_id = Helper::encrypt_decrypt('decrypt', $request->subject_id);
        $marks = $request->marks ?? [];
        $grades = config('grades');
        $exam_name = ExamModel::getName($exam_id);
        $session_name = SessionModel::getName($session_id);
        $subject_name = SubjectModel::getName($subject_id);
        $class_name = ClassModel::getName($class_id);
        if($exam_name && $session_name && $subject_name && $class_name && $marks) {
            $getStudent = StudentRegistrationModel::where('class_id', $class_id)
                ->where('session_id', $session_id)
                ->where('status', 0)
                ->orderBy('roll_no')
                ->get();

            if(count($getStudent) == 0 || count($marks) == 0){
                return redirect()->back()->with('error', 'No student information found');
            }

            if ($getStudent->count() !== count($marks)) {
                return redirect()->back()->with('error', 'Something went wrong');
            }

            try {
                DB::transaction(function () use ($marks, $grades, $exam_id, $session_id, $class_id, $subject_id) {
                    foreach ($marks as $studentId => $mark) {
                        $student_reg_info = StudentRegistrationModel::where('student_id', $studentId)->where('session_id', $session_id)->first();
                        $grade_point = $letter_grade = null;
                        foreach ($grades as $grade) {
                            if ($mark != null && $mark >= $grade['start_range'] && $mark <= $grade['end_range']) {
                                $grade_point = $grade['point'];
                                $letter_grade = $grade['letter_grade'];
                                break;
                            }
                        }
                        if ($student_reg_info == null){
                            continue;
                        }
                        # Check if the mark entry exists
                        $existingMark = MarksModel::where('student_id', $studentId)
                            ->where('exam_id', $exam_id)
                            ->where('session_id', $session_id)
                            ->where('subject_id', $subject_id)
                            ->first();

                        if ($existingMark) {
                            $existingMark->update([
                                'mark' => $mark,
                                'class_id' => $class_id,
                                'grade_point' => $grade_point,
                                'letter_grade' => $letter_grade,
                                'updated_by' => Auth::user()->user_id,
                            ]);
                        } else {
                            MarksModel::create([
                                'std_id' => $student_reg_info->std_id,
                                'std_reg_id' => $student_reg_info->id,
                                'exam_id' => $exam_id,
                                'session_id' => $session_id,
                                'subject_id' => $subject_id,
                                'mark' => $mark,
                                'class_id' => $class_id,
                                'student_id' => $student_reg_info->student_id,
                                'created_by' => Auth::user()->user_id,
                                'grade_point' => $grade_point,
                                'letter_grade' => $letter_grade,
                            ]);
                        }
                    }
                });
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Mark inserted from review mark for subject #' . $subject_name . ' Session #' . $session_name . ' and Exam #' . $exam_name . ' and Class #' . $class_name);
                return redirect()->back()->with('success', 'Marks updated successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Process failed: ' . $e->getMessage());
            }
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }
    public function find_exam(Request $request){
        $class_id = $request->class_id;
        $session_id = $request->session_id;

        $exam_list = AssignExamModel::with('exam_info')->where('session_id',$session_id)->where('class_id',$class_id)->get();
        return response()->json($exam_list);
    }
}
