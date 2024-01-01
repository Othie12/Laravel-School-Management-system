<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TodosController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\ParentController;
use App\Models\User;
use App\Models\Period;
use App\Models\Students;
use App\Models\SchoolClass;
use App\Models\Attendance;
use Carbon\Carbon;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/classes', [ClassController::class, 'index']);
Route::get('/class/students/{id}', [ClassController::class, 'getStudents']);
Route::get('/class/requirements/{id}', [ClassController::class, 'getRequirements']);

Route::get('/gradings/{classId}', [GradingController::class, 'index']);
Route::post('/gradings/{classId}', [GradingController::class, 'store']);
Route::patch('/gradings/{id}', [GradingController::class, 'update']);
Route::delete('/gradings/{id}', [GradingController::class, 'destroy']);

Route::get('/comments/{classId}', [CommentsController::class, 'index']);
Route::post('/comments/{classId}', [CommentsController::class, 'store']);
Route::patch('/comments/{id}', [CommentsController::class, 'update']);
Route::delete('/comments/{id}', [CommentsController::class, 'destroy']);

Route::get('/student/mark-data/{id}', [StudentController::class, 'markData']);
