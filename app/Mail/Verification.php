<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Verification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $arr = [
            'id' => $this->user->id,
            'code' => $this->user->verification,
            'expire' => now()->addDays(15)
        ];

        $url = route('email.verify', ['v' => encrypt($arr)]);
        return $this->view('mail.verification')->with('url', $url);
    }
}
