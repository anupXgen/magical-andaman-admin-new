<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sightseeing_location extends Model
{
    use HasFactory;
    protected $table = 'sightseeing_location';

    protected $fillable = [
        'title',
        'sightseeing_id',
        'subtitle',
        'xuv_price',
        'sedan_price',
        'hatchback_price',
        'duration',
        'entry_fees',
        'parking_fees',
        'updated_at',
        'created_at',
        'status',
    ];
}
