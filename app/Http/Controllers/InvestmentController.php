<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\InvestModel;
use App\Models\SchoolInfoModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        #checking permission
        $this->authorize('invest_list', 68);
        #init
        $name = $voucher_id = null;
        try {
            $investment_list = InvestModel::query();
            if ($request->has('name') && $request->name != null) {
                $name = $request->name;
                $investment_list->where('name', 'Like', '%' . $name . '%');
            }
            if ($request->has('voucher_id') && $request->voucher_id != "") {
                $voucher_id = $request->voucher_id;
                $investment_list->where('id', $voucher_id);
            }
            $totalCost = $investment_list->sum('amount');
            $investment_list = $investment_list->latest()->paginate(10); #get
            $header_title = 'Investment/Donation';
            return view('admin.investment.index', compact('totalCost', 'name', 'investment_list', 'voucher_id', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
    public function add(Request $request)
    {
        #authorization
        $this->authorize('invest_add', 69);

        $header_title = 'Add Investment/Donation';
        return view('admin.investment.add', compact('header_title'));
    }

    public function store(Request $request)
    {

        #checking permission
        $this->authorize('invest_add', 69);

        $rules = [
            'name' => 'required',
            'type' => 'required|numeric',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'payment_type' => 'required',
            'note' => 'nullable|max:255',
        ];

        $message = [
            'name.required' => 'Investor/donor required',
            'type.required' => 'Type required',
            'type.numeric' => 'Type must be a type',
            'amount.required' => 'Amount required',
            'amount.numeric' => 'Amount must be a number',
            'date.required' => 'Date required',
            'date.date' => 'Date format is invalid',
            'note.max' => 'Note must not be greater than 255 characters',
        ];

        $this->validate($request, $rules, $message);

        try {
            DB::transaction(function () use ($request) {
                InvestModel::insert([
                    'name' => $request->name,
                    'type' => $request->type,
                    'amount' => $request->amount,
                    'payment_type' => $request->payment_type,
                    'date' => $request->date,
                    'note' => $request->note,
                    'created_by' => Auth::user()->user_id,
                ]);
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Investment/Donation information added #' . $request->name);
            });
            return redirect(route('genacc/investment'))->with('success', 'Investment/Donation information saved successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $this->authorize('invest_edit', 70);

        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if (is_numeric($id) && $id > 0) {
            $investment_info = InvestModel::where('id', $id)->first();
            if ($investment_info == "") {
                return redirect()->back()->with('error', 'Investment/Donation information not found');
            }
            $header_title = 'Edit Investment/Donation';
            return view('admin.investment.edit', compact('header_title', 'investment_info'));
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function update(Request $request)
    {
        #checking permission
        $this->authorize('invest_edit', 70);

        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if (is_numeric($id) && $id > 0) {
            $rules = [
                'name' => 'required',
                'type' => 'required|numeric',
                'amount' => 'required|numeric',
                'date' => 'required|date',
                'payment_type' => 'required',
                'note' => 'nullable|max:255',
            ];

            $message = [
                'name.required' => 'Investor/donor required',
                'type.required' => 'Type required',
                'type.numeric' => 'Type must be a type',
                'amount.required' => 'Amount required',
                'amount.numeric' => 'Amount must be a number',
                'date.required' => 'Date required',
                'date.date' => 'Date format is invalid',
                'note.max' => 'Note must not be greater than 255 characters',
            ];

            $this->validate($request, $rules, $message);

            try {
                DB::transaction(function () use ($request,$id) {
                    InvestModel::where('id',$id)->update([
                        'name' => $request->name,
                        'type' => $request->type,
                        'amount' => $request->amount,
                        'payment_type' => $request->payment_type,
                        'date' => $request->date,
                        'note' => $request->note,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Investment/Donation information updated #' . $request->name);
                });
                return redirect(route('genacc/investment'))->with('success', 'Investment/Donation information updated successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }

    }

    public function delete(Request $request) {

        #checking permission
        $this->authorize('invest_delete', 70);

        $id = Helper::encrypt_decrypt('decrypt',$request->id);

        if(is_numeric($id) && $id > 0){
            #check
            $investment_info = InvestModel::where('id',$id)->first();
            if($investment_info==""){
                return redirect()->back()->with('error','Investment/Donation information already deleted');
            }
            $investor_name = $investment_info->name;
            try {
                DB::transaction(function () use ($id,$investor_name) {
                    InvestModel::where('id', $id)->delete();
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Investment/Donation information deleted investor #' . $investor_name);
                });
                return redirect(route('genacc/investment'))->with('success', 'Investment/Donation information deleted successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }

    public function print(Request $request) {
        #checking permission
        $this->authorize('invest_voucher', 89);

        $id = Helper::encrypt_decrypt('decrypt',$request->id);

        if(is_numeric($id) && $id > 0){
            #check
            $investment_info = InvestModel::where('id',$id)->first();
            if($investment_info==""){
                return redirect()->back()->with('error','Investment/Donation information already deleted');
            }

            $data = [
                'year' => $request->year,
                'school_info' => SchoolInfoModel::first(),
                'investment_info' => $investment_info,
            ];

            $pdf = PDF::loadView('admin.investment.voucher', $data);
            $file_name ='voucher.pdf';
            return $pdf->stream($file_name);
        }
        else{
            return redirect()->back()->with('error','Invalid parameter or request');
        }
    }
}
