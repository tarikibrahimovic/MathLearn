<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// if the type is admin then redirect to admin dashboard, if the type is user then redirect to user dashboard

Route::middleware(['type:admin'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::patch('/admin/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::middleware(['type:predavac'])->group(function () {
    Route::get('/teacher', [App\Http\Controllers\TeachersController::class, 'index'])->name('teacher.index');
});

