<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\QuestionsController;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Controllers\InterviewController;

Route::get('/', function () {
    return view('home');
})->name('home')->middleware('employee');//CandidateController::class is used to get the whole URL 
                                // ims_test/app/CandidateController.php


//Login routes                                 
Route::view('login', 'login')
    ->middleware('guest')
    ->name('login');
Route::post('login', LoginController::class)->name('login.attempt'); //single action controller 

//Logout route 

Route::post('logout', LogoutController::class)
    ->middleware('employee')
    ->name('logout');
Route::view('dashboard', 'dashboard')
    ->middleware('employee')
    ->name('dashboard');

Route::view('register', 'register')
    ->middleware('guest')   
    ->name('register');
Route::post('register', RegisterController::class)->name('register.store'); 


Route::view('requestPending', 'employee.requestPending')
    ->middleware('employee')
    ->name('requestPending');

Route::get('/candidates', [CandidateController::class,'index'])
    ->middleware('employee')
    ->name('candidates.index');                                
Route::get('/candidates/{id}', [CandidateController::class, 'show']); 
                                //show is stored as string because we are not trying to call it here.



Route::get('/employee/{id}', [EmployeeController::class, 'show']);    

Route::get('/employee/status/{status}',[EmployeeController::class, 'filterByStatus'])
    ->middleware('admin');
Route::post('/employee/{id}/status', [EmployeeController::class, 'updateStatus']);

Route::post('/candidate/store', [CandidateController::class, 'store'])
    ->middleware('employee')
    ->name('candidate.store');

 Route::get('/questions', [QuestionsController::class, 'index'])
    ->middleware('employee')
    ->name('question.index');

Route::post('/questions/store', [QuestionsController::class, 'store'])
    ->middleware('employee')
    ->name('questions.store');

Route::post('/categories/store', [CategoryController::class, 'store'])
    ->middleware('employee')
    ->name('categories.store');

Route::get('/questions', [QuestionsController::class, 'index'])
    ->middleware('employee')
    ->name('questions.index');

Route::get('/interviews', [InterviewController::class, 'index'])
    ->middleware('employee')
    ->name('interview.index');
Route::get('/interviews/{interview}', [InterviewController::class, 'show'])
    ->middleware('employee')
    ->name('interview.show');
