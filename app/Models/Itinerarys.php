<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerarys extends Model
{
    use HasFactory;
    protected $table = 'itinerarys';

    protected $fillable = [
        'location_id',
        'package_id',
        'sightseeing_id',
        'hotel_id',
        'hotel_category',
        'activity_id',
        'itinerary_day',
        'title',
        'subtitle',
        'created_at',
        'status',
    ];
}
