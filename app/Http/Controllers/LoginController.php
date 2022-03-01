<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $cred = $request->only(['email','password']);
        if (Auth::attempt(['email' => $cred['email'], 'password' => $cred['password']])) {
            activity()->log('Admin "'.Auth::user()->name.'" logged in');
           return redirect()->route('dashboard.home');
        }
        activity()->log('Failed login from this email '.$cred['email']);
        Alert::toast('Please add the right credentials', 'error');
        return back();
    }
}
