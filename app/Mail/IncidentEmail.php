<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncidentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $incident;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($incident)
    {
        $this->incident = $incident;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.create');
    }
}
