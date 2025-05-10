<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The verification URL.
     *
     * @var string
     */
    public $verificationUrl;

    /**
     * The user model.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param string $verificationUrl
     * @param \App\Models\User $user
     * @return void
     */
    public function __construct($verificationUrl, $user)
    {
        $this->verificationUrl = $verificationUrl;
        $this->user = $user;
    }

    /**
 * Get the message envelope.
 *
 * @return \Illuminate\Mail\Mailables\Envelope
 */
public function envelope(): Envelope
{
    return new Envelope(
        subject: 'Verify Your Email Address',
        from: new Address('verify@bossloot.com', 'BossLoot Verification'),
        tags: ['verification', 'user-verification'],
        metadata: [
            'user_id' => $this->user->id,
        ],
    );
}

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verification_email',
            with: [
                'verificationUrl' => $this->verificationUrl,
                'user' => $this->user,
                'expiresIn' => config('auth.verification.expire', 60), // Tiempo de expiración en minutos
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}