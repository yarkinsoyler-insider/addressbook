<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    // Tüm kullanıcıya ait kontakları getir
    public function index()
    {
        $contacts = Auth::user()->contacts; // Kullanıcının tüm kontaklarını al
        return response()->json($contacts);
    }

    // Yeni bir kontakt oluştur
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

    // Belirli bir kontağı getir
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact); // Kullanıcının yetkisini doğrula
        return response()->json($contact);
    }

    // Bir kontağı güncelle
    public function update(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact); // Kullanıcının yetkisini doğrula

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|string',
            'address' => 'nullable|string',
        ]);

        $contact->update($request->all());

        return response()->json($contact);
    }

    // Bir kontağı sil
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact); // Kullanıcının yetkisini doğrula

        $contact->delete();

        return response()->json(null, 204);
    }
}
