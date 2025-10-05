<?php

namespace App\Http\Controllers;
use App\Models\MisCostModel;
use App\Models\SessionModel;
use App\Models\StudentRegistrationModel;
use App\Models\TeacherModel;
use App\Models\StudentDuesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard() {
        try {
            # Gathering data
            $session_id = SessionModel::where('is_current',0)->value('id') ?? null;
            $totalstudent = StudentRegistrationModel::where('session_id',$session_id)->where('status',0)->count();
            $total_employee = TeacherModel::where('status',0)->count();
            $total_misc_expense = MisCostModel::whereMonth('date',date('m'))->whereYear('date',date('Y'))->sum('amount');
            $total_female = StudentRegistrationModel::where('session_id',$session_id)
                                                    ->where('status',0)
                                                     ->whereHas('student_info',function($query){
                                                         $query->where('gender','female');
                                                     })->count();
            $total_male = StudentRegistrationModel::where('session_id', $session_id)
                                                    ->where('status',0)
                                                    ->whereHas('student_info', function ($query) {
                                                        $query->where('gender', 'male');
                                                    })->count();
            $Play = StudentRegistrationModel::where('class_id', 22)->where('session_id',$session_id)->count();
            $Nursery = StudentRegistrationModel::where('class_id', 21)->where('session_id',$session_id)->count();
            $One = StudentRegistrationModel::where('class_id', 5)->where('session_id',$session_id)->count();
            $Two = StudentRegistrationModel::where('class_id', 23)->where('session_id',$session_id)->count();
            $Three = StudentRegistrationModel::where('class_id', 14)->where('session_id',$session_id)->count();
            $Four = StudentRegistrationModel::where('class_id', 13)->where('session_id',$session_id)->count();
            $Five = StudentRegistrationModel::where('class_id', 8)->where('session_id',$session_id)->count();
            $Six = StudentRegistrationModel::where('class_id', 31)->where('session_id',$session_id)->count();

            $expected_fees = StudentDuesModel::where('session_id',$session_id)->where('month',date('m'))->sum('amount');
            $collected_fees = StudentDuesModel::where('session_id',$session_id)->where('month',date('m'))->sum('paid_amount');
            $total_due = $expected_fees - $collected_fees;
            # Returning the view with data
            return view('admin.dashboard', compact(
                'totalstudent', 'total_employee', 'total_misc_expense', 'total_female',
                'total_male', 'Play', 'Nursery', 'One', 'Two', 'Three', 'Four',
                'Five', 'Six','expected_fees', 'collected_fees', 'total_due'
            ));
        } catch (\Exception $e) {
            Auth::logout();
            return redirect(route('home'))->with('error','Something wrong!' . $e->getMessage());
        }
    }

    public function calendar(){
        return view('others.calendar');
    }

    public function user_manual(){
        return view('others.user_manual');
    }
}
