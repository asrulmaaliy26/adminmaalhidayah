<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;

class ReplyKunjungan extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $replykunjungan;

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $message, $replykunjungan)
    {
        $this->message = $message;
        $this->replykunjungan = $replykunjungan;
    }
    public function build()
    {
        return $this->subject('Balasan Pesan Anda')
                    ->view('back.emails.replykunjungan')
                    ->with([
                        'name' => $this->message->name,
                        'subject' => $this->message->subject,
                        'originalMessage' => $this->message->message,
                        'replykunjungan' => $this->replykunjungan,
                    ]);
    }
}
