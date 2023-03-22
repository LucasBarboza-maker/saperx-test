<?php

namespace App\Http\Controllers;
use App\Models\Phone;
use Exception;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    
    public function delete(Phone $phone){
        try {
            
            $phone->delete();

            return response()->json(['message' => 'Success!']);
        } catch (Exception  $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
