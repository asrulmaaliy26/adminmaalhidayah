<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

        return view('back.contact.index',compact('contacts'));
    }
    public function deleteContact($contact_id)
    {
        // Temukan kontak berdasarkan contact_id
        $contact = Contact::where('contact_id', $contact_id)->first();

        // Periksa apakah kontak ditemukan
        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact not found'
            ], 404);
        }

        // Hapus kontak
        $contact->delete();

        // Kembalikan respons JSON
        toastr('Pesan Berhasil Dihapus', 'success', 'Success!');
        return redirect()->back();
    }
}
