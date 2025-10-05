<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class AuthController extends Controller
{

    public function select(){
        return view('auth.select');
    }
    public function login(){
        Auth::logout();
        return view('auth.login');
    }
    public function Authlogin(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectUser();
        }

        if (Auth::attempt(['user_id' => $request->user_id, 'password' => $request->password], true)) {
            return $this->redirectUser();
        }

        return redirect()->back()->with('error', 'Please enter the correct username and password');
    }

    private function redirectUser()
    {
        $auth_user = Auth::user();
        if ($auth_user->user_type == 1) {
            return redirect(route('dashboard'));
        }
        else if($auth_user->user_type == 2){
            return redirect(route('std/dashboard'));
        }
        else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
