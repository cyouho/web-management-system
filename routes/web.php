<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['check.login', 'data.db'])->group(function () {
    Route::get('/adminLogin', [AuthController::class, 'login'])->withoutMiddleware(['check.login', 'data.db']);
    Route::get('/adminRegister', [AuthController::class, 'register'])->withoutMiddleware(['check.login', 'data.db']);
    Route::get('/index', [IndexController::class, 'index']);
    Route::post('/doRegister', [AuthController::class, 'doRegister'])->withoutMiddleware(['check.login', 'data.db']);
    Route::post('/doLogin', [AuthController::class, 'doLogin'])->withoutMiddleware(['check.login']);
    Route::get('/logout', [AuthController::class, 'doLogout'])->withoutMiddleware(['check.login', 'data.db']);
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/adminLoginRecordAjax', [AdminController::class, 'adminLoginRecordAjax']);
    Route::post('/userDataDetailAjax', [UserController::class, 'userDataDetailAjax']);
    Route::post('/userLoginRecordAjax', [UserController::class, 'userLoginRecordAjax']);
    Route::post('/changeUserServerDetailAjax', [UserController::class, 'changeUserServerDetailAjax']);
});

// Route::get('/adminLogin', [AuthController::class, 'login']);
// Route::get('/adminRegister', [AuthController::class, 'register']);

// Route::get('/index', [IndexController::class, 'index']);

// Route::post('/doRegister', [AuthController::class, 'doRegister']);
