<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Auth::user()->contacts;
        return response()->json($contacts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|string',
            'address' => 'nullable|string',
        ]);

        $contact = Auth::user()->contacts()->create($request->all());

        return response()->json($contact, 201);
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);
        return response()->json($contact);
    }

    public function update(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|string',
            'address' => 'nullable|string',
        ]);

        $contact->update($request->all());

        return response()->json($contact);
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return response()->json(null, 204);
    }
}
