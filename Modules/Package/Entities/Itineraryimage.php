<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Itineraryimage extends Model
{
    use HasFactory;
    protected $table = 'itinerary_images';
    public $timestamps = false;
    protected $fillable = [
        'path', 'parent_id','size'
    ];
    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class, 'parent_id');
    }
}
