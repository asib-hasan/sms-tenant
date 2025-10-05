<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\ClassModel;
use App\Models\DesignationModel;
use App\Models\SessionModel;
use App\Models\Student;
use App\Models\StudentRegistrationModel;
use App\Models\TeacherModel;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function by_student(Request $request){
        $this->authorize('send_sms', 75);
        $student_id = $student_info = $flag = null;
        if(isset($request->student_id) && $request->student_id != null){
            $student_id = $request->student_id;
            $student_info = Student::where('student_id', $student_id)->first();
            if($student_info == null){
                return redirect()->route('send-sms/by/student')->with('error', 'Student information not found');
            } else if($student_info->mobile == null){
                return redirect()->route('send-sms/by/student')->with('error', 'No phone number found');
            }
            $flag = 1;
        }
        return view('admin.sms_service.by-student',compact('student_id','student_info','flag'));
    }

    public function student_send(Request $request){
        $this->authorize('send_sms', 75);

        $student_id = $request->student_id;
        $sms_text = $request->sms_text;
        $student_info = Student::where('student_id',$student_id)->first();
        $phone = $student_info->mobile;
        if($student_info==null) abort(500);
        $response = Helper::sms_send($sms_text, $phone);
        if($response==""){
            return redirect()->route('send-sms/by/student')->with('error', 'Failed to send SMS');
        }
        else if ($response['response_code'] == 202) {
            return redirect()->route('send-sms/by/student')->with('success', 'Sms Send Successfully');
        } else {
            return redirect()->route('send-sms/by/student')->with('error', 'Failed to send SMS');
        }
    }

    public function by_employee(Request $request){
        $this->authorize('send_sms', 75);
        $employee_id = $employee_info = $flag = null;
        if(isset($request->employee_id) && $request->employee_id != null){
            $employee_id = $request->employee_id;
            $employee_info = TeacherModel::where('employee_id',$employee_id)->first();
            if($employee_info == null){
                return redirect()->route('send-sms/by/employee')->with('error','Employee information not found');
            } else if($employee_info->phone == null){
                return redirect()->route('send-sms/by/employee')->with('error','No phone number found');
            }
            $flag = 1;
        }
        return view('admin.sms_service.by-emp',compact('employee_info','employee_id','flag'));
    }

    public function employee_send(Request $request){
        $this->authorize('send_sms', 75);

        $employee_id = $request->employee_id;
        $sms_text = $request->sms_text;
        $employee_info = TeacherModel::where('employee_id',$employee_id)->first();
        $phone = $employee_info->phone;
        if($employee_info==null) abort(500);
        $response = Helper::sms_send($sms_text, $phone);
        if($response==null){
            return redirect()->route('send-sms/by/employee')->with('error', 'Failed to send SMS');
        }
        else if ($response['response_code'] == 202) {
            return redirect()->route('send-sms/by/employee')->with('success', 'Sms Send Successfully');
        } else {
            return redirect()->route('send-sms/by/employee')->with('error', 'Failed to send SMS');
        }
    }

    public function by_class(Request $request){
        $this->authorize('send_sms', 75);

        $flag = $class_id = $session_id = null;
        $student_list = collect();
        if($request->class_id != null && $request->session_id){
            $class_id = $request->class_id;
            $flag = 1;
            $session_id = $request->session_id;
            $student_list = StudentRegistrationModel::where('class_id',$class_id)->where('session_id',$session_id)->where('status',0)->get();
            if(count($student_list)==0){
                return redirect()->route('send-sms/by/student')->with('error','No student found');
            }
        }
        $class_list = ClassModel::getActiveClasses();
        $session_list = SessionModel::getActiveSessions();
        return view('admin.sms_service.by-class',compact('class_list','flag','session_list','student_list','class_id','session_id'));
    }

    public function class_send(Request $request){
        $this->authorize('send_sms', 75);

        $numbers = $request->numbers;
        if($numbers==null){
            return redirect()->route('send-sms/by/class')->with('error','No Numbers Found');
        }
        $number = [];
        $sms_text = $request->sms_text;
        foreach ($numbers as $i) {
            if($i!=null)$number[] = $i;
        }
        if($number==null){
            return redirect()->route('send-sms/by/class')->with('error','No Numbers Found');
        }
        $number = implode(',', $number);
        $response = Helper::sms_send($sms_text, $number);
        if($response==null){
            return redirect()->route('send-sms/by/class')->with('error', 'Failed to send SMS');
        }
        else if ($response['response_code'] == 202) {
            return redirect()->route('send-sms/by/class')->with('success', 'Sms Send Successfully');
        } else {
            return redirect()->route('send-sms/by/class')->with('error', 'Failed to send SMS');
        }
    }

    public function by_designation(Request $request){
        $this->authorize('send_sms', 75);
        $designation_id = $flag = null;
        $employee_list = collect();
        if(isset($request->designation_id) && $request->designation_id != null){
            $designation_id = $request->designation_id;
            $employee_list = TeacherModel::getActiveEmployeesByDesignation($designation_id);
            if($employee_list->isEmpty()){
                return redirect()->route('send-sms/by/designation')->with('error','No employees found');
            }
            $flag = 1;
        }
        $designation_list = DesignationModel::getActiveDesignations();
        return view('admin.sms_service.by-designation',compact('designation_id','designation_list','flag','employee_list'));
    }

    public function designation_send(Request $request){
        $this->authorize('send_sms', 75);

        $numbers = $request->numbers;
        if($numbers==null){
            return redirect()->route('send-sms/by/designation')->with('error','No Numbers Found');
        }
        $number = [];
        $sms_text = $request->sms_text;
        foreach ($numbers as $i) {
            if($i!=null)$number[] = $i;
        }

        if($number==null){
            return redirect()->route('send-sms/by/designation')->with('error','No Numbers Found');
        }
        $number = implode(',', $number);
        $response = Helper::sms_send($sms_text, $number);
        if($response==""){
            return redirect()->route('send-sms/by/designation')->with('error', 'Failed to send SMS');
        }
        else if ($response['response_code'] == 202) {
            return redirect()->route('send-sms/by/designation')->with('success', 'Sms Send Successfully');
        } else {
            return redirect()->route('send-sms/by/designation')->with('error', 'Failed to send SMS');
        }
    }

    #by number
    public function by_number(Request $request){
        $this->authorize('send_sms', 75);

        $total_number = $request->tm ?? '';
        $flag = 0;
        if($total_number != null){
            if($total_number > 30 || $total_number<=0 || !is_numeric($total_number)) {
                return redirect()->back()->with('error', 'Invalid parameter or request');
            }
            $flag = 1;
        }
        $header_title = 'Sms Service - By Number';
        return view('admin.sms_service.by-number',compact('total_number','flag','header_title'));
    }

    public function number_send(Request $request){
        $this->authorize('send_sms', 75);

        $numbers = $request->numbers;
        if($numbers==null){
            return redirect()->route('send-sms/by/number')->with('error','No Numbers Found');
        }
        $number = [];
        $sms_text = $request->sms_text;
        foreach ($numbers as $i) {
            if($i!=null)$number[] = $i;
        }
        if($number==null){
            return redirect()->route('send-sms/by/number')->with('error','No Numbers Found');
        }
        $number = implode(',', $number);
        $response = Helper::sms_send($sms_text, $number);
        if($response==""){
            return redirect()->route('send-sms/by/number')->with('error', 'Failed to send SMS');
        }
        else if (isset($response) && $response['response_code'] == 202) {
            return redirect()->route('send-sms/by/number')->with('success', 'Sms Send Successfully');
        } else {
            return redirect()->route('send-sms/by/number')->with('error', 'Failed to send SMS');
        }
    }
}
