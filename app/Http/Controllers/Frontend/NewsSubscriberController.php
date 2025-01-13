<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\NewSubscriber;
use App\Mail\Frontend\NewSubscriberMail;
use App\Models\NewsSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class NewsSubscriberController extends Controller
{
    public function store(Request $request)
    {
        $email = $request->validate([
            'email' => 'required|email|unique:news_subscribers',
        ]);

        $NewsSubscriber= NewsSubscriber::create([
            'email' => $request->email,
        ]);
        if(!$NewsSubscriber){
            Session::flash('error','There was an error while subscribing 😥');
            return redirect()->back();
        }

        Session::flash('success','Thanks for subscribed 😊');
        Mail::to($request->email)->send(new NewSubscriberMail());

        return redirect()->back();
    }

}
