<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Troupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'representative_name',
        'prefecture',
        'description',
    ];

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
