<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactImportController;
use App\Http\Controllers\MailingsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [CompanyController::class, 'register']);
Route::get('/auth', [AuthController::class, 'auth']);
Route::get('/notes', [NotesController::class, 'notes']);
Route::post('/notes', [NotesController::class, 'create']);
Route::put('/notes/{id}', [NotesController::class, 'update']);
Route::delete('/notes/{id}', [NotesController::class, 'destroy']);
Route::post("/products", [ProductController::class, 'store']);
Route::get("/products", [ProductController::class, 'index']);
Route::get("/products/{id}", [ProductController::class, 'show']);
Route::get("/product/{id}/reservations", [ProductController::class, 'reservationsForThisProduct']);
Route::put("/products/update/{id}", [ProductController::class, 'update']);
Route::delete("/products/{id}", [ProductController::class, 'destroy']);
Route::get("/product-options", [ProductController::class, 'productsOptions']);
Route::get("/number-of-products", [ProductController::class, 'numberOfTotalProducts']);
Route::get('/contacts', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/contact/{id}', [ContactController::class, 'show']);
Route::put('/contacts/{id}', [ContactController::class, 'update']);
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
Route::get('/contact-options', [ContactController::class, 'contactsOptions']);
Route::get('/contacts-number', [ContactController::class, 'totalContactsNumber']);
Route::get('/reservations', [ReservationController::class, 'index']);
Route::get('/reservation/{id}', [ReservationController::class, 'show']);
Route::post('/reservations', [ReservationController::class, 'store']);
Route::put('/reservations/{id}', [ReservationController::class, 'update']);
Route::delete('/reservations/{id}', [ReservationController::Class, 'destroy']);
Route::get('/contacts/download/pdf', [ContactController::class, 'downloadContactsPdf']);
Route::get('/reservations/download/pdf', [ReservationController::class, 'downloadReservations']);
Route::post('/contacts/import', [ContactImportController::class, 'import']);
Route::get('reservations/overdue', [ReservationController::class, 'overdue']);
Route::get('reservations-number', [ReservationController::class, 'totalNumberOfReservations']);
Route::get('reservations-of-today', [ReservationController::class, 'todaysReservations']);
Route::get('/mailings', [MailingsController::class, 'index']);
Route::post('/mailings', [MailingsController::class, 'store']);
Route::get('/mailings/{id}', [MailingsController::class, 'show']);
Route::put('/mailings/{id}', [MailingsController::class, 'update']);
Route::delete('/mailings/{id}', [MailingsController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
