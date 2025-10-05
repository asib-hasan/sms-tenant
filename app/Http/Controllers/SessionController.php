<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\SessionModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class SessionController extends Controller
{
    public function index()
    {
        #checking permission
        $this->authorize('session_list', 2);

        try {
            #getting session list
            $session_list = SessionModel::getSessions();
            $header_title = 'Session';
            return view('admin.session.index', compact('session_list', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
    public function store(Request $request)
    {
        #checking permission
        $this->authorize('session_add', 3);

        $rules = [
            'name' => 'required|max:100|unique:session',
            'status' => 'required',
            'is_current' => 'required',
        ];
        $message = [
            'name.required' => 'Session name required',
            'name.max' => 'Session name max length 100 characters',
            'name.unique' => 'Session already exists',
            'status.required' => 'Status required',
            'is_current.required' => 'Is current required',
        ];
        $this->validate($request, $rules, $message);

        try {
            DB::transaction(function () use ($request) {
                if ($request->is_current == 0) {
                    DB::table('session')->update([
                        'is_current' => 1,
                    ]);
                }
                SessionModel::insert([
                    'name' => trim($request->name),
                    'status' => $request->status,
                    'is_current' => $request->is_current,
                    'created_by' => Auth::user()->user_id,
                ]);
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Session information added #' . trim($request->name));
            });
            return redirect(route('session'))->with('success', 'Session information saved successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        #checking permission
        $this->authorize('session_edit', 4);

        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if ($id > 0 && is_numeric($id)) {
            #validation
            $rules = [
                'name' => ['required', Rule::unique('session')->ignore($id, 'id'), 'max:100'],
                'status' => 'required',
                'is_current' => 'required',
            ];
            $message = [
                'name.required' => 'Session name required',
                'name.max' => 'Session name max length 100 characters',
                'name.unique' => 'Session already exists',
                'status.required' => 'Status required',
                'is_current.required' => 'Is current required',
            ];
            $this->validate($request, $rules, $message);

            try {
                DB::transaction(function () use ($request, $id) {
                    if ($request->is_current == 0) {
                        DB::table('session')->update([
                            'is_current' => 1,
                        ]);
                    }
                    SessionModel::where('id', $id)->update([
                        'name' => trim($request->name),
                        'status' => $request->status,
                        'is_current' => $request->is_current,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Session information updated #' . trim($request->name));
                });
                return redirect(route('session'))->with('success', 'Session information updated successfully');
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
        $this->authorize('session_delete', 5);

        $id = Crypt::decrypt($request->id);
        if ($id > 0 && is_numeric($id)) {
            $session_info = SessionModel::where('id', $id)->first();
            if ($session_info == "") {
                return redirect()->back()->with('error', 'Session information not found');
            }
            $name = $session_info->name;
            $is_deletable = SessionModel::isDeletable($id);
            if ($is_deletable) {
                $session_info->delete();
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Session information deleted #' . trim($name));
                return redirect(route('session'))->with('success', 'Session successfully deleted');
            } else {
                return redirect(route('session'))->with('error', 'Session already in use, Can not be deleted');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
}
