<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custom_package_hotel extends Model
{
    use HasFactory;
    protected $table = 'custom_package_hotel';

    protected $fillable = [
        'custom_package_id',
        'itinerary_day',
        'hotel_id',
        'category_id',
        'cp',
        'map',
        'ap',
        'ep',
        'extra_person_with_mattres',
        'extra_person_without_mattres',
        'meal',
        'flower_bed_decoration',
        'candle_light_dinner',
        'status',
        'delete',
        'created_at',
        'created_by',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotels::class);
    }
}
