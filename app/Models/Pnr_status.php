<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pnr_status extends Model
{
    use HasFactory;
    protected $table = 'pnr_status';

    protected $fillable = [
        'user_id',
        'pnr_id',
        'order_id',
        'razorpay_payment_id',
        'created_at',
        'status',
    ];
}
