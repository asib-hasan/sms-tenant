<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MonthsModel;
use App\Models\SchoolInfoModel;
use App\Models\SessionModel;
use Illuminate\Http\Request;
use PDF;

class EmployeeSalarySummaryController extends Controller
{
    public function index(Request $request)
    {
        # Authorize the action
        $this->authorize('salary_payment', 58);

        # Initialize variables
        $flag = $session_id = null;

        if($request->has(['session_id'])){
            $session_id = $request->session_id;
            $flag = 1;
        }
        $month_list = MonthsModel::all();
        $session_list = SessionModel::getActiveSessions();
        $header_title = "Payment Summary";
        return view('admin.employee-salary.salary_payment.payment_summary', compact('month_list','session_list', 'session_id', 'flag', 'header_title'));
    }
    public function print(Request $request)
    {
        # Authorize the action
        $this->authorize('salary_payment', 58);

        if($request->has(['session_id'])){
            $data = [
                'session_id' => $request->session_id,
                'school_info' => SchoolInfoModel::first(),
                'month_list' => MonthsModel::all(),
            ];
            $pdf = PDF::loadView('admin.employee-salary.salary_payment.payment_summary_pdf', $data);
            $file_name ='payment_summary.pdf';
            return $pdf->stream($file_name);
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
}
