<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->only('showLoginForm','checkAuth');
        $this->middleware('auth:admin')->only('logout');

    }
    public function showLoginForm()
    {
        return view('dashboard.auth.login');
    }

    public function checkAuth(Request $request)
    {
        $request->validate($this->filterData());
        if (Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->remember)){
            return redirect()->intended(RouteServiceProvider::AdminHome);
        }
        return redirect()->back()->with('error', 'Credentials doesn\'t match');
    }

    private function filterData():array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
            'remember' => 'in:on,off',
        ];
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login.show');
    }
}
