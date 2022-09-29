<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($txt)
    {
        $this->order = $txt;
    //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this;
        /* return '1111'; */
        /* return $this->view('mail'); */
    }
}
