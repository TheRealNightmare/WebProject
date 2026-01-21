<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployerController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\SkillController; // Added
use App\Http\Controllers\Api\UserController;   // Added
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{id}', [JobController::class, 'show']);
Route::get('/skills', [SkillController::class, 'index']); // Public skills list

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',[AuthController::class, 'logout']);
    
    // User Profile Routes
    Route::get('/user', [UserController::class, 'show']);
    Route::put('/user', [UserController::class, 'update']);
    Route::put('/user/password', [UserController::class, 'updatePassword']);

    // Seeker Routes
    Route::post('/jobs/{id}/apply', [ApplicationController::class, 'apply']);
    Route::get('/my-applications', [ApplicationController::class, 'myApplications']);
    
    // Employer Routes
    Route::post('/employer/jobs', [EmployerController::class, 'store']);
    Route::get('/employer/jobs', [EmployerController::class, 'myJobs']);
    Route::get('/employer/jobs/{id}/applicants', [EmployerController::class, 'getApplicants']);
    Route::put('/employer/jobs/{jobId}/applicants/{applicationId}', [EmployerController::class, 'updateApplicationStatus']);

    Route::get('/admin/stats', [AdminController::class, 'stats']);
    Route::get('/admin/users', [AdminController::class, 'users']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);
    Route::get('/admin/jobs', [AdminController::class, 'jobs']);
    Route::delete('/admin/jobs/{id}', [AdminController::class, 'deleteJob']);
});