<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeeAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fee;
    public $admission;

    public function __construct($fee, $admission)
    {
        $this->fee = $fee;
        $this->admission = $admission;
    }

    public function build()
    {
        return $this->subject('New Fee Voucher Generated - Logix College')
                    ->markdown('emails.fee_assigned');
    }
}