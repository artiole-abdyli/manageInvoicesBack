<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [CompanyController::class, 'register']);
Route::get('/auth', [AuthController::class, 'auth']);

Route::post("/products", [ProductController::class, 'store']);
Route::get("/products", [ProductController::class, 'index']);
Route::get("/products/{id}", [ProductController::class, 'show']);
Route::get("/product/{id}/reservations", [ProductController::class, 'reservationsForThisProduct']);
Route::put("/products/update/{id}", [ProductController::class, 'update']);
Route::delete("/products/{id}", [ProductController::class, 'destroy']);
Route::get("/product-options", [ProductController::class, 'productsOptions']);
Route::get('/contacts', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/contact/{id}', [ContactController::class, 'show']);
Route::put('/contacts/{id}', [ContactController::class, 'update']);
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
Route::get('/contact-options', [ContactController::class, 'contactsOptions']);

Route::get('/reservations', [ReservationController::class, 'index']);
Route::get('/reservation/{id}', [ReservationController::class, 'show']);
Route::post('/reservations', [ReservationController::class, 'store']);
Route::put('/reservations/{id}', [ReservationController::class, 'update']);
Route::delete('/reservations/{id}', [ReservationController::Class, 'destroy']);
Route::get('/contacts/download/pdf', [ContactController::class, 'downloadContactsPdf']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
