<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel_facility extends Model
{
    use HasFactory;
    protected $table = 'hotel_facilities';
    public $timestamps = false;

    protected $fillable = [
        'hotel_id',
        'meal_price',
        'flower_bed_price',
        'candle_light_dinner_price',
        'extra_person_with_mattres',
        'extra_person_without_mattres',
        'created_at',
        'created_by',
        'status',
    ];
}
