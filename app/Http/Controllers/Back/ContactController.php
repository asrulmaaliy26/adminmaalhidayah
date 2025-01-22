<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReplyMessage;
use App\Mail\ReplyKunjungan;


class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        $kunjungan = Contact::where('pendidikan', 'kunjungan')->get();

        // Memproses data message untuk setiap kunjungan
        foreach ($kunjungan as $contact) {
            $names = explode(' - ', $contact->name);
            $contact->penanggungJawab = $names[0] ?? null;
            $contact->lembaga = $names[1] ?? null;
            
            // Memproses message untuk mendapatkan data terpisah
            preg_match('/nomor:\s*(\S+)/', $contact->message, $nomor);
            preg_match('/Jumlah Guru:\s*(\d+)/', $contact->message, $jumlahGuru);
            preg_match('/Jumlah Siswa:\s*(\d+)/', $contact->message, $jumlahSiswa);
            preg_match('/Tanggal:\s*(\d{4}-\d{2}-\d{2})/', $contact->message, $tanggal);
            preg_match('/Keterangan:\s*(.*)/', $contact->message, $keterangan);
            preg_match('/--- Balasan:\s*(.*)/', $contact->message, $balasan);

            // Menyimpan data yang telah diproses dalam atribut sementara
            $contact->nomor = $nomor[1] ?? null;
            $contact->jumlahGuru = $jumlahGuru[1] ?? null;
            $contact->jumlahSiswa = $jumlahSiswa[1] ?? null;
            $contact->tanggal = $tanggal[1] ?? null;
            $contact->keterangan = $keterangan[1] ?? null;
            $contact->status = $balasan[1] ?? 'Tidak ada balasan';
        }

        // Memproses data message untuk setiap kunjungan
        foreach ($contacts as $contact) {
            
            preg_match('/--- Balasan:\s*(.*)/', $contact->message, $balasan);

            $contact->status = $balasan[1] ?? 'Tidak ada balasan';
        }

        return view('back.contact.index', compact('contacts', 'kunjungan'));
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

    public function replykunjungan(Request $request, $id)
    {
        // Mencari pesan berdasarkan ID
        $message = Contact::findOrFail($id);

        // Validasi input balasan
        $request->validate([
            'replykunjungan' => 'required',
        ]);

        // Mengirim email balasan ke pengirim pesan
        Mail::to($message->email)->send(new ReplyKunjungan($message, $request->replykunjungan));

        // Menghapus semua balasan lama dari pesan
        $originalMessage = preg_replace('/\n*\s*--- Balasan:.*/s', '', $message->message);

        // Menambahkan balasan baru di bawah pesan asli tanpa duplikasi balasan lama
        // Mengecek apakah pesan asli sudah diakhiri dengan baris baru
        if (substr($originalMessage, -1) !== "\n") {
            $originalMessage .= "\n";
        }

        // Menambahkan balasan baru setelah pesan asli
        $message->message = $originalMessage . "\n--- Balasan:\n" . $request->replykunjungan;

        // Menyimpan perubahan pada message
        $message->save();

        // Redirect kembali dengan notifikasi berhasil
        return redirect()->back()->with('success', 'Balasan berhasil dikirim ke ' . $message->email);
    }
}
