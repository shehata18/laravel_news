<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\Password\ForgetPasswordController;
use App\Http\Controllers\Admin\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Post\PostController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Auth admin

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login.show');
        Route::post('login/check', 'checkAuth')->name('login.check');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
        Route::controller(ForgetPasswordController::class)->group(function () {
            Route::get('email','showEmailForm')->name('email');
            Route::post('email','sendOTP')->name('sendOTP');
            Route::get('verify/{email}','showOTPForm')->name('showOTPForm');
            Route::post('verify','verifyOTP')->name('verifyOTP');
        });

        Route::controller(ResetPasswordController::class)->group(function () {
            Route::get('reset/{email}','showResetForm')->name('showResetForm');
            Route::post('reset/','resetPassword')->name('reset');
        });

    });

});



Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'auth:admin'
], function () {
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);

    Route::get('users/status/{id}', [UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::get('posts/status/{id}', [PostController::class, 'changeStatus'])->name('posts.changeStatus');
    Route::get('categories/status/{id}', [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');


    Route::get('home',function (){
        return view('dashboard.index');
    })->name('dashboard');


});
