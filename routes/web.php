<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SpreadsheetController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::get('/register', [LoginController::class, 'register'])->name('register.view');
Route::post('/register', [LoginController::class, 'store'])->name('register.store');


Route::group(['middleware' => 'auth'], function(){


    Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard.view');


    // Routes teachers
    Route::get('/teachers', [TeacherController::class, 'view'])->name('teacher.view');
    Route::get('/teachers-reports', [TeacherController::class, 'reports_view'])->name('teacher.students');
    // Route::post('/students', [StudentsController::class, 'store'])->name('student.store');
    // Route::delete('/students/destroy/{rm_student}/{rm_teacher}', [StudentsController::class, 'destroy'])->name('student.destroy');



    // Routes students
    Route::get('/students', [StudentsController::class, 'view'])->name('student.view');
    Route::get('/students-reports', [StudentsController::class, 'reports_view'])->name('student.reports');
    Route::get('/students-check', [StudentsController::class, 'check_view'])->name('student.check');
    Route::post('/students', [StudentsController::class, 'store'])->name('student.store');
    Route::delete('/students/destroy/{rm_student}/{rm_teacher}', [StudentsController::class, 'destroy'])->name('student.destroy');



    // Routes spreadsheets
    Route::get('/spreadsheets', [SpreadsheetController::class, 'view'])->name('spreadsheet.view')->middleware('admin');
    Route::get('/spreadsheets/download/{filename}', [SpreadsheetController::class, 'index'])->name('spreadsheet.download');
    Route::get('/spreadsheets/flag', [SpreadsheetController::class, 'flag_view'])->name('spreadsheet.flag');
    Route::post('/spreadsheets/update', [SpreadsheetController::class, 'update_flag'])->name('spreadsheet.update');
    Route::post('/spreadsheets', [SpreadsheetController::class, 'store'])->name('spreadsheet.store');

    // Routes users admins
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users-edit', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/users-view', [UserController::class, 'view'])->name('user.view');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');
    Route::resource('users', UserController::class)->except(['index', 'show']);


    Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy');
});





