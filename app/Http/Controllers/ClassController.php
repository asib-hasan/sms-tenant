<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\Student;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function index()
    {
        #getting auth user data
        $auth_user = Auth::user();
        if ($auth_user) {
            $this->authorize('class_list', 12);

            $data['header_title'] = "Class";
            $data['getRecord'] = ClassModel::orderby('name')->get();
            return view('admin.class.list', $data);
        } else {
            Auth::logout();
            return redirect(route('home'))->with('error', 'Login session expired');
        }
    }
    public function store(Request $request)
    {
        $auth_user = Auth::user();
        #check permission
        $this->authorize('class_add', 13);

        $rules = [
            'class' => 'required',
            'status' => 'required',
        ];
        $message = [
            'class.required' => 'Class is required',
            'status.required' => 'Status is required',
        ];

        $this->validate($request, $rules, $message);
        $name = $request->class . ' - ' . $request->section;

        if (ClassModel::where('name', $name)->first()) {
            return redirect(route('admin/class'))->with('error', 'Class already exists');
        }
        try {
            DB::transaction(function () use ($request, $name) {
                ClassModel::insert([
                    'name' => $name,
                    'status' => $request->status,
                    'created_by' => Auth::user()->user_id,
                ]);
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Class information added #' . trim($name));
            });
            return redirect(route('admin/class'))->with('success', 'Class information saved successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
    public function update(Request $request)
    {
        $this->authorize('class_edit', 14);

        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        try {
            DB::transaction(function () use ($request, $id) {
                ClassModel::where('id', $id)->update([
                    'status' => $request->status,
                    'updated_by' => Auth::user()->user_id,
                ]);
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Class status updated #' . (($request->status == 0) ? 'active' : 'inactive'));
            });
            return redirect(route('admin/class'))->with('success', 'Class information updated successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
    public function delete(Request $request)
    {

        $this->authorize('class_delete', 15);
        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        $class_info = ClassModel::where('id', $id)->first();
        if (!$class_info) {
            return redirect(route('admin/class'))->with('error', 'Class information not found');
        }
        $name = $class_info->name;
        $isDeletable = ClassModel::isDeletable($id);
        if ($isDeletable) {
            $class_info->delete();
            #activity process
            Helper::store_activity(Auth::user()->user_id, 'Class information deleted #' . trim($name));
            return redirect(route('admin/class'))->with('success', 'Class successfully deleted');
        } else {
            return redirect(route('admin/class'))->with('error', 'Class already in use, Can not be deleted');
        }
    }
}
