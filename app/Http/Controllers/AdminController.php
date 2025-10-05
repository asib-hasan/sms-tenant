<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;   
class AdminController extends Controller
{
    
    public function list(){
        $data['header_title'] = "Admin List";
        $data['getRecord'] = User::where('user_type',1)->get();
        //dd($data['getRecord']->count());
        return view('admin.admin.list',$data);
    }
    public function add(){
        $data['header_title'] = "New Admin";
        
        return view('admin.admin.add',$data);
    }
    public function insert(Request $request){
        $request->validate([
            'email'=>'required|email|unique:users',
            'name' =>'required',
            'password'=> 'required|min:8',
        ]);
        
        $user = new User();
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/users', $filename);
            $user->photo = $filename;
        }
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->save();
        return redirect('admin/admin/list')->with('success','Admin successfully created');
    }
    public function edit($id){
        $data['getRecord'] = $data['getRecord'] = User::getSingle($id);
        if(!empty($data['getRecord'])){
            $data['header_title'] = "Edit Admin";
            return view('admin.admin.edit',$data);
        }
        else{
            abort(404);
        }   
    }
    public function update($id, Request $request){
        $temp = $request->email;
        $user =  User::getSingle($id);
        $isemailfound = $user->email;
        
        if($isemailfound!=$temp){
                $request->validate([
                'email'=>'required|email|unique:users',
                'name' =>'required',
                'password'=> 'required|min:8',
            ]);
        } 
        else{
                $request->validate([
                'name' =>'required',
                'password'=> 'required|min:8',
            ]);
        } 
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/users', $filename);
            $user->photo = $filename;
        }
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->save();
        return redirect('admin/admin/list')->with('success','Admin successfully updated');
    }
    public function delete($id){
        $user =  User::getSingle($id);
        $user->delete();
        return redirect('admin/admin/list')->with('success','Admin successfully deleted');
    }
}
