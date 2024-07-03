<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    protected $table = 'packages';
    protected $fillable = [
        'title', 'subtitle', 'day', 'night', 'created_at', 'updated_at', 'status', 'delete'
    ];
    public function packageimage()
    {
        return $this->hasMany(Packageimage::class, 'parent_id');
    }
    public function packagestyle()
    {
        return $this->hasMany(Packagestyle::class, 'package_id');
    }
  
    public function packagefeature()
    {
        return $this->hasOne(Packagefeature::class, 'parent_id');
    }
    public function itinerary()
    {
        return $this->hasMany(Itinerary::class, 'package_id');
    }
    public function policy()
    {
        return $this->hasMany(Policy::class, 'package_id');
    }
    public function typeprice()
    {
        return $this->hasMany(Typeprice::class, 'package_id');
    }
    public function packagehotel()
    {
        return $this->hasMany(Packagehotel::class, 'package_id');
    }
    public function packagesightseeing()
    {
        return $this->hasMany(Packagesightseeing::class, 'package_id');
    }
    public function packageactivity()
    {
        return $this->hasMany(Packageactivity::class, 'package_id');
    }
    // public function fromlocation()
    // {
    //     return $this->hasOne(Destination::class, 'id', 'from_location');
    // }
    // public function tolocation()
    // {
    //     return $this->hasOne(Destination::class, 'id', 'to_location');
    // }
}
