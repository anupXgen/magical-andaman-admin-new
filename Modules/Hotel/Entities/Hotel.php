<?php

namespace Modules\Hotel\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Destination\Entities\Destination;

class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hotels';
    protected $fillable = [
       'location_id', 'title', 'subtitle', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status', 'delete'
    ];
    public function hotelimage()
    {
        return $this->hasMany(Hotelimage::class, 'parent_id');
    }
    public function room()
    {
        return $this->hasMany(Room::class, 'hotel_id');
    }
    public function location()
    {
        return $this->hasOne(Destination::class, 'id', 'location_id');
    }
    public function hotellocation()
    {
        return $this->belongsTo(Destination::class, 'location_id');
    }
    public function package()
    {
        return $this->hasOne(Packagehotel::class, 'hotel_id');
    }
}
