<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All API routes for Event Booking System.
| Use Sanctum for authentication.
| Role-based middleware applied for access control.
|
*/

// // PUBLIC ROUTES
// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);

// // PROTECTED ROUTES (Sanctum Auth)
// Route::middleware('auth:sanctum')->group(function () {

//     // Auth routes
//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::get('me', [AuthController::class, 'me']);

//     // EVENTS
//     Route::get('events', [EventController::class, 'index']); // public listing with pagination, search, filter
//     Route::get('events/{id}', [EventController::class, 'show']); // event details with tickets

//     // ORGANIZER ONLY ROUTES
//     Route::middleware('role:organizer')->group(function () {
//         Route::post('events', [EventController::class, 'store']);
//         Route::put('events/{id}', [EventController::class, 'update']);
//         Route::delete('events/{id}', [EventController::class, 'destroy']);

//         Route::post('events/{event_id}/tickets', [TicketController::class, 'store']);
//         Route::put('tickets/{id}', [TicketController::class, 'update']);
//         Route::delete('tickets/{id}', [TicketController::class, 'destroy']);
//     });

//     // CUSTOMER ONLY ROUTES
//     Route::middleware('role:customer')->group(function () {
//         Route::post('tickets/{id}/bookings', [BookingController::class, 'store'])->middleware('prevent.double.booking');
//         Route::get('bookings', [BookingController::class, 'index']);
//         Route::put('bookings/{id}/cancel', [BookingController::class, 'cancel']);

//         Route::post('bookings/{id}/payment', [PaymentController::class, 'process']);
//         Route::get('payments/{id}', [PaymentController::class, 'show']);
//     });

//     // ADMIN ONLY ROUTES
//     Route::middleware('role:admin')->group(function () {
//         Route::apiResource('admin/events', EventController::class);
//         Route::apiResource('admin/tickets', TicketController::class);
//         Route::apiResource('admin/bookings', BookingController::class);
//         Route::apiResource('admin/payments', PaymentController::class);
//     });
// });

// User Auth
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('me',[AuthController::class,'me']);

    // Event
    Route::get('events',[EventController::class,'index']);
    Route::get('events/{id}',[EventController::class,'show']);
    Route::middleware('role:organizer')->group(function(){
        Route::post('events',[EventController::class,'store']);
        Route::put('events/{id}',[EventController::class,'update']);
        Route::delete('events/{id}',[EventController::class,'destroy']);

        Route::post('events/{event_id}/tickets',[TicketController::class,'store']);
        Route::put('tickets/{id}',[TicketController::class,'update']);
        Route::delete('tickets/{id}',[TicketController::class,'destroy']);
    });

    // Booking & Payment (Customer)
    Route::middleware('role:customer')->group(function(){
        Route::post('tickets/{id}/bookings',[BookingController::class,'store'])
        ->middleware(['preventBooking']);
        Route::get('bookings',[BookingController::class,'index']);
        Route::put('bookings/{id}/cancel',[BookingController::class,'cancel']);
        Route::post('bookings/{id}/payment',[PaymentController::class,'process']);
        Route::get('payments/{id}',[PaymentController::class,'show']);
    });
});
