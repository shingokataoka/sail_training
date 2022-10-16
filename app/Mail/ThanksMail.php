<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThanksMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $items;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $items)
    {
        $this->user = $user;
        $this->items = $items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('ご購入が完了しました。')
            ->view('mails.thanks');
    }
}
