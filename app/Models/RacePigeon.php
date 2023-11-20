<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RacePigeon extends Model
{
    use HasFactory;

    protected $fillable = [
        'race_id',
        'pigeon_id',
        'speed',
        'start_date_time',
        'end_date_time'
    ];

    public function pigeon()
    {
        return $this->belongsTo(Pigeon::class, 'pigeon_id', 'id');
    }

    public function race()
    {
        return $this->belongsTo(Race::class, 'race_id', 'id');
    }
}
