<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    public $imageUrl;

    /**
     * Create a new message instance.
     *
     * @param array $emailData
     * @param string|null $imageUrl
     * @return void
     */
    public function __construct(array $emailData, $imageUrl = null)
    {
        $this->emailData = $emailData;
        $this->imageUrl = $imageUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject($this->emailData['subject'])
            ->replyTo($this->emailData['email'], $this->emailData['name'])
            ->view('emails.contact')
            ->with([
                'name' => $this->emailData['name'],
                'email' => $this->emailData['email'],
                'subject' => $this->emailData['subject'],
                'messageContent' => $this->emailData['message'],
                'imageUrl' => $this->imageUrl,
            ]);

        return $mail;
    }
}