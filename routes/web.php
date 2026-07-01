<?php

use App\Http\Controllers\InstitutionalPlanController;
use App\Http\Controllers\PlanActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicEntityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StrategicObjectiveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('entities', PublicEntityController::class);
    Route::resource('objectives', StrategicObjectiveController::class);
    Route::resource('plans', InstitutionalPlanController::class);
    Route::resource('plans.activities', PlanActivityController::class)->except(['index', 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
