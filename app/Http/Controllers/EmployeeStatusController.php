<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AssignTeacherModel;
use App\Models\ModuleModel;
use App\Models\ModuleUserModel;
use App\Models\PermissionModel;
use App\Models\SessionModel;
use App\Models\TeacherModel;
use App\Models\User;
use App\Models\UserPermissionModel;
use http\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeStatusController extends Controller
{
    public function index(Request $request)
    {
        #checking permission
        $this->authorize('employee_status', 85);
        $flag = $employee_info = $employee_id = null;
        if (isset($request->employee_id) && $request->employee_id != null) {
            $flag = 1;
            $employee_id = $request->employee_id;
            $employee_info = TeacherModel::where('employee_id', $employee_id)->first();
            if ($employee_info == null) {
                return redirect(route('hrmgt/employee/status'))->with('error', 'Employee information not found');
            }
        }
        $employee_list = TeacherModel::where('employee_id', '!=', '240018')->get();
        return view('admin.employee_status.index', compact('flag', 'employee_info', 'employee_id','employee_list'));
    }

    public function update(Request $request)
    {
        #checking permission
        $this->authorize('employee_status', 85);

        $status = $request->status;
        $employee_id = Helper::encrypt_decrypt('decrypt', $request->employee_id);
        if ($status == null) {
            return redirect(route('hrmgt/employee/status'))->with('error', 'Status required');
        } else if ($status == 2) {
            if ($request->resign_date == null) {
                return redirect(route('hrmgt/employee/status'))->with('error', 'Resign date required');
            }
            DB::transaction(function () use ($employee_id, $request) {
                TeacherModel::where('employee_id', $employee_id)->update([
                    'status' => $request->status,
                    'resigned_date' => $request->resign_date,
                ]);
                User::where('user_id', $employee_id)->update([
                    'status' => 0,
                ]);
                $user_info = User::where('user_id', $employee_id)->first();
                #delete permissions if not active
                if($request->status != 0) {
                    if ($user_info) {
                        $permissions = PermissionModel::pluck('id')->toArray();
                        $modules = ModuleModel::pluck('id')->toArray();

                        $user_info->permissions()->detach($permissions);
                        $user_info->modules()->detach($modules);
                    }
                }
                #store activity
                Helper::store_activity(Auth::user()->user_id, 'Employee status updated #Resigned employee ID #' . $employee_id);
            });
        } else if($status == 1 || $status == 0) {
            DB::transaction(function () use ($employee_id, $request) {
                TeacherModel::where('employee_id', $employee_id)->update([
                    'status' => $request->status,
                    'resigned_date' => null,
                ]);
                User::where('user_id', $employee_id)->update([
                    'status' => $request->status == 0 ? 1 : 0,
                ]);
                #delete permissions if not active
                if($request->status != 0) {
                    $user_info = User::where('user_id', $employee_id)->first();
                    if ($user_info) {
                        $permissions = PermissionModel::pluck('id')->toArray();
                        $modules = ModuleModel::pluck('id')->toArray();

                        $user_info->permissions()->detach($permissions);
                        $user_info->modules()->detach($modules);
                    }
                }
                Helper::store_activity(Auth::user()->user_id, 'Employee status updated ' . ($request->status == 0 ? '#Active' : '#Inactive') . ' employee ID #' . $employee_id);
            });
        }
        return redirect(route('hrmgt/employee/status'))->with('success', 'Employee status updated successfully');
    }

    public function resigned_records(Request $request){
        #checking permission
        $this->authorize('employee_status', 85);
        $flag = $year = null;
        $resigned_list = collect();
        if (isset($request->year) && $request->year != null) {
            $flag = 1;
            $year = $request->year;
            $resigned_list = TeacherModel::whereYear('resigned_date', $year)->get();
        }
        return view('admin.employee_status.resign_record', compact('flag', 'resigned_list', 'year'));
    }
}
