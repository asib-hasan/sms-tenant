<?php

namespace App\Http\Controllers;
use App\Models\ConfigModel;
use App\Models\ExamModel;
use App\Models\SchoolInfoModel;
use App\Models\StudentRegistrationModel;
use App\Models\TeacherModel;
use Illuminate\Database\QueryException;
use PDF;
use App\Models\ClassModel;
use App\Models\SessionModel;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function attendance_sheet(){
        #checking permission
        $this->authorize('attendance_report', 72);
        $header_title = 'Attendance Sheet';
        $class_list = ClassModel::getActiveClasses();
        $session_list = SessionModel::getActiveSessions();
        return view('admin.attendance.search',compact('header_title','class_list','session_list'));
    }

    public function print_attendance_sheet(Request $request){
        #checking permission
        $this->authorize('attendance_report', 72);

        $class_id = $request->class_id;
        $session_id = $request->session_id;
        if(isset($request) && $class_id && $session_id) {
            $student_list = StudentRegistrationModel::where('class_id', $class_id)->where('session_id', $session_id)->where('status',0)->orderBy('roll_no')->get();
            $class_name = ClassModel::where('id', $class_id)->value('name');
            $pdf = PDF::loadView('admin.attendance.generate', [
                'student_list' => $student_list,
                'school_info' => SchoolInfoModel::first(),
                'class_name' => $class_name
            ])->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
            return $pdf->stream();
        }
        else{
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    #ID Card

    // ID CARD FOR STUDENT
    public function id_card_std(Request $request){
        #check permission
        $this->authorize('std_id', 41);

        try {
            $session_list = SessionModel::getActiveSessions();
            $header_title = 'ID Card - Student';
            return view('admin.id_card.search',compact('session_list','header_title'));
        } catch (QueryException $e){
            return redirect()->back()->with('error', 'Process failed for - ' .  $e->getMessage());
        }
    }


    public function id_card_std_generate(Request $request)
    {
        #check permission
        $this->authorize('std_id', 41);
        try {
            $student_id = $request->student_id ?? null;
            $session_id = $request->session_id ?? null;
            if ($student_id != null && $session_id != null && is_numeric($session_id)) {
                $student_reg_info = StudentRegistrationModel::getSingleStudent($student_id, $session_id);
                if (!$student_reg_info) {
                    return redirect()->back()->with('error', 'Student information not found');
                }
                $data = [
                    'student_reg_info' => $student_reg_info,
                    'school_info' => SchoolInfoModel::first(),
                ];
                $check = ConfigModel::where('name', 'id_stu')->first()->value;

                if ($check == 1) {
                    $pdf = PDF::loadView('admin.id_card.generate', $data);
                } else if ($check == 2) {
                    $pdf = PDF::loadView('admin.id_card.generate_2', $data);
                } else {
                    $pdf = PDF::loadView('admin.id_card.generate_3', $data);
                }
                $file_name = $student_id . '_id_card.pdf';
                return $pdf->stream($file_name);
            } else {
                return redirect()->back()->with('error', 'Invalid parameter or request');
            }
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    // ID CARD FOR EMPLOYEE

    public function id_card_emp(Request $request){
        #check permission
        $this->authorize('emp_id', 47);

        try {
            $session_list = SessionModel::getActiveSessions();
            $header_title = 'ID Card - Employee';
            return view('admin.id_card_emp.search',compact('session_list','header_title'));
        } catch (QueryException $e){
            return redirect()->back()->with('error', 'Process failed for - ' .  $e->getMessage());
        }
    }



    public function id_card_emp_generate(Request $request){
        #check permission
        $this->authorize('emp_id', 47);

        $employee_id = $request->employee_id;
        if($employee_id!=""){
            $employee_info = TeacherModel::where('employee_id',$employee_id)->first();
            if($employee_info==null){
                return redirect()->back()->with('error','Employee information not found');
            }
            $check = ConfigModel::where('name','id_emp')->first()->value;
            $data = [
               'employee_info' => $employee_info,
                'school_info' => SchoolInfoModel::first(),
            ];
            if($check==1){
                $pdf = PDF::loadView('admin.id_card_emp.generate', $data);
            }
            else if($check==2){
                $pdf = PDF::loadView('admin.id_card_emp.generate_2', $data);
            }
            else{
                $pdf = PDF::loadView('admin.id_card_emp.generate_3', $data);
            }
            $file_name = $employee_id . '_id_card.pdf';
            return $pdf->stream($file_name);
        }
        else{
            abort(500);
        }

    }

    //Admit Card
    public function admit_card_by_student(){
        #checking permission
        $this->authorize('admit_card', 73);
        $header_title = 'Admit Card - By Student';
        $exam_list = ExamModel::getActiveExams();
        $session_list = SessionModel::getActiveSessions();
        return view('admin.admit_card.by_student',compact('header_title','exam_list','session_list'));
    }

    public function admit_card_by_class(){
        #checking permission
        $this->authorize('admit_card', 73);
        $header_title = 'Admit Card - By Class';
        $class_list = ClassModel::getActiveClasses();
        $exam_list = ExamModel::getActiveExams();
        $session_list = SessionModel::getActiveSessions();
        return view('admin.admit_card.by_class',compact('header_title','class_list','exam_list','session_list'));
    }

    public function print_admit_card_student(Request $request)
    {
        $this->authorize('admit_card', 73);
        if ($request->student_id != "" && $request->session_id != "" && $request->exam_id != "") {
            $student_id = $request->student_id;
            $exam_id = $request->exam_id;
            $session_id = $request->session_id;
            $exam_info = ExamModel::where('id',$exam_id)->first();
            $student_reg_info = StudentRegistrationModel::getSingleStudent($student_id,$session_id);

            if($student_reg_info==null){
                return redirect()->back()->with('error','Student information not found');
            }
            $school_info = SchoolInfoModel::first();
            $pdf = PDF::loadView('admin.admit_card.admit_pdf_student', [
                'student_reg_info' => $student_reg_info,
                'exam_info' => $exam_info,
                'school_info' => $school_info,
            ]);
            $file_name = 'admit_card.pdf';
            return $pdf->stream($file_name);
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
    public function print_admit_card_class(Request $request)
    {
        $this->authorize('admit_card', 73);
        if ($request->has(['class_id','exam_id','session_id'])) {
            $class_id = $request->class_id;
            $exam_id = $request->exam_id;
            $session_id = $request->session_id;
            $exam_info = ExamModel::where('id',$exam_id)->first();
            $student_list = StudentRegistrationModel::where('class_id',$class_id)->where('session_id',$session_id)->where('status',0)->get();

            $school_info = SchoolInfoModel::first();
            $pdf = PDF::loadView('admin.admit_card.admit_pdf_class', [
                'student_list' => $student_list,
                'exam_info' => $exam_info,
                'school_info' => $school_info,
            ]);
            $file_name = 'admit_card_class.pdf';
            return $pdf->stream($file_name);
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    //Testimonial
    public function search_testimonial(){
        $data['header_title'] = 'Generate Testimonial';
        $data['getExam'] = ExamModel::where('status',0)->get();
        $data['getSession'] = SessionModel::getActiveSessions();
        return view('admin.testimonial.search',$data);
    }

    public function generate_testimonial(Request $request){
        $student_id = $request->student_id;
        $data['exam'] = $request->exam;
        $data['pass_year'] = $request->session_name;
        $data['board'] = $request->board;
        $data['roll_number'] = $request->roll_number;
        $data['reg_number'] = $request->reg_number;
        $data['result'] = $request->result;
        $data['group'] = $request->group;
        $data['school_info'] = SchoolInfoModel::first();
        $currentDate = Carbon::now();
        $data['today_date'] = $currentDate->toFormattedDateString();
        $data['student'] = Student::where('student_id',$student_id)->first();
        if($data['student']==null){
            return redirect()->back()->with('error','Student information not found');
        }
        //Today Date
        $pdf = PDF::loadView('admin.testimonial.generate', $data);
        $file_name ='admit-card.pdf';
        return $pdf->stream($file_name);
    }

    #######################
    #########Select ID Card(From Global Settings)
    #######################

    public function select_stu(){
        $this->authorize('select_id', 10);

        $data['value'] = ConfigModel::where('name','id_stu')->first()->value;
        return view('admin.select-id-card.id-stu',$data);
    }
    public function select_stu_update(Request $request){
        $this->authorize('select_id', 10);

        $selected_id = $request->selected_image;
        if($selected_id==null){
             return redirect()->back()->with('success','ID Card Successfully Updated');
        }
        $save = ConfigModel::where('name','id_stu')->first();
        $save->value = intval($selected_id[5]);
        $save->save();
        return redirect()->back()->with('success','ID Card Successfully Updated');
    }
    public function select_emp(){
        $this->authorize('select_id', 10);

        $data['value'] = ConfigModel::where('name','id_emp')->first()->value;
        return view('admin.select-id-card.id-emp',$data);
    }
    public function select_emp_apply(Request $request){
        $this->authorize('select_id', 10);

        $selected_id = $request->selected_image;
        if($selected_id==null){
             return redirect()->back()->with('success','ID Card Successfully Updated');
        }
        $save = ConfigModel::where('name','id_emp')->first();
        $save->value = intval($selected_id[5]);
        $save->save();
        return redirect()->back()->with('success','ID Card Successfully Updated');
    }

}
