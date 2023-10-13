<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pigeon extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'ring_number',
        'color_description',
        'status',
        'sex',
        'notes',
        'date_hatched',
        'dam_id',
        'sire_id',
        'owner_id',
        'img_url'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function dam(): BelongsTo
    {
        return $this->belongsTo(Pigeon::class, 'dam_id', 'id');
    }

    public function sire(): BelongsTo
    {
        return $this->belongsTo(Pigeon::class, 'sire_id', 'id');
    }
}
