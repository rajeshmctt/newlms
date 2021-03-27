<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Participant\AccountController;
use App\Http\Controllers\Participant\DashboardController;
use App\Http\Controllers\Participant\ElectiveController;
use App\Http\Controllers\Participant\ProgramController;
use App\Http\Controllers\Participant\MyProgramController;
use App\Http\Controllers\Participant\MyElectiveController;
use App\Http\Controllers\Participant\MyProgramElectiveController;
use App\Http\Controllers\Participant\MyProgramMyElectiveController;
use App\Http\Controllers\Participant\ResourceController;
use App\Http\Controllers\Participant\RecordingController;
use App\Http\Controllers\Participant\PaymentController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Participant\CertificateController;

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

Route::group(['middleware' => ['auth:web']], function(){
    
    Route::get('account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('account/password', [AccountController::class, 'password'])->name('account.password');
    Route::get('account/photo', [AccountController::class, 'photo'])->name('account.photo');
    Route::put('account/profile', [AccountController::class, 'update_profile'])->name('account.update.profile');
    Route::put('account/password', [AccountController::class, 'update_password'])->name('account.update.password');
    Route::put('account/photo', [AccountController::class, 'update_photo'])->name('account.update.photo');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('programs/all', [ProgramController::class, 'index'])->name('programs.index');
    Route::get('programs/{programId}/batches/{batchId}/show', [ProgramController::class, 'show'])->name('programs.batches.show');
    Route::post('programs/{programId}/batches/{batchId}/feedback', [ProgramController::class, 'feedback_store'])->name('programs.batches.feedback.store');
    Route::post('programs/{programId}/batches/{batchId}/enquiry', [ProgramController::class, 'enquiry'])->name('programs.batches.enquiry');

    Route::get('programs/my', [MyProgramController::class, 'index'])->name('my_programs.index');
    Route::get('programs/my/{programId}/batches/{batchId}/show', [MyProgramController::class, 'show'])->name('my_programs.batches.show');
    Route::post('programs/my/{programId}/batches/{batchId}/feedback', [MyProgramController::class, 'feedback_store'])->name('my_programs.batches.feedback.store');
    Route::post('programs/my/{programId}/batches/{batchId}/mentor-coach-sessions/feedback', [MyProgramController::class, 'mentor_coach_session_feedback_store'])->name('my_programs.batches.mentor_coach_sessions.feedback.store');

    Route::post('programs/my/{programId}/batches/{batchId}/assignments/{id}/submit', [MyProgramController::class, 'submit_assignment'])->name('my_programs.batches.submit_assignment');
    Route::post('programs/my/{id}/batches/{batchId}/accept', [MyProgramController::class, 'accept_agreement'])->name('my_programs.batches.accept_agreement');

    // Route::get('programs/my/{programId}/batches/{batchId}/electives/{electiveId}/batches/{electiveBatchId}/show', [MyProgramElectiveController::class, 'show'])->name('my_programs.batches.electives.batches.show');
    // Route::post('programs/my/{programId}/batches/{batchId}/electives/{electiveId}/batches/{electiveBatchId}/opt', [MyProgramElectiveController::class, 'opt'])->name('my_programs.batches.electives.batches.opt');
    Route::get('programs/my/{programId}/batches/{batchId}/electives/my/{electiveId}/batches/{electiveBatchId}/show', [MyProgramMyElectiveController::class, 'show'])->name('my_programs.batches.my_electives.batches.show');

    Route::get('electives/all', [ElectiveController::class, 'index'])->name('electives.index');
    Route::get('electives/{electiveId}/batches/{batchId}/show', [ElectiveController::class, 'show'])->name('electives.batches.show');
    Route::post('electives/{electiveId}/batches/{batchId}/opt', [ElectiveController::class, 'opt'])->name('electives.batches.opt');
    Route::post('electives/{electiveId}/batches/{batchId}/feedback', [ElectiveController::class, 'feedback_store'])->name('electives.batches.feedback.store');

    Route::get('electives/my', [MyElectiveController::class, 'index'])->name('my_electives.index');
    Route::get('electives/my/{electiveId}/batches/{batchId}/show', [MyElectiveController::class, 'show'])->name('my_electives.batches.show');
    Route::post('electives/my/{electiveId}/batches/{batchId}/feedback', [MyElectiveController::class, 'feedback_store'])->name('my_electives.batches.feedback.store');

    Route::post('electives/my/{electiveId}/batches/{batchId}/assignments/{id}/submit', [MyElectiveController::class, 'submit_assignment'])->name('my_electives.batches.submit_assignment');
    Route::post('electives/my/{id}/batches/{batchId}/accept', [MyElectiveController::class, 'accept_agreement'])->name('my_electives.batches.accept_agreement');

    Route::get('resources/all', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('resources/my', [ResourceController::class, 'my'])->name('resources.my');

    Route::get('recordings', [RecordingController::class, 'index'])->name('recordings.index');

    Route::get('certificates', [CertificateController::class, 'index'])->name('certificates.index');
    
    Route::get('test-results', [MyProgramController::class, 'index'])->name('test_results.index');
    Route::get('purchase-history', [MyProgramController::class, 'index'])->name('purchase_history.index');

    Route::post('payment', [PaymentController::class, 'index'])->name('payment');
    Route::post('payment-success', [PaymentController::class, 'success'])->name('payment.success');

    Route::get('countries/{id}/locations', [CountryController::class, 'locations'])->name('countries.locations');
});

});