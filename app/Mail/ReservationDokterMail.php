<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationDokterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $status_reservation;

    /**
     * Create a new message instance.
     */
    public function __construct($status_reservation)
    {
         $this->status_reservation = $status_reservation;
    }


    public function build()
    {
        return $this->subject('Konfirmasi Jadwal')
                    ->view('emails.reservationdokter')
                    ->with(['status_reservation' => $this->status_reservation]);
    }


}
