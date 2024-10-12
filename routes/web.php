<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\EnforcerController;
use App\Http\Controllers\ImpoundAreaController;
use App\Http\Controllers\ImpoundTicketController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViolationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})/* ->middleware(['auth']) */->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})/* ->middleware(['auth', 'verified'])->name('dashboard') */;

/* Route::middleware('auth')->group(function () { */
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::resource('/permissions', PermissionController::class)/* ->middleware('permission:Manage Permissions') */;
Route::resource('/roles', RoleController::class)/* ->middleware('permission:Manage Roles') */;
Route::resource('/users', UserController::class)/* ->middleware('permission:Manage Users') */;
Route::resource('/drivers', DriverController::class)/* ->middleware('permission:Manage Drivers') */;
Route::resource('/enforcers', EnforcerController::class)/* ->middleware('permission:Manage Drivers') */;
Route::resource('/violations', ViolationController::class)/* ->middleware('permission:Manage Drivers') */;
/* }); */

Route::resource('/tickets', TicketController::class);
Route::resource('/impound-tickets', ImpoundTicketController::class);
Route::resource('/impound-area', ImpoundAreaController::class);
require __DIR__ . '/auth.php';
