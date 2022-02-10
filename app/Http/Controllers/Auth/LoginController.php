<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
            'remember'=>'nullable',
        ]);
        $remember = isset($data['remember']);
        unset($data['remember']);
        if (Auth::attempt($data, $remember)){
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }
        return back()->withErrors([
            'msg'=>'The provided credentials are not correct'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return '#LOGIN';
    }
}
