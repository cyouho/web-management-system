<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;

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

Route::get('/adminLogin', [AuthController::class, 'login']);
Route::get('/adminRegister', [AuthController::class, 'register']);

Route::get('/index', [IndexController::class, 'index']);

Route::post('/doRegister', [AuthController::class, 'doRegister']);
