<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Faculty\AccountController;
use App\Http\Controllers\Faculty\DashboardController;
use App\Http\Controllers\Faculty\ProgramController;
use App\Http\Controllers\Faculty\BatchController;
use App\Http\Controllers\Faculty\MentorCoachBatchController;
use App\Http\Controllers\Faculty\UserController;
use App\Http\Controllers\Faculty\MentorCoachUserController;
use App\Http\Controllers\Faculty\ApprovalController;
use App\Http\Controllers\Faculty\MentorCoachApprovalController;
use App\Http\Controllers\Faculty\BatchUserAssignmentController;
use App\Http\Controllers\Faculty\FacultyResourceController;
use App\Http\Controllers\Faculty\MentorCoachResourceController;
use App\Http\Controllers\Admin\CountryController;

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

Route::group(['middleware' => ['auth:faculty']], function(){
    
    Route::get('account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('account/password', [AccountController::class, 'password'])->name('account.password');
    Route::get('account/photo', [AccountController::class, 'photo'])->name('account.photo');
    Route::put('account/profile', [AccountController::class, 'update_profile'])->name('account.update.profile');
    Route::put('account/password', [AccountController::class, 'update_password'])->name('account.update.password');
    Route::put('account/photo', [AccountController::class, 'update_photo'])->name('account.update.photo');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('faculty-batches', BatchController::class);
    Route::post('faculty-batches/{batchId}/create-assignment', [BatchController::class, 'create_assignment'])->name('faculty-batches.create_assignment');
    Route::post('faculty-batches/{batchId}/create-recording', [BatchController::class, 'create_recording'])->name('faculty-batches.create_recording');
    Route::put('faculty-batches/{batchId}/sessions/{sId}/recordings/{rId}', [BatchController::class, 'update_recording'])->name('faculty-batches.update_recording');
    Route::put('faculty-batches/{batchId}/assignments/{aId}', [BatchController::class, 'update_assignment'])->name('faculty-batches.update_assignment');
    Route::delete('faculty-batches/{batchId}/sessions/{sId}/recordings/{rId}', [BatchController::class, 'delete_recording'])->name('faculty-batches.delete_recording');
    Route::delete('faculty-batches/{batchId}/assignments/{aId}', [BatchController::class, 'delete_assignment'])->name('faculty-batches.delete_assignment');
    Route::resource('mentor-coach-batches', MentorCoachBatchController::class);
    Route::resource('faculty-participants', UserController::class);
    Route::get('faculty-participants/{batchId}/assignments/{userId}', [BatchUserAssignmentController::class, 'assignments'])->name('faculty-participants.assignments');
    Route::resource('mentor-coach-participants', MentorCoachUserController::class);
    Route::get('mentor-coach-participants/{batchId}/assignments/{userId}', [BatchUserAssignmentController::class, 'assignments'])->name('mentor-coach-participants.assignments');
    Route::resource('faculty-approvals', ApprovalController::class);
    Route::resource('mentor-coach-approvals', MentorCoachApprovalController::class);
    Route::resource('faculty-resources', FacultyResourceController::class);
    Route::resource('mentor-coach-resources', MentorCoachResourceController::class);

    Route::get('programs/{programId}/batches/{batchId}/show', [ProgramController::class, 'show'])->name('programs.batches.show');
    
    Route::get('countries/{id}/locations', [CountryController::class, 'locations'])->name('countries.locations');
});

});