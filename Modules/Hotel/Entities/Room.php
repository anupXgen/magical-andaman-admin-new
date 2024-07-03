<?php

namespace Modules\Hotel\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    protected $fillable = [
        'hotel_id', 'title', 'subtitle', 'max_pax', 'room_count', 'created_at', 'price_per_day', 'updated_at', 'created_by', 'updated_by', 'status', 'deleted'
    ];
    public function roomimage()
    {
        return $this->hasMany(Roomimage::class, 'parent_id');
    }
    public function hotel()
    {
        return $this->hasMany(Room::class, 'hotel_id');
    }
}
