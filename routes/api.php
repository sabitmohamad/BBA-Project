<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProgressController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API is working',
        'timestamp' => now(),
        'users_count' => User::count(),
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/courses/{course}', [CourseController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/my-courses', [CourseController::class, 'myCourses']);
    Route::get('/courses/{course}/lessons', [CourseController::class, 'lessons']);
    Route::get('/lessons/{lesson}', [LessonController::class, 'show']);
    Route::post('/lessons/{lesson}/quiz-submit', [QuizController::class, 'submit']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments/course/{courseId}', [PaymentController::class, 'getPaymentByCourse']);
    
    // Progress tracking
    Route::post('/progress', [ProgressController::class, 'store']);
    Route::get('/progress/lesson/{lessonId}', [ProgressController::class, 'getLessonProgress']);
    Route::get('/progress/course/{courseId}', [ProgressController::class, 'getCourseProgress']);
});
