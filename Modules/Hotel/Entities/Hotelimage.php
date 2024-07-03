<?php

namespace Modules\Hotel\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotelimage extends Model
{
    use HasFactory;
    protected $table = 'hotel_images';
    public $timestamps = false;
    protected $fillable = [
        'path', 'parent_id','size'
    ];
    public function hotel()
    {
        return $this->belongsTo(hotel::class, 'parent_id');
    }
}
