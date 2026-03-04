<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\CommitteeController;
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

// Route::get('/', [ApplicationController::class, 'getFormView'])->name('application.view');
// Route::prefix(env('APP_NAME'))->group(function () {
//     Route::post('/test', [ApplicationController::class, 'test'])->name('application.test');
//     Route::post('/apply', [ApplicationController::class, 'apply'])->name('application.apply');
//     Route::post('/upload', [ApplicationController::class, 'upload'])->name('application.upload');
//     Route::delete('/files/{inputId}/{filename}', [ApplicationController::class, 'application.destroy']);
// });

/** Localhost Routes - to be ignored in production and development */

Route::get('/', [ApplicationController::class, 'getFormView'])->name('application.view');
Route::post('/test', [ApplicationController::class, 'test'])->name('application.test');
Route::post('/apply', [ApplicationController::class, 'apply'])->name('application.apply');
Route::post('/upload', [ApplicationController::class, 'upload'])->name('application.upload');
Route::delete('/files/{inputId}/{filename}', [ApplicationController::class, 'application.destroy']);


// // Draft routes
// Route::post('/application/save-draft', [ApplicationController::class, 'saveDraft'])->name('application.saveDraft');
// Route::get('/application/resume/{token}', [ApplicationController::class, 'resume'])->name('application.resume');

// Apply auth middleware to protected routes
Route::prefix('committee')->group(function () {
    // Public routes (no auth required)
    Route::get('/', function(){
        return redirect()->route('committee.login');
    });
    Route::get('/login', [CommitteeController::class, 'index'])->name('committee.login')->middleware('guest');
    Route::post('/login', [CommitteeController::class, 'login'])->name('login');
    Route::post('/logout', [CommitteeController::class, 'logout'])->name('logout');

    // Protected routes (auth required)
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [CommitteeController::class, 'dashboard'])->name('committee.dashboard');
        Route::get('/applications', [CommitteeController::class, 'allApplications'])->name('committee.applications');
        Route::get('/profile/{id}', [CommitteeController::class, 'profile'])->name('profile');
        Route::post('/comment', [CommitteeController::class, 'comment'])->name('comment');
        Route::post('/score', [CommitteeController::class, 'score'])->name('score');
    });
});
Route::post('/session-files/{inputId}/{filename}', [ApplicationController::class, 'deleteSessionFile'])->name('session-files.delete');
