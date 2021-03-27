<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\BatchUserController;
use App\Http\Controllers\Admin\ElectiveController;
use App\Http\Controllers\Admin\ElectiveBatchController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\AgreementController;
use App\Http\Controllers\Admin\CertificationLevelController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\LabelController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\GlobalAnnouncementController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BatchResourceController;

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


Route::group(['middleware' => ['auth:admin']], function(){
    
    Route::get('account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('account/password', [AccountController::class, 'password'])->name('account.password');
    Route::get('account/photo', [AccountController::class, 'photo'])->name('account.photo');
    Route::put('account/profile', [AccountController::class, 'update_profile'])->name('account.update.profile');
    Route::put('account/password', [AccountController::class, 'update_password'])->name('account.update.password');
    Route::put('account/photo', [AccountController::class, 'update_photo'])->name('account.update.photo');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('programs', ProgramController::class);
    Route::resource('electives', ElectiveController::class);
    Route::resource('batches', BatchController::class);
    Route::get('batches/{id}/sessions/delete', [SessionController::class, 'destroy'])->name('batches.sessions.delete');
    Route::get('batches/{id}/sessions', [SessionController::class, 'index'])->name('batches.sessions');
    Route::post('batches/{id}/sessions', [SessionController::class, 'store'])->name('batches.sessions.store');
    Route::put('batches/{id}/sessions', [SessionController::class, 'update'])->name('batches.sessions.update');
    Route::delete('batches/{id}/sessions', [SessionController::class, 'destroy'])->name('batches.sessions.destroy');
    Route::get('batches/{id}/participants', [BatchUserController::class, 'index'])->name('batches.participants');
    Route::get('batches/{id}/participants/add', [BatchUserController::class, 'create'])->name('batches.participants.add');
    Route::post('batches/{id}/participants/{pId}/store', [BatchUserController::class, 'store'])->name('batches.participants.store');
    Route::delete('batches/{id}/participants/{buId}/destroy', [BatchUserController::class, 'destroy'])->name('batches.participants.destroy');
    // Route::resource('sessions', SessionController::class);

    Route::get('batches/{id}/resources', [BatchResourceController::class, 'index'])->name('batches.resources');
    Route::post('batches/{id}/resources', [BatchResourceController::class, 'store'])->name('batches.resources.store');
    Route::put('batches/{id}/resources/{resId}', [BatchResourceController::class, 'update'])->name('batches.resources.update');

    Route::resource('elective-batches', ElectiveBatchController::class);
    Route::resource('faculties', FacultyController::class);
    Route::resource('participants', UserController::class);
    Route::get('resources/{id}/link', [ResourceController::class, 'link'])->name('resources.link');
    Route::resource('resources', ResourceController::class);

    Route::resource('countries', CountryController::class);
    Route::get('countries/{id}/locations', [CountryController::class, 'locations'])->name('countries.locations');
    Route::resource('locations', LocationController::class);
    Route::resource('agreements', AgreementController::class);
    Route::resource('certification-levels', CertificationLevelController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('labels', LabelController::class);
    Route::resource('global-announcements', GlobalAnnouncementController::class);
    Route::resource('certificates', CertificateController::class);

    Route::resource('feedbacks', FeedbackController::class);

    Route::get('reports/list-of-participants', [ReportController::class, 'list_of_participants'])->name('reports.list_of_participants');

    Route::get('reports/list-of-participants/export', [ReportController::class, 'list_of_participants_export'])->name('reports.list_of_participants.export');
});