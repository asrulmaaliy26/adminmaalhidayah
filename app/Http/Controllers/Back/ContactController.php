<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReplyMessage;


class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

        return view('back.contact.index', compact('contacts'));
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

    public function reply(Request $request, $id)
    {
        $message = Contact::findOrFail($id);

        // Validasi input balasan
        $request->validate([
            'replyMessage' => 'required',
        ]);

        // Mengirim email ke pengirim pesan
        Mail::to($message->email)->send(new ReplyMessage($message, $request->replyMessage));

        return redirect()->back()->with('success', 'Balasan berhasil dikirim ke ' . $message->email);
    }
}
