<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ACHeadModel;
use App\Models\MisCostModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MisCostController extends Controller
{
    public function index(Request $request) {
        #checking permission
        $this->authorize('misc_list', 64);
        #init
        $ac_head_id = $receipt_no = "";
        try {
            $cost_list = MisCostModel::query();
            if($request->has('ac_head_id') && $request->ac_head_id!=""){
                $ac_head_id = $request->ac_head_id;
                $cost_list->where('ac_head_id',$ac_head_id);
            }
            if($request->has('receipt_no') && $request->receipt_no!=""){
                $receipt_no = $request->receipt_no;
                $cost_list->where('receipt_no',$receipt_no);
            }
            $totalCost = $cost_list->sum('amount');
            $cost_list = $cost_list->latest()->paginate(10); #get
            $ac_head_list = ACHeadModel::getExpenseHead();
            $header_title = 'Miscellaneous Cost';
            return view('admin.mis_cost.index', compact('totalCost','cost_list','ac_head_id','ac_head_list','receipt_no','header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }


    public function add(Request $request){
        #authorization
        $this->authorize('misc_add',65);

        #getting ac head list
        $ac_head_list = ACHeadModel::getExpenseHead();
        $header_title = 'Add Miscellaneous Cost';
        return view('admin.mis_cost.add',compact('ac_head_list','header_title'));
    }

    public function store(Request $request) {
        #checking permission
        $this->authorize('misc_add', 65);

        $rules = [
            'ac_head_id' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'note' => 'nullable|max:255',
            'receipt_no' => 'nullable|max:100',
        ];

        $message = [
            'ac_head_id.required' => 'Account head required',
            'amount.required' => 'Amount required',
            'amount.numeric' => 'Amount must be a number',
            'date.required' => 'Date required',
            'date.date' => 'Date format is invalid',
            'note.max' => 'Note must not be greater than 255 characters',
            'receipt_no.max' => 'Receipt number must not be greater than 100 characters',
        ];

        $this->validate($request, $rules, $message);

        try {
            $head_name = "";
            $head_name = ACHeadModel::where('id',$request->ac_head_id)->value('name');
            DB::transaction(function () use ($request,$head_name) {
                MisCostModel::insert([
                    'ac_head_id' => $request->ac_head_id,
                    'amount' => $request->amount,
                    'date' => $request->date,
                    'note' => $request->note,
                    'receipt_no' => $request->receipt_no,
                    'created_by' => Auth::user()->user_id,
                ]);
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Miscellaneous cost information added #' . $head_name);
            });
            return redirect(route('genacc/miscellaneous/cost'))->with('success', 'Miscellaneous cost information saved successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function edit(Request $request){
        $this->authorize('misc_edit',66);

        $id = Helper::encrypt_decrypt('decrypt',$request->id);
        if(is_numeric($id) && $id > 0){
            $cost_info = MisCostModel::where('id',$id)->first();
            if($cost_info==""){
                return redirect()->back()->with('error','Miscellaneous cost information not found');
            }
            $ac_head_list = ACHeadModel::getExpenseHead();
            $header_title = 'Miscellaneous Cost Edit';
            return view('admin.mis_cost.edit',compact('ac_head_list','header_title','cost_info'));
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }

    public function update(Request $request) {

        #checking permission
        $this->authorize('misc_edit', 66);

        $id = Helper::encrypt_decrypt('decrypt',$request->id);

        if(is_numeric($id) && $id > 0){
            $rules = [
                'ac_head_id' => 'required',
                'amount' => 'required|numeric',
                'date' => 'required|date',
                'note' => 'nullable|max:255',
                'receipt_no' => 'nullable|max:100',
            ];

            $message = [
                'ac_head_id.required' => 'Account head required',
                'amount.required' => 'Amount required',
                'amount.numeric' => 'Amount must be a number',
                'date.required' => 'Date required',
                'date.date' => 'Date format is invalid',
                'note.max' => 'Note must not be greater than 255 characters',
                'receipt_no.max' => 'Receipt number must not be greater than 100 characters',
            ];

            $this->validate($request, $rules, $message);

            try {
                $head_name = "";
                $head_name = ACHeadModel::where('id',$request->ac_head_id)->value('name');
                DB::transaction(function () use ($request,$id,$head_name) {
                    MisCostModel::where('id', $id)->update([
                        'ac_head_id' => $request->ac_head_id,
                        'amount' => $request->amount,
                        'date' => $request->date,
                        'note' => $request->note,
                        'receipt_no' => $request->receipt_no,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Miscellaneous cost information updated #' . $head_name);
                });
                return redirect(route('genacc/miscellaneous/cost'))->with('success', 'Miscellaneous cost information updated successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }

    public function delete(Request $request) {

        #checking permission
        $this->authorize('misc_delete', 67);

        $id = Helper::encrypt_decrypt('decrypt',$request->id);

        if(is_numeric($id) && $id > 0){
            #check
            $cost_info = MisCostModel::where('id',$id)->first();
            if($cost_info==""){
                return redirect()->back()->with('error','Miscellaneous cost information already deleted');
            }

            try {
                $head_name = "";
                $head_name = ACHeadModel::where('id',$cost_info->ac_head_id)->value('name');
                DB::transaction(function () use ($id,$head_name) {
                    MisCostModel::where('id', $id)->delete();
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Miscellaneous cost information deleted #' . $head_name);
                });
                return redirect(route('genacc/miscellaneous/cost'))->with('success', 'Miscellaneous cost information deleted successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }

}
