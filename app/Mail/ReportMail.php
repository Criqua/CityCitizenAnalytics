<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cities;

    public function __construct($cities)
    {
        $this->cities = $cities;
    }

    public function build()
    {
        return $this->subject('Citizen Report by City')
                    ->view('emails.report')
                    ->with([
                        'cities' => $this->cities,
                    ]);
    }
}
