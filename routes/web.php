<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeadsFormController;

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
	// agents route
	Route::get('/agents', [AgentController::class, 'index'])->name('agents.index');
    Route::get('/agents/create', [AgentController::class, 'create'])->name('agents.create');
	Route::post('/agents', [AgentController::class, 'store'])->name('agents.store');
	Route::get('/agents/{id}', [AgentController::class, 'show'])->name('agents.show');
	Route::get('/agents/{id}/edit', [AgentController::class, 'edit'])->name('agents.edit');
	Route::put('/agents/{id}', [AgentController::class, 'update'])->name('agents.update');
	Route::post('/agents/search', [AgentController::class, 'search'])->name('agents.search');
	Route::delete('/agents/{id}', [AgentController::class, 'destroy'])->name('agents.destroy');
    //Lead Form route
	Route::get('/leads_forms', [LeadsFormController::class, 'index'])->name('leads_forms.index');
	Route::get('/leads_forms/create', [LeadsFormController::class, 'create'])->name('leads_forms.create');
	Route::post('/leads_forms', [LeadsFormController::class, 'store'])->name('leads_forms.store');
	Route::get('/leads_forms/{id}', [LeadsFormController::class, 'show'])->name('leads_forms.show');
	Route::get('/leads_forms/{id}/edit', [LeadsFormController::class, 'edit'])->name('leads_forms.edit');
	Route::put('/leads_forms/{id}', [LeadsFormController::class, 'update'])->name('leads_forms.update');
	Route::delete('/leads_forms/{id}', [LeadsFormController::class, 'destroy'])->name('leads_forms.destroy');
	Route::post('/leads_forms/search', [LeadsFormController::class, 'search'])->name('leads_forms.search');

	// users route
    Route::get('user-list',        [UserController::class, 'index'])->name('users.index');
    Route::get('user-show/{id}',        [UserController::class, 'show'])->name('user.show');
    Route::get('create-user',      [UserController::class, 'create'])->name('create-user');
    Route::post('create-user',      [UserController::class, 'store'])->name('store-user');
    Route::get('edit-user/{id}',      [UserController::class, 'edit_form'])->name('user.edit');
    Route::post('user-update',      [UserController::class, 'update'])->name('user.update');
    Route::get('user-details/{id}',     [UserController::class, 'show']);
    Route::delete('user-delete/{id}',   [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('permission-list',        [UserController::class, 'permission_index'])->name('permission.index');
    Route::get('permission-show/{id}',        [UserController::class, 'permission_show'])->name('permission.show');
    Route::get('create-permission',      [UserController::class, 'permission_create'])->name('create-permission');
    Route::post('create-permission',      [UserController::class, 'permission_store'])->name('store-permission');
    Route::get('edit-permission/{id}',      [UserController::class, 'permission_edit'])->name('permission.edit');
    Route::post('permission-update',      [UserController::class, 'permission_update'])->name('permission.update');
    Route::get('permission-details/{id}',     [UserController::class, 'permission_show']);
    Route::delete('permission-delete/{id}',   [UserController::class, 'permission_destroy'])->name('permission.destroy');

    Route::get('role-list',        [UserController::class, 'role_index'])->name('role-list');
    Route::get('role-show/{id}',        [UserController::class, 'role_show'])->name('role.show');
    Route::get('role-create',      [UserController::class, 'role_create'])->name('role-create');
    Route::post('role-create',      [UserController::class, 'role_store'])->name('role-store');
    Route::get('role-edit/{id}',      [UserController::class, 'role_edit'])->name('role-edit');
    Route::post('role-update',      [UserController::class, 'role_update'])->name('role-update');
    Route::delete('role-delete/{id}',   [UserController::class, 'role_destroy'])->name('role-destroy');
});