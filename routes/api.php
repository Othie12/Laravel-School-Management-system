<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\DivisionsController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TodosController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\BalanceController;
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
Route::get('/class/{id}', [ClassController::class, 'show']);
Route::get('/class/students/{id}', [ClassController::class, 'getStudents']);
Route::post('/class/registerStudentsViaExcel/{class_id}', [ClassController::class, 'registerClassStudentsViaExcel']);
Route::post('/class/uploadMarksheetViaExcel/{class_id}/{type}', [ClassController::class, 'uploadMarksheetViaExcel']);
Route::get('/class/studentsWithMarks/{id}/{type}', [ClassController::class, 'getStudentsWithMarks']);
Route::get('/class/gradingPerSubject/{id}/{type}', [ClassController::class, 'getGradingPerSubject']);
Route::get('/class/divisionMetrics/{id}/{type}', [ClassController::class, 'divisionMetrics']);
Route::get('/class/requirements/{id}', [ClassController::class, 'getRequirements']);
Route::post('class/update/{id}', [ClassController::class, 'update']);

Route::get('/gradings/{classId}', [GradingController::class, 'index']);
Route::post('/gradings/{classId}', [GradingController::class, 'store']);
Route::post('/gradings/createViaExcel/{class_id}', [GradingController::class, 'createViaExcel']);
Route::patch('/gradings/{id}', [GradingController::class, 'update']);
Route::delete('/gradings/{id}', [GradingController::class, 'destroy']);

Route::get('/divisions/{classId}', [DivisionsController::class, 'index']);
Route::post('/divisions/{classId}', [DivisionsController::class, 'store']);
Route::patch('/divisions/{id}', [DivisionsController::class, 'update']);
Route::delete('/divisions/{id}', [DivisionsController::class, 'destroy']);

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
Route::post('/batchExcelUpload', [StudentController::class, 'batchExcelUpload']);
Route::patch('/student/{id}', [StudentController::class, 'update']);
Route::post('/student/photo/{id}', [StudentController::class, 'updatePhoto']);
Route::get('/student/search/{term}', [StudentController::class, 'search']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);
Route::get('/student/{id}', [StudentController::class, 'show']);
Route::get('/student/reportcard/{id}/{period_id}', [StudentController::class, 'reportCard']);
Route::get('/student/index/{limit}/{offset}', [StudentController::class, 'index']);

Route::get('/parent/search/{term}', [ParentController::class, 'search']);
Route::get('/teachers', [UsersController::class, 'teachers']);
Route::get('/user/search/{term}', [UsersController::class, 'search']);
Route::get('/user/{id}', [UsersController::class, 'show']);

Route::post('/people', [ApiUserController::class, 'store']);

Route::post('/balance/{student_id}/{period_id}', [BalanceController::class, 'store']);

Route::get('/subjects', [SubjectController::class, 'index']);
Route::get('/subject/{id}', [SubjectController::class, 'show']);
Route::post('/subject', [SubjectController::class, 'store']);
Route::patch('/subject/{id}', [SubjectController::class, 'update']);

Route::get('/requirements', [RequirementController::class, 'index']);
Route::get('/requirement/{id}', [RequirementController::class, 'show']);
Route::post('/requirement', [RequirementController::class, 'store']);
Route::post('/requirement/createViaExcel/{class_id}', [RequirementController::class, 'createViaExcel']);
Route::patch('/requirement/{id}', [RequirementController::class, 'update']);

Route::get('/specifiedMark/{student_id}/{subject_id}/{type}', [MarksController::class, 'specifiedMark']);
Route::post('/record-mark', [MarksController::class, 'resolve2'])->middleware('checkPeriod');

Route::get('/payment/{id}', [PaymentController::class, 'show']);
Route::get('/payment/search-hash/{hash}', [PaymentController::class, 'searchByHash']);
Route::post('/payment/{student_id}', [PaymentController::class, 'store']);
Route::patch('/payment/{id}', [PaymentController::class, 'update']);

Route::patch('/user/{id}', [ProfileController::class, 'update']);
Route::patch('/user-photo/{id}', [ProfileController::class, 'updatePhoto']);
Route::patch('/user-password/{id}', [ProfileController::class, 'updatePassword']);
Route::patch('/user-subjects/{id}', [ProfileController::class, 'updateSubjects']);
Route::patch('/user-classes/{id}', [ProfileController::class, 'updateClasses']);
