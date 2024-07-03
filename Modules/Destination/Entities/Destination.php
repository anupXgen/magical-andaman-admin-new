<?php

namespace Modules\Destination\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Hotel\Entities\Hotel;
use Modules\Sightseeing\Entities\Sightseeing;

class Destination extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $fillable = [
        'name', 'subtitle', 'path', 'size', 'created_at', 'updated_at', 'status', 'delete'
    ];
    public function cabformlocation()
    {
        return $this->belongsTo(cab::class, 'from_location', 'id');
    }
    public function cabtolocation()
    {
        return $this->belongsTo(cab::class, 'to_location', 'id');
    }
    public function sightseeinglocation()
    {
        return $this->belongsTo(Sightseeing::class, 'location_id', 'id');
    }
    public function hotellocation()
    {
        return $this->belongsTo(Hotel::class, 'location_id', 'id');
    }
    public function packagehotellocation()
    {
        return $this->hasMany(Hotel::class, 'location_id');
    }
    public function packagesightseeinglocation()
    {
        return $this->hasMany(Sightseeing::class, 'location_id');
    }
}
