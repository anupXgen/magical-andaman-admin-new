<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package_booking_details extends Model
{
    use HasFactory;
    protected $table = 'package_booking_details';

    protected $fillable = [
        'user_id',
        'custom_package_id',
        'journey_date',
        'email',
        'mobile_no',
        'payment_status',
        'order_id',
        'invoice_id',
        'status',
        'delete',
        'created_at',
        'updated_at',
    ];

}
