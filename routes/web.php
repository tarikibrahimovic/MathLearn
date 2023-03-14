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

Route::middleware(['type:admin'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::patch('/admin/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::middleware(['type:predavac'])->group(function () {
    Route::get('/teacher', [App\Http\Controllers\TeachersController::class, 'index'])->name('teacher.index');
    Route::get('/teacher/courses/create', [App\Http\Controllers\CoursesController::class, 'create'])->name('courses.create');
    Route::post('/teacher/courses', [App\Http\Controllers\CoursesController::class, 'store'])->name('courses.store');
    Route::get('/teacher/courses/{id}/edit', [App\Http\Controllers\CoursesController::class, 'edit'])->name('courses.edit');
    Route::put('/teacher/courses/{id}/update', [App\Http\Controllers\CoursesController::class, 'update'])->name('courses.update');
    Route::delete('/teacher/lesson/{id}', [App\Http\Controllers\CoursesController::class, 'destroy'])->name('lessons.destroy');
    Route::post('/teacher/lesson/store/{id}', [App\Http\Controllers\CoursesController::class, 'storeLesson'])->name('lessons.store');
    Route::get('/teacher/lesson/create/{id}', [App\Http\Controllers\CoursesController::class, 'createLesson'])->name('lessons.create');
    Route::get('/teacher/followers/{id}', [App\Http\Controllers\FollowsController::class, 'show'])->name('follows.show');
});

Route::middleware(['type:korisnik'])->group(function (){
    Route::post('/follow/{course}', [App\Http\Controllers\FollowsController::class, 'store'])->name('follows.store');
    Route::delete('/follow/{course}', [App\Http\Controllers\FollowsController::class, 'destroy'])->name('follows.destroy');
});


Route::get('/teacher/courses/{id}', [App\Http\Controllers\CoursesController::class, 'show'])->name('courses.show');