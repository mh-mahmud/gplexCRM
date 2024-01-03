<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesManController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// public routes
Route::get("/products", [ProductController::class, 'index']);
Route::get("/products/{id}", [ProductController::class, 'show']);
Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);




// protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
	Route::get('/products/search/{name}', [ProductController::class, 'search']);
	Route::post("/products", [ProductController::class, 'store']);
	Route::put("/products/{id}", [ProductController::class, 'update']);
	Route::delete("/products/{id}", [ProductController::class, 'destroy']);
	Route::post("/logout", [AuthController::class, 'logout']);

	// salesman management
	Route::get("/salesman-list", [SalesManController::class, 'index']);
	Route::post("/salesman-create", [SalesManController::class, 'store']);
	Route::put("/salesman-update/{id}", [SalesManController::class, 'update']);
	Route::get("/salesman/{id}", [SalesManController::class, 'show']);
	Route::delete("/salesman/{id}", [SalesManController::class, 'destroy']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
