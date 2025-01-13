<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact-us');
    }

    public function store(ContactRequest $request)
    {
        $request->validated();
        $request->merge([
            'ip_address' => $request->ip(),
        ]);
        $contact = Contact::create($request->except('_token'));
        if (!$contact){
            Session::flash('error', 'Something went wrong');
            return redirect()->back();
        }
        Session::flash('success', 'Your message was sent successfully');
        return redirect()->back();
    }
}
