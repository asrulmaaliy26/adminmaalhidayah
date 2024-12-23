<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;

class ReplyKunjungan extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $replykunjungan;
    public $penanggungJawab;
    public $lembaga;
    public $nomor;
    public $jumlahGuru;
    public $jumlahSiswa;
    public $tanggal;
    public $keterangan;

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $message, $replykunjungan)
    {
        $this->message = $message;
        $this->replykunjungan = $replykunjungan;

        // Memproses data tambahan
        $names = explode(' - ', $message->name);
        $this->penanggungJawab = $names[0] ?? null;
        $this->lembaga = $names[1] ?? null;

        preg_match('/nomor:\s*(\S+)/', $message->message, $nomor);
        preg_match('/Jumlah Guru:\s*(\d+)/', $message->message, $jumlahGuru);
        preg_match('/Jumlah Siswa:\s*(\d+)/', $message->message, $jumlahSiswa);
        preg_match('/Tanggal:\s*(\d{4}-\d{2}-\d{2})/', $message->message, $tanggal);
        preg_match('/Keterangan:\s*(.*)/', $message->message, $keterangan);

        $this->nomor = $nomor[1] ?? null;
        $this->jumlahGuru = $jumlahGuru[1] ?? null;
        $this->jumlahSiswa = $jumlahSiswa[1] ?? null;
        $this->tanggal = $tanggal[1] ?? null;
        $this->keterangan = $keterangan[1] ?? null;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Balasan Pesan Kunjungan')
                    ->view('back.emails.replykunjungan')
                    ->with([
                        'penanggungJawab' => $this->penanggungJawab,
                        'lembaga' => $this->lembaga,
                        'nomor' => $this->nomor,
                        'jumlahGuru' => $this->jumlahGuru,
                        'jumlahSiswa' => $this->jumlahSiswa,
                        'tanggal' => $this->tanggal,
                        'keterangan' => $this->keterangan,
                        'replykunjungan' => $this->replykunjungan,
                    ]);
    }
}
