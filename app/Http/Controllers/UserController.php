<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function showLoginForm(){
        return view('auth.login');
    }

    public function showRegisterForm(){
        return view('auth.register');
    }

    public function login(Request $request, $user_id){
        $request->validate([
            'email'=>'sometimes|nullable|email|unique:users,email',
            'password'=>'required|string|min:8|confirmed',
        ]);

        User::find($user_id);

    }
}
