<?php

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

Route::get('/', \App\Http\Controllers\IndexController::class)->name('index');
Route::prefix('feedbacks')->group(function () {
    Route::get('/', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::get('/create', [\App\Http\Controllers\FeedbackController::class, 'create'])->name('feedbacks.create');
    Route::post('/', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedbacks.store');
    Route::delete('/{id}', [\App\Http\Controllers\FeedbackController::class, 'delete'])->name('feedbacks.delete');
    Route::put('/{id}/restore', [\App\Http\Controllers\FeedbackController::class, 'restore'])->name('feedbacks.restore');
});
