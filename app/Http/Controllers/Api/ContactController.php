<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email',
                'message' => 'required|string',
            ]);

            // If validation passes, create the contact entry
            $contact = Contact::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'message' => $validatedData['message'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Thank you for contacting us. We will get back to you shortly.',
                'data' => $contact,
            ], 200); // HTTP status code for created resource
        } catch (\Illuminate\Validation\ValidationException $e) {
            // If validation fails, return error response
            return response()->json([
                'status' => false,
                'error' => $e->errors(),
            ], 422); // 422 Unprocessable Entity for validation errors
        }


    }
}
