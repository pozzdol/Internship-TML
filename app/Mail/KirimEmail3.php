<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KirimEmail3 extends Mailable
{
    use Queueable, SerializesModels;

    public $data_email;

    /**
     * Create a new message instance.
     *
     * @param array $data_email
     */
    public function __construct(array $data_email)
    {
        $this->data_email = $data_email;
    }

    /**
     * Build the email message.
     *
     * @return $this
     */
    public function build()
    {
        // Memecah sender_name untuk email dan nama
        $fromDetails = explode(',', $this->data_email['sender_name']);
        $fromEmail = $fromDetails[0] ?? config('mail.from.address'); // Ambil email
        $fromName = $fromDetails[1] ?? config('mail.from.name'); // Ambil nama pengirim

        return $this
            ->from(trim($fromEmail), trim($fromName)) // Menentukan pengirim email
            ->subject($this->data_email['subject']) // Subjek email
            ->view('mail.kirimemail3', ['data' => $this->data_email]); // View untuk email
    }
}