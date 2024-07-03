<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SightSeeing\Entities\Sightseeing;

class Packagesightseeing extends Model
{
    use HasFactory;
    protected $table = 'package_sightseeings';
    public $timestamps = false;
    protected $fillable = [
        'package_id', 'location_id', 'sightseeing_id', 'status', 'delete'
    ];
    // public function itineraryimage()
    // {
    //     return $this->hasMany(Itineraryimage::class, 'parent_id');
    // }
    public function package() 
    {
        return $this->hasMany(Packagesightseeing::class, 'package_id');
    }
    public function sightseeing_pkg()
    {
        return $this->belongsTo('Modules\SightSeeing\Entities\Sightseeing', 'sightseeing_id');
    }
}
