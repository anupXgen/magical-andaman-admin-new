<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Custom_packages extends Model
{
    use HasFactory;
    protected $table = 'custom_packages';

    protected $fillable = [
        'user_id',
        'package_id',
        'no_of_pax',
        'date_of_journey',
        'email',
        'mobile_no',
        'car_type',
        'status',
        'delete',
        'created_at',
        'updated_at',
    ];
    public function package_booking_details()
    {
        // return $this->hasOne(Package_booking_details::class, 'package_id');
        return $this->hasOne(Package_booking_details::class, 'custom_package_id', 'id');
        
    }
    public function custom_package_activity()
    {
        // return $this->hasOne(Package_booking_details::class, 'package_id');
        return $this->hasMany(Custom_package_activity::class, 'custom_package_id', 'id');
        
    }
    public function custom_package_hotel()
    {
        // return $this->hasOne(Package_booking_details::class, 'package_id');
        return $this->hasMany(Custom_package_hotel::class, 'custom_package_id', 'id');
        
    }
    public function custom_package_sighseeing()
    {
        // return $this->hasOne(Package_booking_details::class, 'package_id');
        return $this->hasMany(Custom_package_sighseeing::class, 'custom_package_id', 'id');
        
    }
    public function car()
    {
        return $this->belongsTo(Cars::class, 'car_type', 'id');
    }
}
