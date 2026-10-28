<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

// Redirect root and legacy admin entry points to Filament Admin Panel
Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::get('/dashboard', function () {
    return redirect('/admin');
})->name('dashboard');

// Print & Export Handlers for Student Reports
Route::middleware('auth')->group(function () {
    Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
    Route::get('students/report/print', [StudentController::class, 'print'])->name('students.print');
    Route::get('students/{student}/print', [StudentController::class, 'printStudent'])->name('students.print-single');
});
