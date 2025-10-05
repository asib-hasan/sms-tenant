<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\SchoolInfoModel;
use App\Models\IncomeStudentDuesModel;
use App\Models\InvoiceModel;
use App\Models\InvestModel;
use App\Models\MisCostModel;
use App\Models\SalaryExpenceModel;
use App\Models\StudentRegistrationModel;
use App\Models\TeacherModel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use PDF;
class AccountsController extends Controller
{
    ###############
    #Transaction History(Student Payment)
    ###############
    public function transaction_student(Request $request){
        #checking permission
        $this->authorize('transaction_history_std', 53);
        $invoice_no = null;
        $total_amount = 0;
        try {
            if($request->has('invoice_no') && $request->invoice_no != null){
                $invoice_no = trim($request->invoice_no);
                $transaction_history = InvoiceModel::where('invoice_no',$invoice_no)->where('category_type',0)->paginate(10);
                $total_amount = $transaction_history->sum('amount');
            }
            else {
                #getting transaction history list
                $transaction_history = InvoiceModel::orderbyDesc('id')->where('category_type', 0)->paginate(10);
                $total_amount = InvoiceModel::where('category_type', 0)->sum('amount');
            }
            $header_title = 'Transaction History(Std. Payment)';
            return view('admin.transaction_history_std.index', compact('total_amount','invoice_no','transaction_history','header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }

    }

    public function transaction_view(Request $request)
    {
        #checking permission
        $this->authorize('transaction_history_std', 53);
        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if (is_numeric($id) && $id > 0) {
            try {
                $invoice_info = InvoiceModel::where('id', $id)->first();
                if(!$invoice_info){
                    return redirect()->back()->with('error', 'Invoice information not found');
                }
                $student_reg_info = StudentRegistrationModel::where('student_id', $invoice_info->id_number)->where('session_id', $invoice_info->session_id)->first();
                if ($student_reg_info == null) {
                    abort(500);
                }
                $getAmount = IncomeStudentDuesModel::where('invoice_id', $invoice_info->id)->get();
                $data = [
                    'amount_list' => $getAmount,
                    'student_reg_info' => $student_reg_info,
                    'invoice_info' => $invoice_info,
                    'school_info' => SchoolInfoModel::first(),
                ];
                $pdf = PDF::loadView('admin.transaction_history_std.view2', $data)->setPaper('a4', 'landscape');;
                $file_name = 'Invoice_stu.pdf';
                return $pdf->stream($file_name);
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    ###############
    #Transaction History -> Employee#
    ###############

    public function transaction_employee(Request $request){
        #checking permission
        $this->authorize('transaction_history_emp', 59);
        $invoice_no = null;
        try {
            if($request->has('invoice_no') && $request->invoice_no != null){
                $invoice_no = trim($request->invoice_no);
                $transaction_history = InvoiceModel::where('invoice_no',$invoice_no)->where('category_type',1)->paginate(10);
                $total_amount = $transaction_history->sum('amount');
            }
            else {
                #getting transaction history list
                $transaction_history = InvoiceModel::orderbyDesc('id')->where('category_type', 1)->paginate(10);
                $total_amount = InvoiceModel::where('category_type', 1)->sum('amount');
            }
            $header_title = 'Transaction History(Emp. Salary)';
            return view('admin.transaction_history_emp.index', compact('total_amount','invoice_no','transaction_history','header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function transaction_view_emp(Request $request)
    {
        #checking permission
        $this->authorize('transaction_history_emp', 59);
        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if (is_numeric($id) && $id > 0) {
            try {
                $invoice_info = InvoiceModel::where('id', $id)->first();
                if(!$invoice_info){
                    return redirect()->back()->with('error', 'Invoice information not found');
                }
                $employee_info = TeacherModel::where('employee_id', $invoice_info->id_number)->first();
                if ($employee_info == null) {
                    abort(500);
                }
                $getAmount = SalaryExpenceModel::where('invoice_id', $invoice_info->id)->get();
                $data = [
                    'getAmount' => $getAmount,
                    'employee_info' => $employee_info,
                    'invoice_info' => $invoice_info,
                    'school_info' => SchoolInfoModel::first(),
                ];
                $pdf = PDF::loadView('admin.transaction_history_emp.view', $data);
                $file_name = 'Invoice_emp.pdf';
                return $pdf->stream($file_name);
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }


    public function balance_sheet(Request $request)
    {
        $this->authorize('balance_sheet', 60);
        $data['from_date'] = $data['to_date'] = $data['flag'] = $data['report_type'] = null;
        if($request->has('report_type') && $request->report_type != null) {
            $report_type = $request->report_type;
            $data['flag'] = 1;
            $data['income'] = IncomeStudentDuesModel::query();
            $data['misc_cost'] = MisCostModel::query();
            $data['investment'] = InvestModel::query();
            $data['salary_expense'] = SalaryExpenceModel::query();
            if ($report_type == 'Custom') {
                $to_date = $request->to_date;
                $from_date = $request->from_date;
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
                $data['report_type'] = 'Custom';
                $data['income']->whereBetween('date', [$from_date, $to_date]);
                $data['misc_cost']->whereBetween('date', [$from_date, $to_date]);
                $data['salary_expense']->whereBetween('date', [$from_date, $to_date]);
                $data['investment']->whereBetween('date', [$from_date, $to_date]);
            } else {
                $data['report_type'] = 'by_total';
            }
            $data['StudentDuesCollection'] = $data['income']->sum('amount');
            $data['misc_cost'] = $data['misc_cost']->sum('amount');
            $data['investment'] = $data['investment']->sum('amount');
            $data['salary_expense'] = $data['salary_expense']->sum('amount');
            $data['header_title'] = 'Finance Report';
        }
        return view('admin.balance_sheet.balance_sheet', $data);
    }
}
