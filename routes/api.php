<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PhoneController;
use App\Models\Contact;
use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//CONTACT ROUTES
Route::get('/contact', [ContactController::class, 'index']);
Route::get('/contact/{contact}', [ContactController::class, 'index']);
Route::post('/contact', [ContactController::class, 'create']);
Route::patch('/contact/{contact}', [ContactController::class, 'edit']);
Route::delete('/contact/{contact}', [ContactController::class, 'delete']);

//PHONE ROUTES
Route::delete('/phone/{phone}', [PhoneController::class, 'delete']);