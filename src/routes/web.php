<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeightlogController;

Route::middleware('auth')->group(function () {
    Route::get('/weight_logs', [WeightlogController::class, 'index'])->name('weight-logs.index');
    Route::get('/weight_logs/goal_setting', [WeightlogController::class, 'showGoalSettingForm'])->name('weight-logs.goal_setting');
    Route::post('/weight_logs/goal_setting', [WeightlogController::class, 'setGoal'])->name('weight-logs.set_goal');
    Route::get('/weight_logs/create', [WeightlogController::class, 'create'])->name('weight-logs.create');
    Route::post('/weight_logs', [WeightlogController::class, 'store'])->name('weight-logs.store');
    Route::patch('/weight_logs/{id}/update', [WeightlogController::class, 'update'])->name('weight-logs.update');
    Route::delete('/weight_logs/{id}/delete', [WeightlogController::class, 'destroy'])->name('weight-logs.destroy');
    Route::get('/search', [WeightlogController::class, 'search'])->name('search');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register/step1', [AuthController::class, 'showRegistrationForm'])->name('register/step1');
Route::post('/register/step1', [AuthController::class, 'register_step1']);

Route::get('/register/step2', [AuthController::class, 'showRegistrationForm'])->name('register/step2');
Route::post('/register/step2', [AuthController::class, 'register_step2']);