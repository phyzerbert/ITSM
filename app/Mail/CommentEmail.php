<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $incident, $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($incident, $comment)
    {
        $this->incident = $incident;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.comment');
    }
}
