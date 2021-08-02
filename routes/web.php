<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('logout',[App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout.auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//facebook LOGIN
Route::get('login/facebook',[App\Http\Controllers\Auth\LoginController::class,'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback',[App\Http\Controllers\Auth\LoginController::class,'handleFacebookCallback']);

//Github LOGIN
Route::get('login/github',[App\Http\Controllers\Auth\LoginController::class,'redirectToGithub'])->name('login.github');
Route::get('login/github/callback',[App\Http\Controllers\Auth\LoginController::class,'handleGithubCallback']);

// Google login
Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

// LinkedIn Login
Route::get('login/linkedin', [App\Http\Controllers\Auth\LoginController::class, 'redirectToLinkedin'])->name('login.linkedin');
Route::get('login/linkedin/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleLinkedinCallback']);



// ======================Custom Login==============================================
Route::get('/login/admin', [App\Http\Controllers\Authentic\LoginController::class, 'showAdminLoginForm']);
Route::get('/login/blogger', [App\Http\Controllers\Authentic\LoginController::class,'showBloggerLoginForm']);
Route::get('/register/admin', [App\Http\Controllers\Authentic\RegisterController::class,'showAdminRegisterForm']);
Route::get('/register/blogger', [App\Http\Controllers\Authentic\RegisterController::class,'showBloggerRegisterForm']);

Route::post('/login/admin', [App\Http\Controllers\Authentic\LoginController::class,'adminLogin']);
Route::post('/login/blogger', [App\Http\Controllers\Authentic\LoginController::class,'bloggerLogin']);
Route::post('/register/admin', [App\Http\Controllers\Authentic\RegisterController::class,'createAdmin']);
Route::post('/register/blogger', [App\Http\Controllers\Authentic\RegisterController::class,'createBlogger']);

Route::group(['middleware' => 'auth:blogger'], function () {
    Route::view('/blogger', 'blogger');
});

Route::group(['middleware' => 'auth:admin'], function () {
    
    Route::view('/admin', 'admin');
});

Route::post('/authentic/logout', [App\Http\Controllers\Authentic\LoginController::class,'logout'])->name('adminBloggerLogout');