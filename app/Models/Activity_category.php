<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_category extends Model
{
    use HasFactory;
    Protected $table='activity_category';
    protected $fillable=[
        'category_title',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'status',
        'delete',

    ];
}
