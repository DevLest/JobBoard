<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

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
Route::get('/', [JobController::class, 'index'])->name('jobs.index');
Route::post('/', [JobController::class, 'store']);

Route::get('/jobs/approve/{id}', [JobController::class, 'approve'])->name('jobs.approve');
Route::get('/jobs/spam/{id}', [JobController::class, 'markAsSpam'])->name('jobs.spam');