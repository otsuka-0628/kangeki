<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'performance_schedules';

    protected $fillable = [
        'performance_id',
        'start_at',
        'capacity',
    ];

    protected $casts = [
        'start_at' => 'datetime',
    ];

    public function performance()
    {
        return $this->belongsTo(Performance::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'performance_schedule_id');
    }


    public function reservationDetails(): HasManyThrough
    {
        return $this->hasManyThrough(
            ReservationDetail::class,
            Reservation::class,
            'performance_schedule_id', // Reservation テーブルの外部キー
            'reservation_id' // ReservationDetail テーブルの外部キー
        );
    }
}
