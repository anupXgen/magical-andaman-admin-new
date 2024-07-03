<?php

namespace Modules\BoatSchedule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BoatSchedule\Database\factories\BoatScheduleFactory;

class BoatSchedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'boat_schedule';

    protected $fillable = [
        'title',
        'image',
        'from_date',
        'to_date',
        'price',
        'status',
        'is_chartered_boat',
        'created_at',
        'updated_at'
       
    ];
  
    // protected $fillable = [];
    
    // protected static function newFactory(): BoatScheduleFactory
    // {
    //     //return BoatScheduleFactory::new();
    // }
}
