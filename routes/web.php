<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\LoginController;

// Redirect root to dashboard (auth middleware will redirect guests to login)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
});

Route::post('logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Protected Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Additional student routes (before resource routes)
    Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
    Route::get('students/report/print', [StudentController::class, 'print'])->name('students.print');
    Route::get('students/{student}/print', [StudentController::class, 'printStudent'])->name('students.print-single');

    // Resource Routes for Courses, Sessions, and Students
    Route::resource('courses', CourseController::class);
    Route::resource('sessions', SessionController::class);
    Route::resource('students', StudentController::class);
});

