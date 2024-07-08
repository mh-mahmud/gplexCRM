<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeadsFormController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DynamicTableController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;


use App\Models\Promotion;

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

//Route::get('/login', [AuthController::class, 'index'])->name('login');
//Route::post('/post_login', [AuthController::class, 'postLogin'])->name('login.post');
/*Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');*/
Route::get('/', [AuthController::class, 'index'])->name('login_index');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post_login', [AuthController::class, 'postLogin'])->name('login.post');


Route::group(['middleware' => 'auth'], function () {
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
	Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
	Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
	// agents route
	Route::get('/agents', [AgentController::class, 'index'])->name('agents-index');
    Route::get('/agents/create', [AgentController::class, 'create'])->name('agents-create');
	Route::post('/agents', [AgentController::class, 'store'])->name('agents-store');
	Route::get('/agents/{id}', [AgentController::class, 'show'])->name('agents-show');
	Route::get('/agents/{id}/edit', [AgentController::class, 'edit'])->name('agents-edit');
	Route::put('/agents/{id}', [AgentController::class, 'update'])->name('agents-update');
	Route::post('/agents/search', [AgentController::class, 'search'])->name('agents-search');
	Route::delete('/agents/{id}', [AgentController::class, 'destroy'])->name('agents-destroy');

	// Lead routes
	Route::get('/lead', [LeadController::class, 'index'])->name('lead-index');
	Route::get('/lead/create', [LeadController::class, 'create'])->name('lead-create');
	Route::get('/lead/leads-upload', [LeadController::class, 'leads_upload'])->name('leads-upload');
	Route::get('/lead/sample-file', [LeadController::class, 'downloadSampleFile'])->name('sample-file');
	Route::post('/lead/upload', [LeadController::class, 'upload_file'])->name('lead-upload-file');
    Route::post('/lead', [LeadController::class, 'store'])->name('lead-store');
	Route::get('/lead/{id}', [LeadController::class, 'show'])->name('lead-show');
	Route::get('/lead/{id}/edit', [LeadController::class, 'edit'])->name('lead-edit');
	Route::put('/lead/{id}', [LeadController::class, 'update'])->name('lead-update');
	Route::delete('/lead/{id}', [LeadController::class, 'destroy'])->name('lead-destroy');
	Route::post('/lead/search', [LeadController::class, 'search'])->name('lead-search');
	
    //Lead Form route
	Route::get('/leads-forms', [LeadsFormController::class, 'index'])->name('leadsform-index');
	Route::get('/leads-forms/create', [LeadsFormController::class, 'create'])->name('leadsform-create');
	Route::post('/leads-forms', [LeadsFormController::class, 'store'])->name('leadsform-store');
	Route::get('/leads-forms/{id}', [LeadsFormController::class, 'show'])->name('leadsform-show');
	Route::get('/leads-forms/{id}/edit', [LeadsFormController::class, 'edit'])->name('leadsform-edit');
	Route::put('/leads-forms/{id}', [LeadsFormController::class, 'update'])->name('leadsform-update');
	Route::delete('/leads-forms/{id}', [LeadsFormController::class, 'destroy'])->name('leadsform-destroy');
	Route::post('/leads-forms/search', [LeadsFormController::class, 'search'])->name('leadsform-search');
	

	//Lead dynamic table route
	Route::get('/dynamic-table', [DynamicTableController::class, 'index'])->name('dynamictable-index');
	Route::get('/dynamic-table/create', [DynamicTableController::class, 'create'])->name('dynamictable-create');
	Route::get('/dynamic-table/{id}/edit', [DynamicTableController::class, 'edit'])->name('dynamictable-edit');
    Route::put('/dynamic-table/{id}', [DynamicTableController::class, 'update'])->name('dynamictable-update');
	Route::post('dynamic-table/create', [DynamicTableController::class, 'createTable'])->name('dynamictable-store');
	Route::get('/dynamic-table/{tableName}', [DynamicTableController::class, 'show'])->name('dynamictable-show');
	Route::delete('/dynamic-table/{id}', [DynamicTableController::class, 'destroy'])->name('dynamictable-destroy');
	Route::post('/dynamic-table/search', [DynamicTableController::class, 'search'])->name('dynamictable-search');

    //promotion route
	Route::get('/promotion', [PromotionController::class, 'index'])->name('promotion-index');
	Route::get('/promotion/create', [PromotionController::class, 'create'])->name('promotion-create');
	Route::post('/promotion', [PromotionController::class, 'store'])->name('promotion-store');
	Route::get('/promotion/{id}', [PromotionController::class, 'show'])->name('promotion-show');
	Route::get('/promotion/{id}/edit', [PromotionController::class, 'edit'])->name('promotion-edit');
	Route::put('/promotion/{id}', [PromotionController::class, 'update'])->name('promotion-update');
	Route::delete('/promotion/{id}', [PromotionController::class, 'destroy'])->name('promotion-destroy');
	Route::post('/promotion/search', [PromotionController::class, 'search'])->name('promotion-search');

	//Campaign route
	Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign-index');
	Route::get('/campaign/create', [CampaignController::class, 'create'])->name('campaign-create');
	Route::post('/campaign', [CampaignController::class, 'store'])->name('campaign-store');
	Route::get('/campaign/{id}', [CampaignController::class, 'show'])->name('campaign-show');
	Route::get('/campaign/{id}/edit', [CampaignController::class, 'edit'])->name('campaign-edit');
	Route::put('/campaign/{id}', [CampaignController::class, 'update'])->name('campaign-update');
	Route::delete('/campaign/{id}', [CampaignController::class, 'destroy'])->name('campaign-destroy');
	Route::post('/campaign/search', [CampaignController::class, 'search'])->name('campaign-search');
	Route::post('/clear-session', [CampaignController::class, 'clearSession'])->name('clear.session');


	// users route
    Route::get('user-list',        [UserController::class, 'index'])->name('users.index');
    Route::get('user-show/{id}',        [UserController::class, 'show'])->name('user.show');
    Route::get('create-user',      [UserController::class, 'create'])->name('create-user');
    Route::post('create-user',      [UserController::class, 'store'])->name('store-user');
    Route::get('edit-user/{id}',      [UserController::class, 'edit_form'])->name('user.edit');
    Route::post('user-update',      [UserController::class, 'update'])->name('user.update');
    Route::get('user-details/{id}',     [UserController::class, 'show']);
    Route::delete('user-delete/{id}',   [UserController::class, 'destroy'])->name('user.destroy');
	Route::get('user-profile/{id}',        [UserController::class, 'user_profile'])->name('user-profile');
	Route::get('/account-settings/{id}/edit', [UserController::class, 'profile_edit'])->name('profile-edit');
	Route::put('/account-settings/{id}', [UserController::class, 'profile_update'])->name('profile-update');

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

	// Email template routes start
	Route::get('email-template', [EmailController::class, 'emailTemplateList'])->name('email-template');
	Route::get('email-template/create', [EmailController::class, 'templateCreate'])->name('email-template-create');
	Route::post('email-template/store', [EmailController::class, 'templateStore'])->name('email-template-store');
	Route::get('email-template/edit/{id}', [EmailController::class, 'templateEdit'])->name('email-template-edit');
	Route::get('email-template/show/{id}', [EmailController::class, 'templateShow'])->name('email-template-show');
	Route::put('email-template/update/{id}', [EmailController::class, 'templateUpdate'])->name('email-template-update');
	Route::delete('email-template/delete/{id}', [EmailController::class, 'templateDelete'])->name('email-template-delete');
	// Email template routes end

	// Send email routes start
	Route::get('send-email', [EmailController::class, 'sendEmail'])->name('send-email');
	Route::post('send-email-process', [EmailController::class, 'sendEmailPro'])->name('send-email-process');
	Route::get('send-email-list', [EmailController::class, 'sendEmailList'])->name('send-email-list');
	Route::get('send-bulk-email', [EmailController::class, 'sendBulkEmail'])->name('send-bulk-email');
	Route::post('send-bulk-email-process', [EmailController::class, 'sendBulkEmailPro'])->name('send-bulk-email-process');


	// Send email routes end

	// Sms template routes start
	Route::get('sms-template', [SmsController::class, 'smsTemplateList'])->name('sms-template');
	Route::get('sms-template/create', [SmsController::class, 'templateCreate'])->name('sms-template-create');
	Route::post('sms-template/store', [SmsController::class, 'templateStore'])->name('sms-template-store');
	Route::get('sms-template/edit/{id}', [SmsController::class, 'templateEdit'])->name('sms-template-edit');
	Route::get('sms-template/show/{id}', [SmsController::class, 'templateShow'])->name('sms-template-show');
	Route::put('sms-template/update/{id}', [SmsController::class, 'templateUpdate'])->name('sms-template-update');
	Route::delete('sms-template/delete/{id}', [SmsController::class, 'templateDelete'])->name('sms-template-delete');
	// SMS template routes end

	// Send SMS routes start
	Route::get('send-sms', [smsController::class, 'sendSms'])->name('send-sms');
	Route::post('send-sms-process', [smsController::class, 'sendSmsPro'])->name('send-sms-pro');
	Route::get('send-sms-list', [smsController::class, 'sendSmsList'])->name('send-sms-list');
	Route::get('send-bulk-sms', [smsController::class, 'sendBulkSms'])->name('send-bulk-sms');
	Route::post('send-bulk-sms-process', [smsController::class, 'sendBulkSmsPro'])->name('send-bulk-sms-pro');

	// Send SMS routes end

	// Task routes start
	Route::get('task-list', [TaskController::class, 'getTaskList'])->name('task-list');
	Route::get('add-task', [TaskController::class, 'addTask'])->name('add-task');
	Route::post('add-task-pro', [TaskController::class, 'addTaskPro'])->name('add-task-pro');
	Route::put('task-status-change/{id}', [TaskController::class, 'changeStatus'])->name('task-status-change');
	Route::delete('delete-task/{id}', [TaskController::class, 'delete'])->name('delete-task');

	// Task routes end


	// Product routes start
	Route::get('product-list', [ProductController::class, 'productList'])->name('product-list');
	Route::get('add-product', [ProductController::class, 'productCreate'])->name('add-product');
	Route::post('add-product-pro', [ProductController::class, 'productStore'])->name('add-product-pro');
	Route::delete('product-delete/{id}', [ProductController::class, 'productDelete'])->name('product-delete');
	Route::get('product-show/{id}', [ProductController::class, 'productShow'])->name('product-show');
	Route::get('product-edit/{id}', [ProductController::class, 'productEdit'])->name('product-edit');
	Route::put('product-update-pro/{id}', [ProductController::class, 'productUpdate'])->name('product-update-pro');


	// Product routes end

});