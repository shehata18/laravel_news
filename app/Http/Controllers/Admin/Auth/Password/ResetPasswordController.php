<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function showResetForm($email)
    {
        return view('dashboard.auth.passwords.reset', ['email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|string|min:8',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if(!$admin){
            return redirect()->back()->with(['error' => 'Try again later']);
        }
        $admin->update([
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('admin.login.show')->with('success', 'Password reset successfully');


    }
}
