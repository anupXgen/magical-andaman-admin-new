<?php

namespace Modules\BookingDetails\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BookingDetails\Database\factories\BookingDetailsFactory;

class BookingDetails extends Model
{
    use HasFactory;
    protected $table = 'booking';

    protected $fillable = [
        'schedule_id',
        'type',
        'order_id',
        'c_name',
        'c_email',
        'c_mobile',
        'user_id',
        'departure_time',
        'arrival_time',
        'payment_status',
        'amount',
        'ship_name',
        'no_of_passenger',
        'date_of_jurney',
        'return_date',
        'from_location',
        'to_location',
        'trip_id',
        'vessel_id',
        'ferry_class',
        'nautika_class',
        'makruzz_class',
        'green_ocean_class',
        'trip_type',
        'request_for_cancel',
        'request_for_cancel_date',
        'created_at',
        'updated_at',
        'status',   
    ];
    
    // protected static function newFactory(): BookingDetailsFactory
    // {
    //     //return BookingDetailsFactory::new();
    // }
}
