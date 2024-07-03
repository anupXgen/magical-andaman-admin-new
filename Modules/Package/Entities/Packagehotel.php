<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Hotel\Entities\Hotel;

class Packagehotel extends Model
{
    use HasFactory;
    protected $table = 'package_hotels';
    public $timestamps = false;
    protected $fillable = [
        'package_id', 'location_id', 'hotel_id', 'status', 'delete'
    ];
    // public function itineraryimage()
    // {
    //     return $this->hasMany(Itineraryimage::class, 'parent_id');
    // }
    public function package()
    {
        return $this->hasMany(Packagehotel::class, 'package_id');
    }
    public function hotel()
    {
        return $this->belongsTo(hotel::class, 'hotel_id');
    }
}
