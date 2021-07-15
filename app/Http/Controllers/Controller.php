<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function profile()
    {
        return view('profile');
    }

    public function login_to(Request $request)
    {
        $this->validate($request,[
            'email' => ['required','email','exists:users,email'],
            'password' => ['required','min:8']
        ]);

        $info = $request->only('email','password');
        if(Auth::guard('web')->attempt($info)){
            return redirect()->route('user.profile');
        }
    }

    public function login_to_admin(Request $request)
    {
        $this->validate($request,[
            'email' => ['required','email','exists:admins,email'],
            'password' => ['required','min:8']
        ]);

        $info = $request->only('email','password');
        if(Auth::guard('admin')->attempt($info)){
            return redirect()->route('admin.dashboard');
        }
    }

    public function login_to_customer(Request $request)
    {
        $this->validate($request,[
            'email' => ['required','email','exists:customers,email'],
            'password' => ['required','min:8']
        ]);

        $info = $request->only('email','password');
        if(Auth::guard('customer')->attempt($info)){
            return redirect()->route('customer.dashboard');
        }
    }
}
