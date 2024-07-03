<?php

namespace Modules\SightSeeing\Entities;

use App\Models\Sightseeing_location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Destination\Entities\Destination;
use Modules\Package\Entities\Packagesightseeing;

class Sightseeing extends Model
{
    use HasFactory;
    protected $table = 'sight_seeings';
    protected $fillable = [
         'sightseeing_location', 'title', 'subtitle', 'location_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status', 'delete'
    ];
    public function sightseeingimage()
    {
        return $this->hasMany(Sightseeingimage::class, 'parent_id');
    }
  
    public function sightseeinglocation()
    {
        return $this->belongsTo(Destination::class, 'location');
    }
    public function package() 
    {
        return $this->hasOne(Packagesightseeing::class, 'sightseeing_id');
    }

    public function location()
    {
        return $this->belongsTo(Destination::class, 'location_id');
    }

    public function sight_location()
    {
        return $this->hasMany(Sightseeing_location::class, 'sightseeing_id');
    }
}
