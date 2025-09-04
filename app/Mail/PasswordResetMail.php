<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param string $resetLink
     * @param User $user
     * @return void
     */
    public function __construct(string $resetLink, User $user)
    {
        $this->resetLink = $resetLink;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Restablecimiento de contraseña')
                    ->view('emails.password-reset')
                    ->with([
                        'resetLink' => $this->resetLink,
                        'user' => $this->user
                    ]);
    }
}
