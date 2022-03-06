<?php

require_once __DIR__ . '/fortify.php';
require_once __DIR__ . '/jetstream.php';

use Illuminate\Foundation\Application;
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
Route::middleware(['auth:sanctum', 'verified'])->get('/award', [\App\Http\Controllers\AwardController::class, 'show'])->name('award');
Route::middleware(['auth:sanctum', 'verified'])->post('/save-notes', [\App\Http\Controllers\DashboardController::class, 'save_notes'])->name('dashboard.save-notes');
