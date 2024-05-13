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
Route::post('/post_login', [AuthController::class, 'postLogin'])->name('login.post');
/*Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');*/


Route::group(['middleware' => 'auth'], function () {
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
	Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
	Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
});