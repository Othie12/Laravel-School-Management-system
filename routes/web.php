<?php

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
use Carbon\Carbon;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/class-reg', [ClassController::class, 'create'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary,admini'])->name('class-reg');
Route::get('/class-show/{id}', [ClassController::class, 'show'])->middleware('auth')->name('class-show');
Route::post('/class-reg', [ClassController::class, 'store'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary'])->name('class-save');
Route::get('/class-update/{id}', [ClassController::class, 'edit'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary,admini'])->name('class-edit');
Route::patch('/class-update/{id}', [ClassController::class, 'update'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary,admini'])->name('class-update');

Route::get('/subject-reg', [SubjectController::class, 'create'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary'])->name('subject-reg');
Route::post('/subject-reg', [SubjectController::class, 'store'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary'])->name('subject-save');
Route::get('/subject/{id}', [SubjectController::class, 'edit'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary'])->name('subject-edit');
Route::patch('/subject/{id}', [SubjectController::class, 'update'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary'])->name('subject-update');
Route::patch('/subject-classes/{id}', [SubjectController::class, 'updateClasses'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary'])->name('subject-update-classes');

Route::get('/student', [StudentController::class, 'create'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary'])->name('student.create');
Route::get('/student-show/{id}', [StudentController::class, 'show'])->middleware(['auth'])->name('student.show');
Route::post('/student', [StudentController::class, 'store'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary'])->name('student.create');
Route::get('/student-update', [StudentController::class, 'edit'])->middleware('auth')->name('student.edit');
Route::patch('/student-update-photo', [StudentController::class, 'updatePhoto'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary,admini'])->name('student.update.photo');
Route::patch('/student', [StudentController::class, 'update'])->middleware('auth')->name('student.update');
Route::patch('/student-promote/{id}', [StudentController::class, 'promote'])->middleware('auth')->name('student.promote');
Route::patch('/student-demote/{id}', [StudentController::class, 'demote'])->middleware('auth')->name('student.demote');
Route::delete('/student', [StudentController::class, 'destroy'])->middleware('auth')->name('student.destroy');

Route::get('/period', [PeriodController::class, 'resolve'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary'])->name('period');
Route::post('/period', [PeriodController::class, 'store'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary', 'validatePeriod'])->name('period.create');
Route::patch('/period', [PeriodController::class, 'update'])->middleware(['auth', 'checkUserRole:dos,headteacher,secretary', 'validatePeriod'])->name('period.update');

Route::get('/grading', [GradingController::class, 'resolve'])->middleware(['auth', 'checkct'])->name('grading');
Route::post('/grading', [GradingController::class, 'store'])->middleware(['auth', 'checkct'])->name('grading.create');
Route::patch('/grading', [GradingController::class, 'update'])->middleware(['auth', 'checkct'])->name('grading.update');

Route::get('/comments', [CommentsController::class, 'resolve'])->middleware(['auth'])->name('comments');
Route::get('/comments-edit/{class_id}', [CommentsController::class, 'edit'])->middleware(['auth'])->name('comments.edit');
Route::post('/comments', [CommentsController::class, 'store'])->middleware(['auth'])->name('comments.create');
Route::patch('/comments', [CommentsController::class, 'update'])->middleware(['auth'])->name('comments.update');

Route::get('/requirements', [RequirementController::class, 'create'])->middleware(['auth'])->name('requirements.create');
Route::get('/schoolfees/{class_id}', [RequirementController::class, 'schoolfees'])->middleware(['auth'])->name('requirements.schoolfees');
Route::get('/requirements/{id}', [RequirementController::class, 'edit'])->middleware(['auth'])->name('requirements.edit');
Route::post('/requirements', [RequirementController::class, 'store'])->middleware(['auth'])->name('requirements.store');
Route::patch('/requirements/{id}', [RequirementController::class, 'update'])->middleware(['auth'])->name('requirements.update');
Route::delete('/requirements/{id}', [RequirementController::class, 'destroy'])->middleware(['auth'])->name('requirements.delete');
Route::get('/parent-autocomplete', [StudentController::class, 'searchParent'])->middleware('auth')->name('parent-autocomplete');

Route::get('/dashboard', function () {
    return view('dashboard', ['period' => Period::find(session('period_id')), 'classes' => SchoolClass::all(), 'today' => Carbon::now() ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/marksheet/{class_id}', [MarksController::class, 'create'])->middleware(['auth', 'checkPeriod'])->name('marksheet');
Route::post('/marksheet', [MarksController::class, 'resolveStorage'])->middleware(['auth', 'checkPeriod'])->name('marks.resolve-storage');

Route::get('/', function() {
    $today = Carbon::now();
    $period = Period::whereDate('date_from', '<=', $today)->whereDate('date_to', '>=', $today)->first();
    echo $period->name;
    echo $period->id;
});

Route::get('/reportcard/{pid}/{sid}', function($pid, $sid) {
    return view('reportcard', ['period' => Period::find($pid), 'student' => Students::find($sid)]);
})->middleware(['auth'])->name('reportcard');

Route::get('register-parent', [ParentController::class, 'create'])->middleware('auth', 'checkUserRole:dos,headteacher,secretary,admini')->name('parent');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile-other', [ProfileController::class, 'editOther'])->name('profile.other');
    Route::patch('/profile-othe', [ProfileController::class, 'updateOther'])->name('profile.updateOther');
    Route::patch('/profile-oth', [ProfileController::class, 'updateClasses'])->name('profile.update-classes');
    Route::patch('/profile-other', [ProfileController::class, 'updateSubjects'])->name('profile.update-subjects');
    Route::delete('/profile-other', [ProfileController::class, 'destroyOther'])->name('profile.destroyOther');
});

require __DIR__.'/auth.php';
