<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamModel;
use App\Models\FinalMarksModel;
use App\Models\SchoolInfoModel;
use App\Models\SessionModel;
use App\Models\MarksModel;
use App\Models\Student;
use App\Helpers;
use App\Helpers\Helper;
use App\Models\AssignTeacherModel;
use App\Models\StudentRegistrationModel;
use App\Models\SubjectModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
class MarksController extends Controller
{
    public function search_students() {
        #check permission
        $this->authorize('mark_entry', 48);

        try {
            # Gathering data
            $user_id = Auth::user()->user_id;
            $exam_list = AssignTeacherModel::where('teacher_user_id',$user_id)->select('exam_id')->distinct()->get();
            $class_list = AssignTeacherModel::where('teacher_user_id',$user_id)->select('class_id')->distinct()->get();
            $subject_list = AssignTeacherModel::where('teacher_user_id',$user_id)->select('subject_id')->distinct()->get();
            $session_list = AssignTeacherModel::where('teacher_user_id',$user_id)->select('session_id')->distinct()->get();
            $header_title = 'Mark Entry';

            # Returning the view with data
            return view('admin.examinations.search-students', compact('header_title','class_list', 'subject_list', 'exam_list', 'session_list'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong' . $e->getMessage());
        }
    }

    public function mark_entry_index(Request $request) {
        $this->authorize('mark_entry', 48);

        # Extracting request parameters
        $session_id = $request->session_id;
        $class_id = $request->class_id;
        $exam_id = $request->exam_id;
        $subject_id = $request->subject_id;
        $header_title = 'Mark Entry';

        # Check if the teacher is assigned
        $assign_info = AssignTeacherModel::where('session_id', $session_id)
            ->where('class_id', $class_id)
            ->where('exam_id', $exam_id)
            ->where('subject_id', $subject_id)
            ->where('teacher_user_id', Auth::user()->user_id)
            ->first();

        if (!$assign_info) {
            return redirect(route('rmgt/mark/entry/search'))->with('error', 'You are not assigned! Please try again');
        }

        try {
            $is_mark_locked = $assign_info->is_mark_locked;
            $getStudent = StudentRegistrationModel::where('class_id', $class_id)
                ->where('session_id', $session_id)
                ->where('status', 0)
                ->orderBy('roll_no')
                ->get();

            # Retrieving specific names for session, class, subject, and exam
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
            return view('admin.examinations.marks_entry', compact('getStudent', 'session_id', 'header_title', 'class_id', 'subject_id', 'exam_id', 'exam_name', 'session_name', 'subject_name', 'class_name', 'StudentMark', 'GradePoint', 'LetterGrade','is_mark_locked'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function mark_entry_apply(Request $request) {
        # Check permission
        $this->authorize('mark_entry', 48);

        $exam_id = Helper::encrypt_decrypt('decrypt', $request->exam_id);
        $session_id = Helper::encrypt_decrypt('decrypt', $request->session_id);
        $class_id = Helper::encrypt_decrypt('decrypt', $request->class_id);
        $subject_id = Helper::encrypt_decrypt('decrypt', $request->subject_id);
        $marks = $request->marks ?? [];
        $grades = config('grades');
        $subject_name = SubjectModel::where('id', $subject_id)->value('name');
        $class_name = ClassModel::where('id',$class_id)->value('name');
        $exam_name = ExamModel::where('id',$exam_id)->value('name');
        $session_name = SessionModel::where('id',$session_id)->value('name');
        $getStudent = StudentRegistrationModel::where('class_id', $class_id)
                             ->where('session_id',$session_id)
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
            DB::transaction(function() use ($marks, $grades, $exam_id, $session_id, $class_id, $subject_id) {
                foreach ($marks as $studentId => $mark) {
                    $student_reg_info = StudentRegistrationModel::where('student_id',$studentId)->where('session_id',$session_id)->first();
                    if ($student_reg_info == null){
                        continue;
                    }
                    $grade_point = $letter_grade = null;

                    foreach ($grades as $grade) {
                        if ($mark!=null && $mark >= $grade['start_range'] && $mark <= $grade['end_range']) {
                            $grade_point = $grade['point'];
                            $letter_grade = $grade['letter_grade'];
                            break;
                        }
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
            Helper::store_activity(Auth::user()->user_id, 'Mark inserted for subject #' . $subject_name . ' Session #'.$session_name . ' and Exam #' . $exam_name . ' and Class #' . $class_name);
            return redirect()->back()->with('success', 'Marks updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Process failed: ' . $e->getMessage());
        }
    }

    public function lock_mark(Request $request){
        # Check permission
        $this->authorize('mark_entry', 48);

        $exam_id = Helper::encrypt_decrypt('decrypt', $request->exam_id);
        $session_id = Helper::encrypt_decrypt('decrypt', $request->session_id);
        $class_id = Helper::encrypt_decrypt('decrypt', $request->class_id);
        $subject_id = Helper::encrypt_decrypt('decrypt', $request->subject_id);

        $subject_name = SubjectModel::where('id', $subject_id)->value('name');
        $class_name = ClassModel::where('id',$class_id)->value('name');
        $exam_name = ExamModel::where('id',$exam_id)->value('name');
        $session_name = SessionModel::where('id',$session_id)->value('name');


        try {
            $save = AssignTeacherModel::where('class_id',$class_id)->where('session_id',$session_id)->where('exam_id',$exam_id)->where('subject_id',$subject_id)->where('teacher_user_id',Auth::user()->user_id)->first();
            if($save==""){
                return redirect()->back()->with('error', 'Something wrong, Please try again');
            }
            $save->is_mark_locked = 1;
            $save->save();
            Helper::store_activity(Auth::user()->user_id, 'Mark locked for subject #' . $subject_name . ' and Class #' .$class_name . ' and Session #' . $session_name . ' and Exam #' . $exam_name);
            return redirect()->back()->with('success', 'Mark locked successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Process failed: ' . $e->getMessage());
        }
    }



    #Result from here:
    public function student_result(Request $request){
         # Check permission
         $this->authorize('result_page', 49);
         $flag = $student_id = $class_id = $assigned_subject_list = $gpa = $result = $total_mark = $exam_id = $session_id = $student_reg_info = null;
         if($request->has(['student_id','class_id','exam_id','session_id']) && is_numeric($request->class_id) && is_numeric($request->exam_id) && is_numeric($request->session_id)) {
             $flag = 1;
             $student_id = $request->student_id;
             $exam_id = $request->exam_id;
             $class_id = $request->class_id;
             $session_id = $request->session_id;

             $student_reg_info = StudentRegistrationModel::getSingleStudent($student_id, $session_id);
             if ($student_reg_info == null) {
                 return redirect()->back()->with("error", "Student information not found");
             }
             $assigned_subject_list = ClassSubjectModel::where('class_id', $class_id)->where('session_id', $session_id)->get();
             $result = "Passed";
             $total_point = $total_mark = $count = $is_failed = 0;
             #find result each subject
             foreach ($assigned_subject_list as $i) {
                 $subject_id = $i->subject_id;
                 $result_info = Helper::getResult($student_id, $class_id, $subject_id, $session_id, $exam_id);
                 if ($result_info == null || $result_info->mark < 33 || $result_info->is_published == 0) {
                     $result = 'Failed';
                     $is_failed = 1;
                 }
                 if ($result_info == null || $result_info->is_published == 0) continue;
                 $total_point += $result_info->grade_point;
                 $total_mark += $result_info->mark;
                 $count++;
             }
             if ($count <= 0) {
                 return redirect()->back()->with('error', 'Result not found');
             }
             $gpa = $total_point / $count;
             if($is_failed == 1){
                 $gpa = 0.00;
             }
         }
         $class_list = ClassModel::getActiveClasses();
         $exam_list = ExamModel::getActiveExams();
         $session_list = SessionModel::getActiveSessions();
         $header_title = 'Student Result';
         return view("admin.examinations.student_result",compact('student_id','header_title','result','assigned_subject_list','class_id','flag','session_id','exam_id','exam_list','class_list','session_list','total_mark','gpa','student_reg_info'));
    }

    public function student_result_pdf(Request $request){
        $this->authorize('result_page', 49);

        if($request->has(['student_id','class_id','exam_id','session_id']) && is_numeric($request->class_id) && is_numeric($request->exam_id) && is_numeric($request->session_id)) {
            $student_id = $request->student_id;
            $exam_id = $request->exam_id;
            $class_id = $request->class_id;
            $session_id = $request->session_id;

            $student_reg_info = StudentRegistrationModel::getSingleStudent($student_id, $session_id);
            if ($student_reg_info == null) {
                return redirect()->back()->with("error", "Student information not found");
            }
            $assigned_subject_list = ClassSubjectModel::where('class_id', $class_id)->where('session_id', $session_id)->get();
            $result = "Passed";
            $total_point = $total_mark = $count = $is_failed = 0;

            foreach ($assigned_subject_list as $i) {
                $subject_id = $i->subject_id;
                $result_info = Helper::getResult($student_id, $class_id, $subject_id, $session_id, $exam_id);
                if ($result_info == null || $result_info->mark < 33 || $result_info->is_published == 0) {
                    $result = 'Failed';
                    $is_failed = 1;
                }
                if ($result_info == null || $result_info->is_published == 0) continue;
                $total_point += $result_info->grade_point;
                $total_mark += $result_info->mark;
                $count++;
            }
            if ($count <= 0) {
                return redirect()->back()->with('error', 'Result not found');
            }
            $gpa = $total_point / $count;
            if($is_failed == 1){
                $gpa = 0.00;
            }
            $data = [
                'student_reg_info' => $student_reg_info,
                'total_mark' => $total_mark,
                'gpa' => $gpa,
                'class_id' => $class_id,
                'session_id' => $session_id,
                'exam_id' => $exam_id,
                'result' => $result,
                'assigned_subject_list' => $assigned_subject_list,
                'school_info' => SchoolInfoModel::first(),
            ];
            $pdf = PDF::loadView('admin.examinations.student_result_pdf', $data);
            $file_name = 'result.pdf';
            return $pdf->stream($file_name);
        } else {
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }
}
