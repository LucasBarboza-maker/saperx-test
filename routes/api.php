<?php

use App\Http\Controllers\ContactController;
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

Route::get('/contact', [ContactController::class, 'index']);

Route::post('/contact', [ContactController::class, 'create']);

Route::patch('/contact/{contact}', [ContactController::class, 'edit']);