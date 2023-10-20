<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Activaciones extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $activ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($activ)
    {
        $this->activ = $activ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Activaciones de usuarios')
                    ->view('emails.activaciones')
                    ->with('activaciones', $this->activ);
    }
}