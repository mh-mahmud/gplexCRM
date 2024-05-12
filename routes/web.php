<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'index'])->name('login_index');
Route::get('/login', [AuthController::class, 'index'])->name('login');
//Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('/post_login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('/admin/login',[HomeController::class,'admin_login'])->name('admin_login');
Route::post('admin_login_post',[HomeController::class,'admin_login_post'])->name('admin_login_post');
//Route::post('logout', [HomeController::class, 'logout'])->name('logout1')->middleware('auth');