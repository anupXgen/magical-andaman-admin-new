<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Itinerary extends Model
{
    use HasFactory;
    protected $table = 'itinerarys';
    public $timestamps = false;
    protected $fillable = [
        'location_id', 'package_id','sightseeing_id', 'hotel_id', 'hotel_category', 'activity_id', 'itinerary_day', 'title', 'subtitle'
    ];
    public function itineraryimage()
    {
        return $this->hasMany(Itineraryimage::class, 'parent_id');
    }
    public function package()
    {
        return $this->hasMany(Itinerary::class, 'package_id');
    }
}
