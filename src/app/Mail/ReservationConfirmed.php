<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;
    public Reservation $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation->load(['schedule.performance.troupe', 'details.ticketType']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【ご予約が完了しました。】' . $this->reservation->schedule->performance->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-confirmed',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
