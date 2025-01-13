<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SettingRequest;
use App\Models\User;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('frontend.dashboard.setting',compact('user'));
    }


    public function update(SettingRequest $request)
    {
        $request->validated();
        $user = User::findOrFail(auth()->user()->id);
        $user->update($request->except(['_token','image']));

        ImageManager::uploadImages($request,null, $user);

        return redirect()->back()->with('success','Profile data Updated Successfully');
    }

    public function changePassword(Request $request)
    {
        $request->validate($this->filterPassword());

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->with('error','Current password does not match');
        }
        $user = User::findOrFail(auth()->user()->id);
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect()->back()->with('success','Password Changed Successfully');

    }

    private static function filterPassword():array
    {
        return [
            'current_password' => ['required'],
            'password' => ['required','confirmed'],
            'password_confirmation' => ['required'],
        ];

    }
}
