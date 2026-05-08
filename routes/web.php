<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Backend\Common\ExamController;
use App\Http\Controllers\Backend\Common\RoleController;
use App\Http\Controllers\Backend\Common\UserController;
use App\Http\Controllers\Backend\Common\TutorialController;
use App\Http\Controllers\Backend\Common\ExamQuestionController;
use App\Http\Controllers\Backend\Common\ExamQuestionSetController;
use App\Http\Controllers\Backend\Common\LearningMaterialController;

/**
 * All web routes
 * @author Md. Amzad Hossain Jacky <amzadhossain1922@gmail.com>
 */

/** Routes without middleware */
## login
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::redirect('/', 'login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/** Admin Routes */
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'is_admin']], function () {

    ## Dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    ## Role
    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index')->name('roles')->middleware(['permission:role-list']);
        Route::get('/roles/create', 'create')->name('roles.create')->middleware(['permission:role-create']);
        Route::post('/roles/create', 'store')->name('roles.store');
        Route::get('/roles/edit/{id}', 'edit')->name('roles.edit')->middleware(['permission:role-edit']);
        Route::post('/roles/update/{id}', 'update')->name('roles.update');
        Route::get('/roles/destroy/{id}', 'destroy')->name('roles.destroy');
    });


    ## user
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users')->middleware(['permission:user-list']);
        Route::get('/users/create', 'create')->name('users.create')->middleware(['permission:user-create']);
        Route::post('/users/create', 'store')->name('users.store');
        Route::get('/users/edit/{id}', 'edit')->name('users.edit')->middleware(['permission:user-edit']);
        Route::post('/users/update/{id}', 'update')->name('users.update');

        //ajax call
        //Route::post('/users/create', 'store')->name('users.store');
    });

    ## Learning Material
    Route::controller(LearningMaterialController::class)->group(function () {
        Route::get('/learning-materials', 'index')->name('learning.materials')->middleware(['permission:learning-material-list']);
        Route::get('/learning-materials/create', 'create')->name('learning.materials.create')->middleware(['permission:learning-material-create']);
        Route::post('/learning-materials/create', 'store')->name('learning.materials.store');
        Route::get('/learning-materials/edit/{id}', 'edit')->name('learning.materials.edit')->middleware(['permission:learning-material-edit']);
        Route::post('/learning-materials/update/{id}', 'update')->name('learning.materials.update');
        Route::get('/learning-materials/remove/{id}/{attachment_id}', 'remove_attachment')->name('learning.materials.remove.attachment');
    });

    ## Learning material
    Route::controller(TutorialController::class)->group(function () {
        Route::get('/tutorials', 'index')->name('tutorials')->middleware(['permission:tutorial-list']);
    });

    ## Exam Question Set
    Route::controller(ExamQuestionSetController::class)->group(function () {
        Route::get('/exam-question-sets', 'index')->name('exam.question.sets')->middleware(['permission:exam-question-set-list']);
        Route::get('/exam-question-sets/create', 'create')->name('exam.question.sets.create')->middleware(['permission:exam-question-set-create']);
        Route::post('/exam-question-sets/create', 'store')->name('exam.question.sets.store');
        Route::get('/exam-question-sets/edit/{id}', 'edit')->name('exam.question.sets.edit')->middleware(['permission:exam-question-set-edit']);
        Route::post('/exam-question-sets/update/{id}', 'update')->name('exam.question.sets.update');
    });

    ## Exam
    Route::controller(ExamController::class)->group(function () {
        Route::get('/exams', 'index')->name('exams')->middleware(['permission:exam-list']);
        Route::get('/exams/create', 'create')->name('exams.create')->middleware(['permission:exam-create']);
        Route::post('/exam/create', 'store')->name('exams.store');
        Route::get('/exam/edit/{id}', 'edit')->name('exams.edit')->middleware(['permission:exam-edit']);
        Route::post('/exam/update/{id}', 'update')->name('exams.update');
    });

    ## Exam Questions
    Route::controller(ExamQuestionController::class)->group(function () {
        Route::get('/exams-questions', 'index')->name('exam.questions')->middleware(['permission:exam-question-list']);
        Route::get('/exams-questions/create', 'create')->name('exam.questions.create')->middleware(['permission:exam-question-create']);
        Route::post('/exams-questions/create', 'store')->name('exam.questions.store');
        Route::get('/exams-questions/edit/{id}', 'edit')->name('exam.questions.edit')->middleware(['permission:exam-question-edit']);
        Route::post('/exams-questions/update/{id}', 'update')->name('exam.questions.update');
    });
});







/** Teacher Routes */
Route::group(['as' => 'teacher.', 'prefix' => 'teacher', 'middleware' => ['auth', 'is_teacher']], function () {

    ## Dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    ## Role
    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index')->name('roles')->middleware(['permission:role-list']);
        Route::get('/roles/create', 'create')->name('roles.create')->middleware(['permission:role-create']);
        Route::post('/roles/create', 'store')->name('roles.store');
        Route::get('/roles/edit/{id}', 'edit')->name('roles.edit')->middleware(['permission:role-edit']);
        Route::post('/roles/update/{id}', 'update')->name('roles.update');
        Route::get('/roles/destroy/{id}', 'destroy')->name('roles.destroy');
    });
});

/** Student Routes */
Route::group(['as' => 'student.', 'prefix' => 'student', 'middleware' => ['auth', 'is_student']], function () {

    ## Dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    ## Role
    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index')->name('roles')->middleware(['permission:role-list']);
        Route::get('/roles/create', 'create')->name('roles.create')->middleware(['permission:role-create']);
        Route::post('/roles/create', 'store')->name('roles.store');
        Route::get('/roles/edit/{id}', 'edit')->name('roles.edit')->middleware(['permission:role-edit']);
        Route::post('/roles/update/{id}', 'update')->name('roles.update');
        Route::get('/roles/destroy/{id}', 'destroy')->name('roles.destroy');
    });
});
