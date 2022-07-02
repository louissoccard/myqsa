<?php

require_once __DIR__ . '/fortify.php';
require_once __DIR__ . '/jetstream.php';

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/', [\App\Http\Controllers\DashboardController::class, 'show'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified', 'can:qsa.has'])->name('award.')->prefix('award')->group(function () {
    Route::get('/', [\App\Http\Controllers\AwardController::class, 'show'])->name('index');

    Route::get('/membership', [\App\Http\Controllers\MembershipController::class, 'show'])->name('membership.show');
    Route::post('/membership/{id}', [\App\Http\Controllers\MembershipController::class, 'store'])->name('membership.store');

    Route::get('/nights-away', [\App\Http\Controllers\NightsAwayController::class, 'show'])->name('nights-away.show');
    Route::post('/nights-away/{id}', [\App\Http\Controllers\NightsAwayController::class, 'store'])->name('nights-away.store');
    Route::patch('/nights-away/{id}', [\App\Http\Controllers\NightsAwayController::class, 'patch'])->name('nights-away.patch');
    Route::delete('/nights-away/{id}', [\App\Http\Controllers\NightsAwayController::class, 'delete'])->name('nights-away.delete');

    Route::get('/icv-list', [\App\Http\Controllers\ICVListController::class, 'show'])->name('icv-list.show');
    Route::post('/icv-list/{id}', [\App\Http\Controllers\ICVListController::class, 'store'])->name('icv-list.store');
    Route::patch('/icv-list/{id}', [\App\Http\Controllers\ICVListController::class, 'patch'])->name('icv-list.patch');
    Route::delete('/icv-list/{id}', [\App\Http\Controllers\ICVListController::class, 'delete'])->name('icv-list.delete');

    Route::get('/dofe', [\App\Http\Controllers\DofeController::class, 'show'])->name('dofe.show');
    Route::post('/dofe/{id}', [\App\Http\Controllers\DofeController::class, 'store'])->name('dofe.store');

    Route::get('/presentation', [\App\Http\Controllers\PresentationController::class, 'show'])->name('presentation.show');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/manage-account', function () {return Inertia::render('Logo');} )->name('manage-account');
Route::middleware(['web'])->get('/presentation/{presentation_key}', [\App\Http\Controllers\PresentationController::class, 'show_statement_page'])->name('presentation-statement.show');
Route::middleware(['web'])->post('/presentation/{presentation_key}', [\App\Http\Controllers\PresentationController::class, 'store'])->name('presentation-statement.store');

// Admin Centre
Route::middleware(['auth:sanctum', 'verified', \App\Http\Middleware\AccessAdminCentre::class])->group(function() {
    Route::get('/admin-centre', function () {
        return Inertia::render("App/AdminCentre/Index");
    })->name("admin-centre.index");
    Route::get('/admin-centre/users', [\App\Http\Controllers\UsersController::class, 'show'])->name("admin-centre.users.index");
    Route::post('/admin-centre/users', [\App\Http\Controllers\UsersController::class, 'create'])->name("admin-centre.users.create");
    Route::patch('/admin-centre/users/{id}', [\App\Http\Controllers\UsersController::class, 'patch'])->name("admin-centre.users.patch");
    Route::patch('/admin-centre/users/reset-password/{id}', [\App\Http\Controllers\UsersController::class, 'reset_password'])->name("admin-centre.users.reset-password");
    Route::delete('/admin-centre/users/{id}', [\App\Http\Controllers\UsersController::class, 'delete'])->name("admin-centre.users.delete");
});
