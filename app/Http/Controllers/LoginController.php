<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function login(Request $request)
{
    $username = $request->input('customer_name');
    $email = $request->input('email');
    $password = $request->input('password');

    // find user first (without password)
    $user = Customers::where('customer_name', $username)
                ->where('email', $email)
                ->first();

    // check password correctly
    if ($user && $password === $user->password) {
        $cusid = $user->customer_id;
        $cusname = $user->customer_name;
        session(['name' => $cusname, 'id' => $cusid]);
        return Redirect::to('welcome');
    } else {
        return back()->with('error', 'Invalid credentials');
    }

}

}

