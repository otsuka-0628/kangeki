<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $fillable = [
        'troupe_id',
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

    // 日時やブーリアン（真偽値）として扱う設定
    // これをしておくと、Blade等で日付のフォーマット（例: $performance->end_of_reservation_at->format('Y/m/d H:i')）が使えてめちゃ楽！
    protected $casts = [
        'end_of_reservation_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    // 1つの公演は「1つの劇団」に属する
    public function troupe()
    {
        return $this->belongsTo(Troupe::class);
    }
}

