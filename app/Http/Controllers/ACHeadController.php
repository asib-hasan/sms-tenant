<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\ACHeadModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ACHeadController extends Controller
{
    public function index()
    {
        #checking permission
        $this->authorize('subject_list', 24);

        try {
            #getting head list
            $head_list = ACHeadModel::getRecord();
            $header_title = 'Account Head';
            return view('admin.ac_head.index', compact('head_list', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function store(Request $request)
    {
        #checking permission
        $this->authorize('subject_add', 25);

        $rules = [
            'name' => 'required|max:255|unique:ac_head',
            'category_type' => 'required',
            'status' => 'required',
        ];
        $message = [
            'name.required' => 'Account head name required',
            'category_type.required' => 'Category type required',
            'name.max' => 'Account head name max length 255 characters',
            'name.unique' => 'Account head already exists',
            'status.required' => 'Status required',
        ];
        $this->validate($request, $rules, $message);

        try {
            DB::transaction(function () use ($request) {
                ACHeadModel::insert([
                    'name' => trim($request->name),
                    'category_type' => $request->category_type,
                    'status' => $request->status,
                    'created_by' => Auth::user()->user_id,
                ]);
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Account head information added #' . trim($request->name));
            });
            return redirect(route('account/head'))->with('success', 'Account head information saved successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        #checking permission
        $this->authorize('subject_edit', 26);

        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if ($id > 0 && is_numeric($id)) {
            #validation
            $rules = [
                'name' => ['required', Rule::unique('ac_head')->ignore($id, 'id'), 'max:255'],
                'category_type' => 'required',
                'status' => 'required',
            ];
            $message = [
                'name.required' => 'Account head name required',
                'category_type.required' => 'Category type required',
                'name.max' => 'Account head name max length 255 characters',
                'status.required' => 'Status required',
            ];
            $this->validate($request, $rules, $message);

            try {
                DB::transaction(function () use ($request, $id) {
                    ACHeadModel::where('id', $id)->update([
                        'name' => trim($request->name),
                        'category_type' => $request->category_type,
                        'status' => $request->status,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Account head information updated #' . trim($request->name));
                });
                return redirect(route('account/head'))->with('success', 'Account head information updated successfully');
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
        $this->authorize('subject_edit', 26);

        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if ($id > 0 && is_numeric($id)) {
            $head_info = ACHeadModel::where('id', $id)->first();
            if ($head_info == null) {
                return redirect()->back()->with('error', 'Account head information not found');
            }
            $name = $head_info->name;
            $is_deletable = ACHeadModel::isDeletable($id);
            if ($is_deletable) {
                try {
                    DB::transaction(function () use ($id, $name) {
                        ACHeadModel::where('id', $id)->delete();
                        #activity process
                        Helper::store_activity(Auth::user()->user_id, 'Account head information deleted #' . trim($name));
                    });
                    return redirect()->back()->with('success', 'Account head information deleted successfully');
                } catch (QueryException $ex) {
                    return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
                }
            } else {
                return redirect(route('account/head'))->with('error', 'Account head already in use, Can not be deleted');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
}







