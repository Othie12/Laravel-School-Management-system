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
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
use App\Models\Period;
use App\Models\Students;
use App\Models\SchoolClass;
use App\Models\Attendance;
use Carbon\Carbon;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);//->middleware('auth:sanctum');
//Route::post('/login', [AuthenticatedSessionController::class, 'store']);


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

Route::get('/attendance/{classId}', [AttendanceController::class, 'index']);
Route::post('/attendance/{classId}', [AttendanceController::class, 'store']);
Route::patch('/attendance/{id}', [AttendanceController::class, 'update']);
Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy']);

Route::get('/period/{name}', [PeriodController::class, 'show']);
Route::post('/period', [PeriodController::class, 'store']);

Route::get('/student/mark-data/{id}', [StudentController::class, 'markData']);
Route::post('/student', [StudentController::class, 'store']);
Route::get('/student/search/{term}', [StudentController::class, 'search']);
Route::get('/student/find/{id}', [StudentController::class, 'show']);
Route::get('/student/index/{limit}/{offset}', [StudentController::class, 'index']);

Route::get('/parent/search/{term}', [ParentController::class, 'search']);

Route::post('/people', [ApiUserController::class, 'store']);

Route::get('/subjects', [SubjectController::class, 'index']);
Route::get('/subject/{id}', [SubjectController::class, 'show']);
Route::post('/subject', [SubjectController::class, 'store']);
Route::patch('/subject/{id}', [SubjectController::class, 'update']);

Route::get('/requirements', [RequirementController::class, 'index']);
Route::get('/requirement/{id}', [RequirementController::class, 'show']);
Route::post('/requirement', [RequirementController::class, 'store']);
Route::patch('/requirement/{id}', [RequirementController::class, 'update']);

Route::get('/fees/{class_id}', [RequirementController::class, 'schoolFees']);
