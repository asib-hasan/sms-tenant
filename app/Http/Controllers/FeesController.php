<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\ACHeadModel;
use App\Models\ClassModel;
use App\Models\IncomeStudentDuesModel;
use App\Models\InvoiceModel;
use App\Models\MonthsModel;
use App\Models\Student;
use App\Models\StudentDuesModel;
use App\Models\StudentRegistrationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SessionModel;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class FeesController extends Controller
{
    /*########
        Generate Or Update Student Fees
    ##########*/

    public function bystudent(Request $request)
    {
        $this->authorize('fee_structure', 50);
        $ac_head_list = $student_reg_info = $month_list = $flag = $student_id = $session_id = "";
        $student_list = collect();
        if (isset($request->student_id) && $request->student_id != "" && $request->session_id != "") {
            $flag = 1;
            $session_id = $request->session_id;
            $ac_head_list = ACHeadModel::getIncomeHead();
            $month_list = MonthsModel::all();
            $student_list = StudentRegistrationModel::where('session_id', $session_id)->where('status',0)->get();
            $student_reg_info = StudentRegistrationModel::getSingleStudent($request->student_id, $request->session_id);
            if ($student_reg_info == null) {
                return redirect()->back()->with("error", "Student information not found");
            }
            $student_id = $student_reg_info->student_id;
        }
        $header_title = "Fee Structure";
        $session_list = SessionModel::getActiveSessions();
        return view('admin.student_fee.generate.bystudent', compact('session_id','month_list','student_list', 'student_id', 'flag', 'ac_head_list', 'student_reg_info', 'header_title', 'session_list'));

    }

    public function apply_fees_for_student(Request $request)
    {
        #checking permission
        $this->authorize('fee_structure', 50);

        $rules = [
            'student_reg_id' => 'required',
            'months' => 'required',
            'amount' => 'required|numeric',
            'session_id' => 'required|exists:session,id',
            'ac_head_id' => 'required|exists:ac_head,id',
        ];
        $message = [
            'student_reg_id.required' => 'Student Reg. ID required',
            'months.required' => 'Months required',
            'amount.required' => 'Amount required',
            'amount.numeric' => 'Amount must be numeric',
            'session_id.required' => 'Session required',
            'session_id.exists' => 'Session not found',
            'ac_head_id.required' => 'Account Head ID required',
            'ac_head_id.exists' => 'Account Head not found',
        ];
        $this->validate($request, $rules, $message);
        try {
            $student = StudentRegistrationModel::where('id',$request->student_reg_id)->where('status',0)->first();
            if(!$student){
                return redirect()->back()->with("error", "Student information not found");
            }
            DB::transaction(function () use ($request, $student) {
                $std_id = $student->std_id;
                $student_id = $student->student_id;
                $months = $request->months;
                $amount = $request->amount;
                $session_id = $request->session_id;
                $ac_head_id = $request->ac_head_id;

                foreach ($months as $month) {
                    $dues = StudentDuesModel::where('student_reg_id', $student->id)
                        ->where('month', $month)
                        ->where('ac_head_id', $ac_head_id)
                        ->first();

                    if ($dues) {
                        $dues->update([
                            'amount' => $amount,
                            'amount_after_waiver' => $dues->waiver ? $amount - ($amount * ($dues->waiver / 100.0)) : $amount,
                            'due' => $dues->waiver ? ($amount - ($amount * ($dues->waiver / 100.0))) - $dues->paid_amount : $amount - $dues->paid_amount,
                            'updated_by' => Auth::user()->user_id,
                        ]);
                        #activity process
                        Helper::store_activity(Auth::user()->user_id, 'Fee structure updated for student ID #' . $student_id);
                    } else {
                        StudentDuesModel::insert([
                            'student_reg_id' => $student->id,
                            'student_id' => $student_id,
                            'std_id' => $std_id,
                            'class_id' => $student->class_id,
                            'ac_head_id' => $ac_head_id,
                            'session_id' => $session_id,
                            'amount' => $amount,
                            'due' => $amount,
                            'amount_after_waiver' => $amount,
                            'created_by' => Auth::user()->user_id,
                            'month' => $month,
                        ]);
                        #activity process
                        Helper::store_activity(Auth::user()->user_id, 'Fee structure created for student ID #' . $student_id);
                    }
                }
            });
            return redirect()->back()->with('success', 'Fee Structure Created/Updated Successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while applying fees. Please try again.' . $e->getMessage());
        }

    }

    public function byclass(Request $request)
    {
        $this->authorize('fee_structure', 50);
        $session_id = $class_info = $class_id = $flag = $student_id = $flag = $totalStudent = "";
        $ac_head_list = collect();
        if (isset($request->class_id) && $request->class_id != "" && $request->session_id != "") {
            $flag = 1;
            $class_id = $request->class_id;
            $class_info = ClassModel::where('id', $class_id)->first();
            $session_id = $request->session_id;
            if ($class_info == "") {
                return redirect()->back()->with('error', 'Class information not found');
            }
            $ac_head_list = ACHeadModel::getIncomeHead();
            $totalStudent = StudentRegistrationModel::where('session_id', $session_id)->where('class_id', $request->class_id)->where('status',0)->count();
            if ($totalStudent == 0) {
                return redirect(route('stdacc/fee/structure/by/class'))->with("error", "No student found");
            }
        }
        $header_title = "Fee Structure";
        $session_list = SessionModel::getActiveSessions();
        $month_list = MonthsModel::all();
        $class_list = ClassModel::getActiveClasses();
        return view('admin.student_fee.generate.byclass', compact('session_id','month_list', 'totalStudent', 'class_id', 'class_info', 'flag', 'ac_head_list', 'class_list', 'header_title', 'session_list'));
    }

    public function apply_fees_for_class(Request $request)
    {
        #checking permission
        $this->authorize('fee_structure', 50);

        $rules = [
            'class_id' => 'required|exists:class,id',
            'months' => 'required',
            'amount' => 'required|numeric',
            'session_id' => 'required',
            'ac_head_id' => 'required|exists:ac_head,id',
        ];
        $message = [
            'class_id.required' => 'Class ID required',
            'class_id.exists' => 'Class not found',
            'months.required' => 'Months required',
            'amount.required' => 'Amount required',
            'amount.numeric' => 'Amount must be numeric',
            'session_id.required' => 'Session ID required',
            'ac_head_id.required' => 'Account Head ID required',
            'ac_head_id.exists' => 'Account Head not found',
        ];
        $this->validate($request, $rules, $message);

        try {
            DB::transaction(function () use ($request) {
                $class_id = $request->class_id;
                $months = $request->months;
                $amount = $request->amount;
                $session_id = $request->session_id;
                $ac_head_id = $request->ac_head_id;
                $class_name = ClassModel::where('id', $class_id)->first()->name ?? '';
                $students = StudentRegistrationModel::where('status', 0)
                    ->where('class_id', $class_id)
                    ->where('session_id', $session_id)
                    ->get();
                $student_ids = $students->pluck('student_id')->toArray();
                $dues = StudentDuesModel::whereIn('student_id', $student_ids)
                    ->whereIn('month', $months)
                    ->where('ac_head_id', $ac_head_id)
                    ->where('session_id', $session_id)
                    ->get()
                    ->keyBy(function ($item) {
                        return $item->student_id . '-' . $item->month;
                    });

                $newDues = [];
                foreach ($students as $student) {
                    foreach ($months as $month) {
                        $key = $student->student_id . '-' . $month;
                        if (isset($dues[$key])) {
                            $due = $dues[$key];
                            $due->update([
                                'amount' => $amount,
                                'amount_after_waiver' => $due->waiver ? $amount - ($amount * ($due->waiver / 100.0)) : $amount,
                                'due' => $due->waiver ? ($amount - ($amount * ($due->waiver / 100.0))) - $due->paid_amount : $amount - $due->paid_amount,
                                'updated_by' => Auth::user()->user_id,
                            ]);
                        } else {
                            $newDues[] = [
                                'student_reg_id' => $student->id,
                                'student_id' => $student->student_id,
                                'class_id' => $student->class_id,
                                'std_id' => $student->std_id,
                                'ac_head_id' => $ac_head_id,
                                'session_id' => $session_id,
                                'amount' => $amount,
                                'due' => $amount,
                                'paid_amount' => 0,
                                'amount_after_waiver' => $amount,
                                'created_by' => Auth::user()->user_id,
                                'month' => $month,
                            ];
                        }
                    }
                }

                # Bulk insert new dues
                if (!empty($newDues)) {
                    StudentDuesModel::insert($newDues);
                }

                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Fees structure applied for class #' . $class_name . ' and session #' . SessionModel::getName($session_id));
            });
            return redirect()->back()->with('success', 'Fee Structure Created/Updated Successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while applying fees. Please try again.');
        }
    }

    public function byschool(Request $request)
    {
        $this->authorize('fee_structure', 50);

        $header_title = "Fee Structure";
        $session_list = SessionModel::getActiveSessions();
        $month_list = MonthsModel::all();
        $ac_head_list = ACHeadModel::getIncomeHead();
        return view('admin.student_fee.generate.byschool', compact('ac_head_list','month_list', 'header_title', 'session_list'));
    }

    public function apply_fees_for_school(Request $request)
    {
        #checking permission
        $this->authorize('fee_structure', 50);

        $rules = [
            'months' => 'required|array',
            'amount' => 'required|numeric',
            'session_id' => 'required|exists:session,id',
            'ac_head_id' => 'required|exists:ac_head,id',
        ];
        $message = [
            'months.required' => 'Months required',
            'months.array' => 'Months must be an array',
            'amount.required' => 'Amount required',
            'amount.numeric' => 'Amount must be numeric',
            'session_id.required' => 'Session ID required',
            'session_id.exists' => 'Session not found',
            'ac_head_id.required' => 'Account Head ID required',
            'ac_head_id.exists' => 'Account Head not found',
        ];
        $this->validate($request, $rules, $message);

        try {
            DB::transaction(function () use ($request) {
                $months = $request->months;
                $amount = $request->amount;
                $session_id = $request->session_id;
                $ac_head_id = $request->ac_head_id;
                $ac_head_name = ACHeadModel::getName($ac_head_id);
                $session_name = SessionModel::getName($session_id);
                $students = StudentRegistrationModel::where('status', 0)->where('session_id',$session_id)->get();
                $student_ids = $students->pluck('student_id')->toArray();
                $dues = StudentDuesModel::whereIn('student_id', $student_ids)
                    ->whereIn('month', $months)
                    ->where('ac_head_id', $ac_head_id)
                    ->where('session_id', $session_id)
                    ->get()
                    ->keyBy(function ($item) {
                        return $item->student_id . '-' . $item->month;
                    });

                $newDues = [];
                foreach ($students as $student) {
                    foreach ($months as $month) {
                        $key = $student->student_id . '-' . $month;
                        if (isset($dues[$key])) {
                            $due = $dues[$key];
                            $due->update([
                                'amount' => $amount,
                                'amount_after_waiver' => $due->waiver ? $amount - ($amount * ($due->waiver / 100.0)) : $amount,
                                'due' => $due->waiver ? ($amount - ($amount * ($due->waiver / 100.0))) - $due->paid_amount : $amount - $due->paid_amount,
                                'updated_by' => Auth::user()->user_id,
                            ]);
                        } else {
                            $newDues[] = [
                                'student_reg_id' => $student->id,
                                'student_id' => $student->student_id,
                                'class_id' => $student->class_id,
                                'std_id' => $student->std_id,
                                'ac_head_id' => $ac_head_id,
                                'session_id' => $session_id,
                                'amount' => $amount,
                                'due' => $amount,
                                'paid_amount' => 0,
                                'amount_after_waiver' => $amount,
                                'created_by' => Auth::user()->user_id,
                                'month' => $month,
                            ];
                        }
                    }
                }
                # Bulk insert new dues
                if (!empty($newDues)) {
                    StudentDuesModel::insert($newDues);
                }
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Fees structure applied all students for head #' . $ac_head_name . ' and Session #' . $session_name);

            });
            return redirect()->back()->with('success', 'Fee Structure Created/Updated Successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while applying fees. Please try again. 2' . $e->getMessage());
        }
    }

    ##################
    #Fees Collection
    ##################

    public function fees_collection(Request $request)
    {
        # Authorize the action
        $this->authorize('fees_collection', 52);

        # Initialize variables
        $student_id = $month = $session_id = $session_name = $student_reg_info = $fees_list = $flag =  "";
        $invoice_list = $student_list = collect();
        if (isset($request->student_id) && $request->student_id != "" && $request->session_id != "" && $request->month != "") {
            $student_id = $request->student_id;
            $month = $request->month;
            $session_id = $request->session_id;
            $student_list = StudentRegistrationModel::where('session_id', $session_id)->where('status',0)->get();
            $invoice_list = InvoiceModel::where('id_number', $student_id)->where('session_id', $session_id)->where('month', $month)->get();
            $flag = 1;

            $session_info = SessionModel::where('id', $session_id)->first();
            if ($session_info == null) {
                return redirect()->back()->with("error", "Session information not found");
            }
            $session_name = $session_info->name;
            $student_reg_info = StudentRegistrationModel::getSingleStudent($student_id, $session_id);

            if ($student_reg_info == null) {
                return redirect()->back()->with('error', 'No student information found');
            }

            $fees_list = StudentDuesModel::where('student_reg_id', $student_reg_info->id)->where('month', $month)->where('session_id',$session_id)->get();

            if ($fees_list->isEmpty()) {
                return redirect()->back()->with('error', 'No fee structure found');
            }
        }
        $month_list = MonthsModel::all();
        $session_list = SessionModel::getActiveSessions();
        $header_title = "Fees Collection";
        return view('admin.student_fee.fees_collection.collection_page', compact('student_reg_info', 'invoice_list', 'month_list', 'month', 'fees_list', 'session_id', 'session_list', 'flag', 'student_id', 'header_title', 'session_name','student_list'));
    }

    public function fees_collection_apply(Request $request)
    {
        $auth = Auth::user();

        $this->authorize('fees_collection', 52);

        $amounts = $request->amounts;
        $totalAmount = array_sum($amounts);

        if (!$totalAmount || $totalAmount == 0) {
            return redirect(route('stdacc/fees/collection'))->with('error', 'You did not input any payment, Please try again');
        }

        $student_id = Helper::encrypt_decrypt('decrypt', $request->student_id);
        $session_id = Helper::encrypt_decrypt('decrypt', $request->session_id);

        $studentRegInfo = StudentRegistrationModel::getSingleStudent($student_id, $session_id);
        $sessionInfo = SessionModel::where('id', $session_id)->first();

        if (!$studentRegInfo || !$sessionInfo) {
            return redirect(route('stdacc/fees/collection'))->with('error', 'Something went wrong, Please try again');
        }

        $is_sms_send = 0;
        if($request->sms && $request->sms == 'on') {
            $is_sms_send = 1;
        }
        DB::beginTransaction();

        try {
            $invoiceNo = Helper::generateInvoiceNumber();
            $invoice = InvoiceModel::create([
                'invoice_no' => $invoiceNo,
                'id_number' => $student_id,
                'payment_type' => $request->payment_type,
                'month' => $request->month,
                'session_id' => $session_id,
                'date' => $request->date,
                'category_type' => 0,
                'bank_account_no' => $request->bank_account_no,
                'amount' => $totalAmount,
                'created_by' => $auth->user_id,
                'note' => $request->note,
            ]);

            $invoiceId = $invoice->id;

            foreach ($amounts as $feeId => $amount) {
                if (!empty($amount)) {
                    $studentDue = StudentDuesModel::where('id', $feeId)->first();
                    if (!$studentDue) {
                        # If any error occurs, rollback the transaction
                        DB::rollBack();
                        return redirect(route('stdacc/fees/collection'))->with('error', 'Something went wrong, Please try again');
                    }

                    IncomeStudentDuesModel::create([
                        'student_id' => $studentDue->student_id,
                        'std_id' => $studentRegInfo->std_id,
                        'std_reg_id' => $studentRegInfo->id,
                        'ac_head_id' => $studentDue->ac_head_id,
                        'dues_id' => $feeId,
                        'date' => $request->date,
                        'month' => $request->month,
                        'session_id' => $session_id,
                        'invoice_no' => $invoiceNo,
                        'invoice_id' => $invoiceId,
                        'amount' => $amount,
                    ]);

                    # Update student dues
                    $studentDue->increment('paid_amount', $amount);
                    $studentDue->decrement('due', $amount);
                }
            }
            DB::commit();
            $text = 'Respected Parent, the fees for Student ID: ' . $studentRegInfo->student_id . ' for the month of ' . MonthsModel::getName($request->month) . ' (' . SessionModel::getName($session_id) . ') have been successfully paid. ' . 'Amount Paid: ' . $totalAmount . ' BDT. We sincerely thank you for your cooperation. - MAHMCM';
            #sms block
            if($is_sms_send == 1 && $studentRegInfo->student_info->mobile != null) {
                Helper::sms_send($text, $studentRegInfo->student_info->mobile);
            }
            #activity process
            Helper::store_activity(Auth::user()->user_id, 'Fees collected for student ID #' . $studentRegInfo->student_id . ' Session #' . SessionModel::getName($session_id) . ' and month #' . $request->month);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('stdacc/fees/collection'))->with('error', 'An error occurred: ' . $e->getMessage());
        }

        # Redirect with success message and transaction view link

        return redirect(route('stdacc/fees/collection'))
            ->with('paymentsuccess', 'Fees collected successfully')
            ->with('invoice_id', $invoiceId);
    }

    public function invoice_update(Request $request)
    {
        $invoice_id = Helper::encrypt_decrypt('decrypt', $request->invoice_id);
        if (is_numeric($invoice_id) && $invoice_id > 0) {
            $rules = [
                'payment_type' => 'required',
                'bank_account_no' => 'nullable',
                'date' => 'required|date',
                'note' => 'nullable',
            ];
            $message = [
                'payment_type.required' => 'Payment type required',
                'month.required' => 'Month required',
                'date.required' => 'Date required',
                'date.date' => 'Invalid date format',
            ];
            $this->validate($request, $rules, $message);
            $invoice_info = InvoiceModel::where('id', $invoice_id)->first();
            if (!$invoice_info) {
                return redirect(route('stdacc/fees/collection'))->with('error', 'Invoice information not found');
            }
            $total_amount = 0;
            foreach ($request->payment_details as $id=>$amount) {
                if($amount != null){
                    $total_amount += $amount;
                }
            }
            if($total_amount == 0){
                return redirect()->back()->with('error', 'No payment amount found');
            }
            $invoice_no = $invoice_info->invoice_no;
            DB::transaction(function () use ($invoice_id, $total_amount, $request, $invoice_no) {
                InvoiceModel::where('id', $invoice_id)->update([
                    'payment_type' => $request->payment_type,
                    'bank_account_no' => $request->bank_account_no,
                    'date' => $request->date,
                    'note' => $request->note,
                    'amount' => $total_amount,
                ]);
                foreach ($request->payment_details as $dues_id => $amount) {
                    $student_dues_info = StudentDuesModel::where('id', $dues_id)->first();
                    if ($student_dues_info) {
                        if($amount) {
                            $income_dues_info = IncomeStudentDuesModel::where('dues_id', $dues_id)->where('invoice_id',$invoice_id)->first();
                            if ($income_dues_info) {
                                #delete income dues and rollback student dues calculation
                                $student_dues_info->paid_amount -= $income_dues_info->amount;
                                $income_dues_info->delete();

                                #calculate new calculation with new amount
                                $student_dues_info->paid_amount += $amount;
                                $student_dues_info->due = $student_dues_info->amount - $student_dues_info->paid_amount;
                                $student_dues_info->save();

                                IncomeStudentDuesModel::insert([
                                    'invoice_id' => $invoice_id,
                                    'student_id' => $student_dues_info->student_id,
                                    'std_id' => $student_dues_info->std_id,
                                    'month' => $student_dues_info->month,
                                    'session_id' => $student_dues_info->session_id,
                                    'dues_id' => $student_dues_info->id,
                                    'date' => $request->date,
                                    'amount' => $amount,
                                    'ac_head_id' => $student_dues_info->ac_head_id,
                                ]);
                            }
                            else{
                                #calculate new calculation with new amount
                                $student_dues_info->paid_amount += $amount;
                                $student_dues_info->due = $student_dues_info->amount - $student_dues_info->paid_amount;
                                $student_dues_info->save();

                                IncomeStudentDuesModel::insert([
                                    'invoice_id' => $invoice_id,
                                    'student_id' => $student_dues_info->student_id,
                                    'std_id' => $student_dues_info->std_id,
                                    'month' => $student_dues_info->month,
                                    'session_id' => $student_dues_info->session_id,
                                    'dues_id' => $student_dues_info->id,
                                    'date' => $request->date,
                                    'amount' => $amount,
                                    'ac_head_id' => $student_dues_info->ac_head_id,
                                ]);
                            }
                        }
                        else{
                            $income_dues_info = IncomeStudentDuesModel::where('dues_id', $dues_id)->where('invoice_id',$invoice_id)->first();
                            if ($income_dues_info) {
                                $student_dues_info->paid_amount -= $income_dues_info->amount;
                                $student_dues_info->due += $income_dues_info->amount;
                                $student_dues_info->save();
                                $income_dues_info->delete();
                            }
                        }
                    }
                }
                #store activity
                Helper::store_activity(Auth::user()->user_id, 'Invoice updated for invoice no#' . $invoice_no);
            });
            return redirect()->back()->with('success', 'Invoice(Student) updated successfully');
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }

    public function invoice_delete(Request $request)
    {
        $invoice_id = Helper::encrypt_decrypt('decrypt', $request->invoice_id);
        if (is_numeric($invoice_id) && $invoice_id > 0) {
            $invoice_info = InvoiceModel::where('id', $invoice_id)->first();
            if (!$invoice_info) {
                return redirect(route('stdacc/fees/collection'))->with('error', 'Invoice information not found');
            }
            $invoice_no = $invoice_info->invoice_no;
            DB::transaction(function () use ($invoice_id,$invoice_no) {
                InvoiceModel::where('id', $invoice_id)->delete();
                $income_dues_info = IncomeStudentDuesModel::where('invoice_id', $invoice_id)->get();
                foreach ($income_dues_info as $due) {
                    $dues_info = StudentDuesModel::where('id',$due->dues_id)->first();
                    $dues_info->paid_amount -= $due->amount;
                    $dues_info->due += $due->amount;
                    $dues_info->save();
                }
                IncomeStudentDuesModel::where('invoice_id', $invoice_id)->delete();
                #store activity
                Helper::store_activity(Auth::user()->user_id, 'Invoice deleted for invoice no#' . $invoice_no);
            });
            return redirect()->back()->with('success', 'Invoice deleted successfully');
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }

    #####STUDENT DUES##########
    ###########################

    public function find_dues($id){
        $studentDues = StudentDuesModel::findOrFail($id);
        $studentDues->ac_head_info;
        $studentDues->student_reg_info;
        $studentDues->student_reg_info->class_info;
        $studentDues->student_info;
        return response()->json($studentDues);
    }

    public function update_dues(Request $request)
    {
        # checking permission
        $this->authorize('student_dues_edit', 55);

        try {
            # initializing variables
            $dues_id = $request->dues_id;
            $amount = $request->amount;
            $waiver = $request->waiver;
            $amount_after_waiver = $request->amount_after_waiver;
            $due = $request->due;

            # fetching and updating dues
            $dues = StudentDuesModel::findOrFail($dues_id);
            $dues->amount = $amount;
            $dues->waiver = $waiver;
            $dues->amount_after_waiver = $amount_after_waiver;
            $dues->due = $due;
            $dues->save();
            #activity process
            Helper::store_activity(Auth::user()->user_id, 'Fee structure updated for student ID #' . $dues->student_id);
            return redirect()->back()->with('success', 'Dues updated successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Dues information not found');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong' . $e->getMessage());
        }
    }

    public function delete_dues(Request $request) {
        # checking permission
        $this->authorize('student_dues_delete', 56);

        try {
            # initializing variables
            $dues = $request->selected_dues;

            # checking if dues are selected
            if (empty($dues)) {
                return redirect()->back()->with('error', 'No fee structures found');
            }

            # deleting dues
            $found = false;
            foreach ($dues as $dues_id) {
                $isFound = IncomeStudentDuesModel::where('dues_id', $dues_id)->first();
                if ($isFound) {
                    $found = true;
                }
            }
            if($found){
                return redirect()->back()->with('error', 'Fee structure(s) already in use, You cannot delete');
            }
            else{
                $month = $session_id = "";
                foreach ($dues as $dues_id) {
                    $toDelete = StudentDuesModel::where('id',$dues_id)->first();
                    if($toDelete){
                        if($month==""){
                            $month = $toDelete->month;
                            $session_id = $toDelete->session_id;
                        }
                        $toDelete->delete();
                    }
                }
            }
            $session_name = SessionModel::where('id',$session_id)->first();
            #activity process
            Helper::store_activity(Auth::user()->user_id, 'Fee structure(s) deleted from month #'. $month . ' and Session #' . $session_name->name ?? '');
            return redirect()->back()->with('success', 'Fee structure(s) deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }


    public function student_dues_byStudent(Request $request) {
        #checking permission
        $this->authorize('student_dues_list', 54);

        $session_id = $student_id = $flag = "";
        if ($request->has('session_id') && $request->has('student_id')) {
            $session_id = $request->session_id;
            $student_id = $request->student_id;
            $flag = 1;
            $student_info = Student::where('student_id', $student_id)->first();
            if (!$student_info) {
                return redirect(route('stdacc/dues/student'))->with('error', 'No Student Found');
            }
        }

        $header_title = "Student Dues";
        $session_list = SessionModel::getActiveSessions();
        $month_list = MonthsModel::all();
        return view('admin.student_dues.student_dues_bystudent', compact('header_title','month_list','session_list','flag','session_id','student_id'));
    }

    public function student_dues_byClass(Request $request) {
        #checking permission
        $this->authorize('student_dues_list', 54);

        $class_id = $session_id = $flag = $month = null;
        if ($request->has(['class_id','session_id','month']) && is_numeric($request->class_id)) {
            $flag = 1;
            $class_id = $request->class_id;
            $session_id = $request->session_id;
            $month = $request->month;
        }

        # Fetching necessary data
        $header_title = "Student Dues";
        $fees_list = Helper::findFeesByClassMonth($month,$session_id, $class_id);
        $class_list = ClassModel::getActiveClasses();
        $session_list = SessionModel::getActiveSessions();
        $month_list = MonthsModel::all();
        return view('admin.student_dues.student_dues_byclass', compact('header_title','month','fees_list','month_list','flag','class_list', 'session_list', 'class_id', 'session_id'));
    }


    public function student_dues_report(Request $request)
    {
        #checking permission
        $this->authorize('student_dues_list', 54);

        $session_id = $from_month = $to_month = $flag = $class_id = $ac_head_id = $type = null;
        $months = [
            '1' => false,
            '2' => false,
            '3' => false,
            '4' => false,
            '5' => false,
            '6' => false,
            '7' => false,
            '8' => false,
            '9' => false,
            '10' => false,
            '11' => false,
            '12' => false,
        ];
        if ($request->has(['session_id']) && is_numeric($request->session_id) && $request->session_id > 0) {
            $session_id = $request->session_id;
            $from_month = $request->from_month;
            $to_month = $request->to_month;
            $class_id = $request->class_id;
            $ac_head_id = $request->ac_head_id;
            $flag = 1;

            # Swap if fromMonth is greater than toMonth
            if($from_month != null && $to_month != null) {
                if ($from_month > $to_month) {
                    [$from_month, $to_month] = [$to_month, $from_month];
                }
                for ($month = $from_month; $month <= $to_month; $month++) {
                    if ($month != null) {
                        $months[$month] = true;
                    }
                }
            } else {
                for($month = 1; $month <= 12; $month++) {
                    $months[$month] = true;
                }
            }
        }
        $header_title = "Student Dues Report";
        $class_list = ClassModel::getActiveClasses();
        $session_list = SessionModel::getActiveSessions();
        $ac_head_list = ACHeadModel::getIncomeHead();
        $month_list = MonthsModel::all();
        return view('admin.student_dues.student_dues_report', compact('header_title','months','type', 'class_list', 'session_list', 'ac_head_list', 'session_id', 'from_month', 'to_month', 'flag', 'month_list', 'class_id', 'ac_head_id'));
    }
}
