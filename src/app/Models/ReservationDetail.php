<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'ticket_type_id',
        'quantity',
    ];

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
