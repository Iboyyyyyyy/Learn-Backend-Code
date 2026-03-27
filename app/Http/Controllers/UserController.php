<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function login(){
        return view('login');
    }
    public function logininput(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');

        // echo $username." ".$email." ".$password;

        $user = User::where([['name', $username], ['email', $email], ['password', $password]])->first();
        if ($user) {
            // Login successful
            return view('welcome');
            // return response()->json(['message' => 'Login successful']);

        } else {
            // Login failed
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}
