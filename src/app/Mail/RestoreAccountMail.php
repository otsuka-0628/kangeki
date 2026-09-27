<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestoreAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $url;

    public function __construct(User $user, string $url)
    {
        $this->user = $user;
        $this->url = $url;//
    }

    public function build()
    {
        return $this->subject('【劇団アプリ】アカウント復旧手続きのご案内')
            ->view('emails.restore');
    }
}
