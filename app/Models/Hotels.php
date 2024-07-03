<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Hotel\Entities\Hotelimage;
use Modules\Hotel\Entities\Room;
use Modules\Hotel\Entities\Roomimage;
use Modules\Destination\Entities\Destination;

class Hotels extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'hotels';
   

    protected $fillable = [
        'title',
        'subtitle',
        'location_id',
        'city_limit',
        'status',
        'created_at',
        'created_by',
        'delete',
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
    public function hotel_facility()
    {
        return $this->hasOne(Hotel_facility::class, 'hotel_id');
    }
    public function hotel_price()
    {
        return $this->hasMany(Hotel_price::class, 'hotel_id');
    }
}
