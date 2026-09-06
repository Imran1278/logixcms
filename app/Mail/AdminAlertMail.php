<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $contentDetails;

    public function __construct($title, $contentDetails)
    {
        $this->title = $title;
        $this->contentDetails = $contentDetails;
    }

    public function build()
    {
        return $this->subject('[Admin Alert] ' . $this->title)
                    ->view('emails.admin_alert');
    }
}