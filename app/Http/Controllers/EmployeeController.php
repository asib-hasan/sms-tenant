<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\DesignationModel;
use App\Models\SchoolInfoModel;
use App\Models\TeacherModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDF;

class EmployeeController extends Controller
{
    public function index()
    {
        #checking permission
        $this->authorize('emp_list', 42);

        try {
            $employee_id = $designation_id = $name = "";
            $header_title = 'Employee';
            $employee_list = TeacherModel::getEmployees();
            $designation_list = DesignationModel::getActiveDesignations();
            return view('admin.employee.index', compact('employee_list', 'designation_list', 'header_title','employee_id','name','designation_id'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }

    }

    public function search(Request $request)
    {
        #checking permission
        $this->authorize('emp_list', 42);

        try {
            $employee_id = $designation_id = $name = '';
            $header_title = 'Employee';
            $employee_list = TeacherModel::query();
            $designation_list = DesignationModel::getActiveDesignations();

            if (isset($request->employee_id) && $request->employee_id != "") {
                $employee_id = $request->employee_id;
                $employee_list->where('employee_id', $employee_id);
            }
            if (isset($request->designation_id) && $request->designation_id != "") {
                $designation_id = $request->designation_id;
                $employee_list->where('designation_id', $designation_id);
            }
            if (isset($request->name) && $request->name != "") {
                $name = $request->name;
                $employee_list->where('first_name', 'like', "%$name%");
            }
            $employee_list = $employee_list->where('employee_id','!=','240018')->where('status',0)->get();
            return view('admin.employee.index', compact('name', 'designation_id', 'employee_id', 'employee_list', 'designation_list', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function emp_list_pdf(Request $request)
    {
        #checking permission
        $this->authorize('emp_list', 42);

        try {
            $employee_list = TeacherModel::query();
            if ($request->employee_id != "") {
                $employee_id = $request->employee_id;
                $employee_list->where('employee_id', $employee_id);
            }
            if ($request->designation_id != "") {
                $designation_id = $request->designation_id;
                $employee_list->where('designation_id', $designation_id);
            }
            if ($request->name != "") {
                $name = $request->name;
                $employee_list->where('first_name', 'like', "%$name%");
            }
            $employee_list = $employee_list->where('employee_id','!=','240018')->where('status',0)->get();
            $data = [
                'school_info'  => SchoolInfoModel::first(),
                'employee_list' => $employee_list,
            ];
            $pdf = PDF::loadView('admin.employee.employee_list_pdf', $data);
            $file_name ='Employee List.pdf';
            return $pdf->stream($file_name);
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function add()
    {
        #checking permission
        $this->authorize('emp_add', 43);

        try {
            $header_title = 'New Employee';
            $designation_list = DesignationModel::getActiveDesignations();
            return view('admin.employee.add', compact('designation_list', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function profile_search(Request $request)
    {
        #checking permission
        $this->authorize('emp_profile', 46);

        try {
            $employee_id = null;
            if($request->employee_id != null){
                $employee_id = $request->employee_id;
                $employee_info = TeacherModel::where('employee_id', $employee_id)->first(['id','employee_id']);
                if(!$employee_info){
                    return redirect()->back()->with('error', 'Employee information not found');
                }
                return redirect()->route('empmgt/employee/view', ['id' => Helper::encrypt_decrypt('encrypt', $employee_info->id)]);
            }
            $header_title = 'Employee Profile';
            return view('admin.employee.profile_search', compact('employee_id','header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function store(Request $request)
    {
        #checking permission
        $this->authorize('emp_add', 43);

        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'nullable|max:255',
            'gender' => 'required|string|max:10',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'designation_id' => 'required|integer',
            'joiningdate' => 'required|date_format:Y-m-d',
            'national_id' => 'nullable',
            'email' => 'nullable|string|email|max:255',
            'blood_group' => 'nullable',
            'type' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $joiningDate = $request->joiningdate;
        $year = Carbon::createFromFormat('Y-m-d', $joiningDate)->format('y');
        $numberOfEmp = TeacherModel::where('year', $year)->count() + 1;
        $makeEmpId = sprintf('%s%04d', $year, $numberOfEmp);

        try {
            DB::transaction(function () use ($request, $makeEmpId, $year) {
                $imageFilename = null;

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $imageFilename = time() . '.' . $file->getClientOriginalExtension();
                    $file->move('uploads/teachers', $imageFilename);
                }
                $employee = TeacherModel::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'designation_id' => $request->designation_id,
                    'joiningdate' => $request->joiningdate,
                    'national_id' => $request->national_id,
                    'email' => $request->email,
                    'blood_group' => $request->blood_group,
                    'type' => $request->type,
                    'image' => $imageFilename,
                    'employee_id' => $makeEmpId,
                    'year' => $year,
                    'created_by' => Auth::user()->user_id,
                ]);

                User::create([
                    'user_id' => $makeEmpId,
                    'emp_id_primary' => $employee->id,
                    'password' => Hash::make('asib7788'),
                    'user_type' => 1,
                ]);

                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Employee information added ID#' . trim($makeEmpId));
            });

            return redirect(route('empmgt/employee'))->with('success', 'Employee information added successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function edit(Request $request)
    {
        #checking permission
        $this->authorize('emp_edit', 44);
        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if ($id <= 0 && !is_numeric($id)) {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
        try {
            $employee_info = TeacherModel::where('id', $id)->first();
            if ($employee_info == "") {
                return redirect()->back()->with('error', 'Employee information not found');
            }
            $header_title = 'Edit Employee';
            $designation_list = DesignationModel::getActiveDesignations();
            return view('admin.employee.edit', compact('employee_info', 'designation_list', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        #checking permission
        $this->authorize('emp_edit', 44);
        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if ($id > 0 && is_numeric($id)) {
            $employee_info = TeacherModel::where('id', $id)->first();
            if ($employee_info == "") {
                return redirect()->back()->with('error', 'Employee information not found');
            }
            # Validation
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'gender' => 'required|string|max:10',
                'phone' => 'required|string|max:15',
                'address' => 'nullable|string|max:255',
                'designation_id' => 'required|integer',
                'joiningdate' => 'required|date_format:Y-m-d',
                'national_id' => 'nullable',
                'blood_group' => 'nullable',
                'email' => 'nullable|string|email|max:255',
                'type' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);

            try {
                DB::transaction(function () use ($request, $employee_info) {
                    $imageFilename = $employee_info->image;
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $imageFilename = time() . '.' . $file->getClientOriginalExtension();
                        $file->move('uploads/teachers', $imageFilename);
                        if ($employee_info->image && file_exists('uploads/teachers/' . $employee_info->image)) {
                            unlink('uploads/teachers/' . $employee_info->image);
                        }
                    }
                    $employee_info->update([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'gender' => $request->gender,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'designation_id' => $request->designation_id,
                        'joiningdate' => $request->joiningdate,
                        'national_id' => $request->national_id,
                        'blood_group' => $request->blood_group,
                        'email' => $request->email,
                        'type' => $request->type,
                        'image' => $imageFilename,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    Helper::store_activity(Auth::user()->user_id, 'Employee information updated for ID#' . trim($employee_info->employee_id));
                });
                return redirect(route('empmgt/employee'))->with('success', 'Employee information updated successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }

    public function view(Request $request)
    {
        #checking permission
        $this->authorize('emp_profile', 46);
        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if ($id > 0 && is_numeric($id)) {
            try {
                $employee_info = TeacherModel::where('id',$id)->first();
                if($employee_info==""){
                    return redirect(route('empmgt/employee'))->with('error','Employee information not found');
                }
                $header_title = 'Profile of ' . $employee_info->first_name . ' ' . $employee_info->last_name;
                return view('admin.employee.view', compact('employee_info','header_title'));
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        }
        else{
            return redirect()->back()->with('Error','Invalid parameter or request');
        }
    }
}
