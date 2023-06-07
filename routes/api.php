<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShortenController;
use App\Http\Controllers\UserUrlController;
use App\Http\Controllers\ZodiacController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/zdget', [ZodiacController::class, 'getZodiacSigns']);

Route::get('/zod', function(){
    return 'Hello';
});

Route::post('/signup', [AuthController::class, 'signup']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/url/store', [UserUrlController::class, 'store']);

Route::post('/shorten', [ShortenController::class, 'shorten']);

Route::post('/visits', [ShortenController::class, 'visitFrequency']);

// Route::post('/trial', [ShortenController::class, 'redirectToOriginal']);

Route::get('/{value}', [ShortenController::class, 'redirectToOriginal']);


// Route::post('/signup',function(){
//     return 'Hello';
// } );