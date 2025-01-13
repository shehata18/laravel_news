<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\Dashboard\NotificationController;
use App\Http\Controllers\Frontend\Dashboard\ProfileController;
use App\Http\Controllers\Frontend\Dashboard\SettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsSubscriberController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
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

Route::redirect('/','home');


Route::group([
    'as' => 'frontend.',
], function (){
    Route::get('/home', [HomeController::class, 'index'])->name('index'); // frontend.index
    Route::post('news-subscribe', [NewsSubscriberController::class, 'store'])->name('news.subscribe');
    Route::get('category/{slug}', CategoryController::class)->name('category.posts');

    // Posts Routes
    Route::controller(PostController::class)
        ->prefix('post')
        ->name('post.')
        ->group(function () {
        Route::get('/{slug}', 'show')->name('show');
        Route::get('/comments/{slug}','getAllPosts')->name('getAllComments');
        Route::post('/comments/store', 'saveComment')->name('comments.store');

    });
    // Contact us Routes
    Route::controller(ContactController::class)
        ->name('contact.')
        ->prefix('contact')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::match(['get','post'],'store', 'store')->name('store');


    });

    // Search Route
    Route::match(['get','post'], 'search',SearchController::class)->name('search');

    // UserDashboard Routes
    Route::prefix('user/')
        ->name('dashboard.')
        ->middleware(['auth:web','verified'])->group(function () {
            // manage profile page
        Route::controller(ProfileController::class)->group(function () {
           Route::get('profile', 'index')->name('profile');
           Route::post('post/store', 'store')->name('post.store');
           Route::delete('post/delete', 'deletePost')->name('post.delete');
           Route::get('post/get-comments/{id}','getComments')->name('post.getComments');
           Route::get('post/{slug}/edit', 'showEditForm')->name('post.edit');
           Route::put('post/update', 'updatePost')->name('post.update');
           Route::post('post/image/delete/{image_id}', 'deletePostImage')->name('post.image.delete');
        });
        // Setting Routes
        Route::prefix('setting')->controller(SettingController::class)->group(function () {
            Route::get('', 'index')->name('setting');
            Route::post('/update', 'update')->name('setting.update');
            Route::post('/change-password', 'changePassword')->name('setting.changePassword');
        });
        // Notification Routes
        Route::prefix('notification')->controller(NotificationController::class)->group(function (){
            Route::get('/', 'index')->name('notification');
            Route::post('/mark-all-read','markAllAsRead')->name('notifications.markAllRead');
            Route::get('/{id}/mark-as-read','markAsRead')->name('notifications.markAsRead');
            Route::post('/delete','delete')->name('notifications.delete');
            Route::get('/delete-all','deleteAll')->name('notifications.deleteAll');


        });
    });


});

Route::prefix('email')
    ->name('verification.')
    ->controller(VerificationController::class)
    ->group(function () {
    Route::get('/verify','show')->name('notice');
    Route::get('/verify/{id}/{hash}','verify')->name('verify');
    Route::post('/resend', 'resend')->name('resend');

});

Auth::routes();

