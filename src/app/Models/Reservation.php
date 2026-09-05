<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'performance_schedule_id',
        'reservation_token',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
        'status',
        'is_checked_in',
    ];

    public function details()
    {
        return $this->hasMany(ReservationDetail::class, 'reservation_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'performance_schedule_id');
    }



}
