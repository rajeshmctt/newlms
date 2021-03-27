<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignController;

use App\Http\Controllers\UserForgotPasswordController;
use App\Http\Controllers\FacultyForgotPasswordController;
use App\Http\Controllers\AdminForgotPasswordController;

use App\Http\Controllers\UserResetPasswordController;
use App\Http\Controllers\FacultyResetPasswordController;
use App\Http\Controllers\AdminResetPasswordController;


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

Route::group(['middleware' => ['view.data']], function(){

Route::group(['middleware' => ['guest:web,faculty,admin']], function(){
    Route::get('/', [AccountController::class, 'login'])->name('login');
    Route::post('/', [AccountController::class, 'do_login'])->name('do.login');

    Route::get('forgot-password', [AccountController::class, 'forgot_password'])->name('forgot_password');
    Route::post('forgot-password', [AccountController::class, 'do_forgot_password'])->name('do.forgot_password');

    Route::get('reset-password', [AccountController::class, 'reset_password'])->name('reset_password');
    Route::post('reset-password', [AccountController::class, 'do_reset_password'])->name('do.reset_password');

    // Route::get('forgot-password', [UserForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot_password');
    // Route::get('forgot-password/faculty', [FacultyForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot_password.faculty');
    // Route::get('forgot-password/admin', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot_password.admin');

    // Route::post('forgot-password', [UserForgotPasswordController::class, 'sendResetLink'])->name('do.forgot_password');
    // Route::post('forgot-password/faculty', [FacultyForgotPasswordController::class, 'sendResetLink'])->name('do.forgot_password.faculty');
    // Route::post('forgot-password/admin', [AdminForgotPasswordController::class, 'sendResetLink'])->name('do.forgot_password.admin');

    // Route::put('forgot-password', [UserResetPasswordController::class, 'showResetForm'])->name('update.forgot_password');
    // Route::put('forgot-password/faculty', [FacultyResetPasswordController::class, 'showResetForm'])->name('update.forgot_password.faculty');
    // Route::put('forgot-password/admin', [AdminResetPasswordController::class, 'showResetForm'])->name('update.forgot_password.admin');


    // Route::get('reset-password', [UserResetPasswordController::class, 'showResetForm']);
    // Route::get('faculty-reset-password', [FacultyResetPasswordController::class, 'showResetForm']);
    // Route::get('admin-reset-password', [AdminResetPasswordController::class, 'showResetForm']);
    
    // Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');
});

Route::group(['middleware' => ['auth:web,faculty,admin']], function(){
    Route::get('logout', [DashboardController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('download', function(Request $request){
        return Storage::download('public/'.$request->input('file'));
    })->name('download');
});

});