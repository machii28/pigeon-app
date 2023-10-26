<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'race_name',
        'starting_point',
        'ending_point',
        'distance',
        'start_date',
        'end_date'
    ];
}
