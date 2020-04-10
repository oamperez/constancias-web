<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailConstancia extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $archive;

    public function __construct($user, $archive)
    {
        $this->user = $user;
        $this->archive = $archive;
    }

    public function build()
    {
        $mailable = $this->from('fifcoone@fifco.com')->view('emails.constancia')->with('Envio de Constancia', $this->user)->subject('Fifco')->attach($this->archive);
        return $mailable;
    }
}
