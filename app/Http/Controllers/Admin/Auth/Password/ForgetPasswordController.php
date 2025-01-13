<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\SendotpNotify;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;



class ForgetPasswordController extends Controller
{
    public $otp2;
    public function __construct()
    {
        $this->otp2 = new Otp();

    }
    public function showEmailForm()
    {
        return view('dashboard.auth.passwords.email');
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $admin = Admin::where('email', $request->email)->first();
        if(!$admin){
            return redirect()->back()->withErrors(['email' => 'Try again later!']);
        }
        $admin->notify(new SendotpNotify());
        return redirect()->route('admin.password.showOTPForm',['email'=>$admin->email])->with('message', 'We have sent an OTP to your email');



    }

    public function showOTPForm($email)
    {
        return view('dashboard.auth.passwords.confirm',['email'=>$email]);
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|min:6',
        ]);
        $otp = $this->otp2->validate($request->email,$request->token);

        if ($otp->status == false) {
            return redirect()
                ->back()
                ->withErrors(['token' => 'The OTP is invalid or has expired.']);
        }
        return redirect()->route('admin.password.showResetForm',['email'=>$request->email]);



    }





}
