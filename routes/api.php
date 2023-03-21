<?php

use App\Models\Contact;
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

Route::get('/', function (Request $request) {
    $contacts = Contact::query();

    $contacts->with('phone');

    if ($request->has('name')) {
        $contacts->where('name', 'like', '%' . $request->input('name') . '%');
    }

    if ($request->has('email')) {
        $contacts->where('email', 'like', '%' . $request->input('email') . '%');
    }

    if ($request->has('birth')) {
        $contacts->where('birth', 'like', '%' . $request->input('birth') . '%');
    }

    if ($request->has('cpf')) {
        $contacts->where('cpf', 'like', '%' . $request->input('cpf') . '%');
    }
    
    $contacts->select('contact.id as id', 'contact.name', 'contact.email', 'contact.birth', 'contact.cpf');

    $contacts->paginate(10);


    $results = $contacts->get();

    return response()->json($results);
});

