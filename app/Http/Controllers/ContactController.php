<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Phone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{

    public function index(Contact $contact, Request $request)
    {
        try {
            $contacts = Contact::query();

            
            if ($contact->id) {
                $results = $contact->with('phone')->where('id', $contact->id)->get();
                return response()->json($results);
            }

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
        } catch (Exception  $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function create(Request $request)
    {
        Log::info('Response:', $request->all());

        try {

            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'birth' => 'required|date',
                'cpf' => 'required|string',
            ]);


            $contact = new Contact();
            $contact->name = $validatedData['name'];
            $contact->email = $validatedData['email'];
            $contact->birth = $validatedData['birth'];
            $contact->cpf = $validatedData['cpf'];
            $contact->save();


            foreach ($request->phone as $relatedModelData) {
                $relatedModel = new Phone();
                $relatedModel->fill($relatedModelData);
                $contact->phone()->save($relatedModel);
            }

            return response()->json(['message' => 'Success!']);
        } catch (Exception  $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function edit(Request $request, Contact $contact)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'birth' => 'required|date',
                'cpf' => 'required|string',
            ]);

            $contact->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'birth' => $validatedData['birth'],
                'cpf' => $validatedData['cpf']
            ]);

            $contact->phone()->delete();

            foreach ($request->phone as $phoneInfo) {
                $phone = $contact->phone();

                $phone->create([
                    'phone_number' => $phoneInfo["phone_number"]
                ]);
            }


            return response()->json(['message' => 'Success!']);
        } catch (Exception  $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function delete(Request $request, Contact $contact)
    {
        try {

            $contact->phone()->delete();
            $contact->delete();

            return response()->json(['message' => 'Success!']);
        } catch (Exception  $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
