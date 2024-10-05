<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;

class ReplyMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $replyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $message, $replyMessage)
    {
        $this->message = $message;
        $this->replyMessage = $replyMessage;
    }
    public function build()
    {
        return $this->subject('Balasan Pesan Anda')
                    ->view('back.emails.reply')
                    ->with([
                        'name' => $this->message->name,
                        'subject' => $this->message->subject,
                        'originalMessage' => $this->message->message,
                        'replyMessage' => $this->replyMessage,
                    ]);
    }
}
