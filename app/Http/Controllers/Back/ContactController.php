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
        // Mencari pesan berdasarkan ID
        $message = Contact::findOrFail($id);

        // Validasi input balasan
        $request->validate([
            'replyMessage' => 'required',
        ]);

        // Mengirim email balasan ke pengirim pesan
        Mail::to($message->email)->send(new ReplyMessage($message, $request->replyMessage));

        // Menghapus semua balasan lama dari pesan
        $originalMessage = preg_replace('/\n*\s*--- Balasan:.*/s', '', $message->message);

        // Menambahkan balasan baru di bawah pesan asli tanpa duplikasi balasan lama
        // Mengecek apakah pesan asli sudah diakhiri dengan baris baru
        if (substr($originalMessage, -1) !== "\n") {
            $originalMessage .= "\n";
        }

        // Menambahkan balasan baru setelah pesan asli
        $message->message = $originalMessage . "\n--- Balasan:\n" . $request->replyMessage;

        // Menyimpan perubahan pada message
        $message->save();

        // Redirect kembali dengan notifikasi berhasil
        return redirect()->back()->with('success', 'Balasan berhasil dikirim ke ' . $message->email);
    }
}
