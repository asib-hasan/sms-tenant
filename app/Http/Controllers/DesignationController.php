<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\DesignationModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DesignationController extends Controller
{
    public function index()
    {
        #checking permission
        $this->authorize('designation_list', 6);

        try {
            #getting designation list
            $designation_list = DesignationModel::getDesignations();
            $header_title = 'Designation';
            return view('admin.designation.index', compact('designation_list', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
    public function store(Request $request)
    {
        #checking permission
        $this->authorize('designation_add', 7);

        $rules = [
            'name' => 'required|max:100|unique:designation',
            'status' => 'required',
        ];
        $message = [
            'name.required' => 'Designation name required',
            'name.max' => 'Designation name max length 100 characters',
            'name.unique' => 'Designation already exists',
            'status.required' => 'Status required',
        ];
        $this->validate($request, $rules, $message);

        try {
            DB::transaction(function () use ($request) {
                DesignationModel::insert([
                    'name' => trim($request->name),
                    'status' => $request->status,
                    'created_by' => Auth::user()->user_id,
                ]);
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Designation information added #' . trim($request->name));
            });
            return redirect(route('designation'))->with('success', 'Designation information saved successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        #checking permission
        $this->authorize('designation_edit', 8);

        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if ($id > 0 && is_numeric($id)) {
            #validation
            $rules = [
                'name' => ['required', Rule::unique('designation')->ignore($id, 'id'), 'max:100'],
                'status' => 'required',
            ];
            $message = [
                'name.required' => 'Designation name required',
                'name.max' => 'Designation name max length 100 characters',
                'name.unique' => 'Designation already exists',
                'status.required' => 'Status required',
            ];
            $this->validate($request, $rules, $message);
            try {
                DB::transaction(function () use ($request, $id) {
                    DesignationModel::where('id', $id)->update([
                        'name' => trim($request->name),
                        'status' => $request->status,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Designation information updated #' . trim($request->name));
                });
                return redirect(route('designation'))->with('success', 'Designation information updated successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
    public function delete(Request $request)
    {
        #checking permission
        $this->authorize('designation_delete', 9);

        $id = Crypt::decrypt($request->id);
        if ($id > 0 && is_numeric($id)) {
            $designation_info = DesignationModel::where('id', $id)->first();
            if ($designation_info == "") {
                return redirect()->back()->with('error', 'Designation information not found');
            }
            $name = $designation_info->name;
            $is_deletable = DesignationModel::isDeletable($id);
            if ($is_deletable) {
                $designation_info->delete();
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Designation information deleted #' . trim($name));
                return redirect(route('designation'))->with('success', 'Designation successfully deleted');
            } else {
                return redirect(route('designation'))->with('error', 'Designation already in use, Can not be deleted');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
}
