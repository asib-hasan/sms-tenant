<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\TeacherModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MyProfileController extends Controller
{
    public function my_profile(){
        $auth_user = Auth::user();
        $employee_info = TeacherModel::where('employee_id',$auth_user->user_id)->first();
        $header_title = 'My Profile';
        return view('admin.my_profile.my_profile',compact('employee_info','header_title'));
    }

    public function change_password(Request $request){
        $auth_user = Auth::user();
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
        ];

        $messages = [
            'old_password.required' => 'Old password required',
            'new_password.required' => 'New password required',
            'new_password.min' => 'New password must be at least 8 characters',
        ];
        $this->validate($request, $rules, $messages);
        $old_password = $request->old_password;
        if(!Hash::check($old_password,$auth_user->password)){
            return redirect()->back()->with('error','Old password does not match');
        }
        DB::transaction(function() use($request){
            Auth::user()->update([
               'password' => Hash::make($request->new_password),
            ]);

            #store activity
            Helper::store_activity(Auth::user()->user_id,'Password Changed');
        });
        return redirect()->back()->with('success','Password successfully updated');
    }
}
