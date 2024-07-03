<?php

namespace Modules\Cab\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Destination\Entities\Destination;

class Cab extends Model
{
    use HasFactory;
    protected $table = 'cabs';
    protected $fillable = [
        'to_location', 'from_location', 'title', 'subtitle', 'price', 'seat_count', 'luggage_count', 'ac', 'first_aid', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status', 'delete'
    ];
    public function cabimage()
    {
        return $this->hasMany(Cabimage::class, 'parent_id');
    }
    public function fromlocation()
    {
        return $this->hasOne(Destination::class, 'id', 'from_location');
    }
    public function tolocation()
    {
        return $this->hasOne(Destination::class, 'id', 'to_location');
    }
}
