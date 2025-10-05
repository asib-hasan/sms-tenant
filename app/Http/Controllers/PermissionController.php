<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\ModuleUserModel;
use App\Models\PermissionModel;
use App\Models\TeacherModel;
use App\Models\User;
use App\Models\UserPermissionModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PermissionController extends Controller
{
    public function setup(Request $request){
        $this->authorize('setup_permission', 1);

        $flag = $employee_id = $user_id = $employee_info = null;
        if($request->employee_id != null){
            $employee_id = $request->employee_id;
            $flag = 1;
            $employee_info = TeacherModel::where('employee_id',$employee_id)->first();
            if(!$employee_info){
                return redirect()->back()->with('error','Employee information not found');
            }
            $user_info = User::where('user_id',$employee_id)->first();
            if(!$user_info){
                return redirect()->back()->with('error','Something went wrong!');
            }
            $user_id = $user_info->id;
        }
        $header_title = 'Setup Permission';

        return view('admin.hrm_setup.permission',compact('flag','employee_id','header_title','user_id','employee_info'));
    }

    public function save(Request $request)
    {
        // Check authorization
        $this->authorize('setup_permission', 1);

        // Retrieve and decrypt the user ID
        $user_id = Helper::encrypt_decrypt('decrypt', $request->user_id);
        $user = User::findOrfail($user_id);
        $checked_file = $request->input('checked_file', []);
        $checked_module = $request->input('checked_module', []);

        // Get existing permissions for the user
        $existing_permissions = $user->permissions()->pluck('permission_id')->toArray();

        // Find permissions to remove
        $permissions_to_remove = array_diff($existing_permissions, $checked_file);

        // Remove unchecked permissions
        if (!empty($permissions_to_remove)) {
            $user->permissions()->detach($permissions_to_remove);
        }

        // Process modules
        $existing_modules = $user->modules()->pluck('module_id')->toArray();
        $modules_to_remove = array_diff($existing_modules, $checked_module);
        if (!empty($modules_to_remove)) {
            $user->modules()->detach($modules_to_remove);
        }

        // Add new modules

        try {
            DB::transaction(function () use ($user_id, $checked_module) {
                foreach ($checked_module as $module_id) {
                    $exists = ModuleUserModel::where('user_id', $user_id)
                        ->where('module_id', $module_id)
                        ->exists();
                    if (!$exists) {
                        ModuleUserModel::create([
                            'user_id' => $user_id,
                            'module_id' => $module_id,
                        ]);
                    }
                }
            });
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for module - ' . $ex->getMessage());
        }

        // Add new permissions
        try {
            DB::transaction(function () use ($user_id, $checked_file) {
                foreach ($checked_file as $permission_id) {
                    $exists = UserPermissionModel::where('user_id', $user_id)
                        ->where('permission_id', $permission_id)
                        ->exists();
                    if (!$exists) {
                        UserPermissionModel::create([
                            'user_id' => $user_id,
                            'permission_id' => $permission_id,
                        ]);
                    }
                }
            });
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for files- ' . $ex->getMessage());
        }
        Helper::store_activity(Auth::user()->user_id, 'Permission updated for ID#' . trim($user->user_id));
        return redirect()->back()->with('success', 'Permission set up successfully');
    }

}
