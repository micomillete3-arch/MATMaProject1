<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return 'Laravel is running';
});

Route::get('/debug-log', function () {
    $path = storage_path('logs/laravel.log');

    if (!file_exists($path)) {
        return 'No Laravel log file found.';
    }

    $lines = file($path);
    $lastLines = array_slice($lines, -120);

    return response('<pre>' . e(implode('', $lastLines)) . '</pre>');
});
// Homepage redirect
Route::get('/', function () {
    return redirect()->route('student.login');
});

Route::get('/maintenance', [PagesController::class, 'maintenance'])->name('maintenance.page');
Route::get('/homiePage', [StudentController::class, 'homiePage'])->name('homiePage');
Route::get('/aboutUs', [StudentController::class, 'aboutUs'])->name('aboutUs');

Route::middleware('guest')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
    Route::post('/login', [StudentAuthController::class, 'login'])->name('student.login.submit');
    Route::get('/change-password', [StudentAuthController::class, 'showChangePasswordForm'])->name('student.password.change');
    Route::post('/change-password', [StudentAuthController::class, 'changePassword'])->name('student.password.update');
});

Route::middleware(['auth', 'no.cache'])->group(function () {
    Route::get('/dashboard', [StudentAuthController::class, 'dashboard'])
        ->middleware('role:student')
        ->name('student.dashboard');

    Route::get('/teacher/dashboard', [UserController::class, 'teacherDashboard'])
        ->middleware('role:teacher')
        ->name('teacher.dashboard');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:admin', 'no.cache'])->group(function () {
    Route::get('/manageStudents', [StudentController::class, 'manageStudents'])->name('students.manage');
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);

    Route::resource('studentss', StudentController::class);
    Route::resource('degrees', DegreeController::class);

    Route::get('/teachers', [AdminController::class, 'listTeachers'])->name('teachers.index');
    Route::get('/teachers/create', [AdminController::class, 'createTeacher'])->name('teachers.create');
    Route::post('/teachers', [AdminController::class, 'storeTeacher'])->name('teachers.store');
    Route::get('/teachers/{teacher}', [AdminController::class, 'showTeacher'])->name('teachers.show');
    Route::get('/teachers/{teacher}/edit', [AdminController::class, 'editTeacher'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [AdminController::class, 'updateTeacher'])->name('teachers.update');
    Route::delete('/teachers/{teacher}', [AdminController::class, 'destroyTeacher'])->name('teachers.destroy');
});

Route::middleware(['maintenance', 'groupMiddleware'])->group(function () {
    Route::get('/user_profile', [PagesController::class, 'userProfile']);
    Route::get('/user_posts', [PagesController::class, 'userPosts']);
    Route::get('/student_courses', [PagesController::class, 'studentCourses']);
});