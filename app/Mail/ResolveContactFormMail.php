<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResolveContactFormMail extends Mailable
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
        $mail = $this->subject('Your contact form has been resolved')
            ->replyTo($this->emailData['email'], $this->emailData['name'])
            ->view('emails.resolve-contact')
            ->with([
                'name' => $this->emailData['name'],
                'email' => $this->emailData['email'],
                'subject' => $this->emailData['subject'],
                'messageContent' => $this->emailData['message'],
                'imageUrl' => $this->imageUrl,
                'answer' => $this->emailData['answer'],
            ]);

        return $mail;
    }
}