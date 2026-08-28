<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $fillable = [
        'troupe_id',
        'sub_title',
        'title',
        'venue_prefecture',
        'venue_city',
        'period_text',
        'max_tickets_per_person',
        'end_of_reservation_at',
        'notes',
        'form_url_slug',
        'is_published',
    ];

    protected $casts = [
        'end_of_reservation_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function troupe()
    {
        return $this->belongsTo(Troupe::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'performance_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }
}

