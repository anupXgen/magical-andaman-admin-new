<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;
    Protected $table='activitys';
    protected $fillable=[
        'title',
        'subtitle',
        'activity_category',
        'location_id',
        'price',
        'status',
        'delete',
        'created_at',
        'updated_at',

    ];
}
